<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use App\Models\Keranjang;
use App\Models\KeranjangDetail;
use App\Models\ProdukVariant;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    protected $voucherService;
    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.produk_variant_id' => 'required|exists:produk_variants,id',
            'items.*.qty' => 'required|integer|min:1',
            'alamat_id' => 'required|exists:alamats,id',
            'selected_couriers' => 'required|array|min:1',
            'selected_couriers.*.member_id' => 'required|exists:member_umkm,id',
            'selected_couriers.*.code' => 'required|string',
            'selected_couriers.*.service' => 'required|string',
            'kode_voucher' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $items = $request->items;
        $alamat_id = $request->alamat_id;
        $selectedCouriers = collect($request->selected_couriers)->keyBy('member_id');
        $groupedItems = [];
        $variants = [];

        foreach ($items as $item) {
            $variant = ProdukVariant::with('produk_umkm')->find($item['produk_variant_id']);
            if (!$variant || !$variant->produk_umkm) {
                return response()->json([
                    'message' => 'Produk atau varian tidak ditemukan.',
                    'variant_id' => $item['produk_variant_id'],
                ], 404);
            }

            $memberId = $variant->produk_umkm->member_id;
            $variants[$item['produk_variant_id']] = $variant;

            $groupedItems[$memberId][] = [
                'variant' => $variant,
                'qty' => $item['qty'],
            ];
        }

        $alamat = Alamat::findOrFail($alamat_id);
        $destination = $alamat->desa_id;

        DB::beginTransaction();
        try {
            $transactions = [];
            

            foreach ($groupedItems as $memberId => $memberItems) {
                $orderId = 'TRX' . now()->format('YmdHis') . rand(1000, 9999);
                $pay_method = 'bri_va';
                $subtotal = 0;
                $weight = 0;

                foreach ($memberItems as $item) {
                    $subtotal += $item['variant']->harga * $item['qty'];
                    $weight += ($item['variant']->berat ?? 0) * $item['qty'];
                }

                $origin = $memberItems[0]['variant']->produk_umkm->member_desa_id 
                    ?? $memberItems[0]['variant']->produk_umkm->member->desa_id;

                $courierInfo = $selectedCouriers->get($memberId);
                if (!$courierInfo) {
                    throw new \Exception("Kurir tidak dipilih untuk member_id $memberId");
                }

                $ongkirResponse = Http::post('https://elsikomangdev.my.id/api/cek-ongkir', [
                    'origin' => $origin,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $courierInfo['code']
                ]);

                if (!$ongkirResponse->ok()) {
                    throw new \Exception("Gagal cek ongkir untuk member_id {$memberId} dengan response: " . $ongkirResponse->body());
                }

                $costData = collect($ongkirResponse->json()['data']['data'] ?? [])
                    ->first(function ($cost) use ($courierInfo) {
                        return strtolower($cost['code']) === strtolower($courierInfo['code']) &&
                            strtolower($cost['service']) === strtolower($courierInfo['service']);
                    });



                if (!$costData) {
                    throw new \Exception("Service {$courierInfo['service']} tidak ditemukan untuk member_id $memberId");
                }

                $ongkos = $costData['cost'];
                $amount = $subtotal + $ongkos;
                
                // if ($request->kode_voucher) {
                //     $cek = $this->voucherService->cekVoucher(
                //         $request->kode_voucher,
                //         $amount
                //     );
            
                //     if ($cek['http_code'] !== 200) {
                //         return response()->json([
                //             'message' => 'Transaksi gagal',
                //             'error' => $cek['message'],
                //         ], $cek['http_code']);
                //     }
                //     $amount = $cek['data']['total_setelah_diskon'];
                // }                
                


                $params = $this->buildMidtransParams([
                    'order_id' => $orderId,
                    'amount' => $amount,
                    'payment_method' => $pay_method,
                ]);

                $midtrans = $this->callMidtrans($params);

                $transaction = Transaksi::create([
                    'user_id' => auth()->id(),
                    'member_id' => $memberId,
                    'alamat_id' => $alamat_id,
                    'order_id' => $orderId,
                    'amount' => $amount,
                    'total_ongkos' => $ongkos,
                    'payment_method' => $pay_method,
                    'snap_token' => $midtrans['token'],
                    'snap_redirect_url' => $midtrans['redirect_url'],
                    'status' => 'pending',
                    'kode_voucher' => $request->kode_voucher ?? null,
                    'kurir' => $courierInfo['code'] ?? null,
                    'kurir_service' => $courierInfo['service'] ?? null,
                    'no_resi' => null
                ]);

                foreach ($memberItems as $item) {
                    TransaksiDetail::create([
                        'produk_id' => $item['variant']->produk_umkm->id,
                        'transaksi_id' => $transaction->id,
                        'produk_variant_id' => $item['variant']->id,
                        'qty' => $item['qty'],
                        'harga' => $item['variant']->harga,
                    ]);

                    $keranjang = Keranjang::where('user_id', auth()->id())->first();
                    if ($keranjang) {
                        $detail = KeranjangDetail::where('keranjang_id', $keranjang->id)
                            ->where('produk_variant_id', $item['variant']->id)
                            ->first();

                        if ($detail) {
                            if ($detail->jumlah > $item['qty']) {
                                $detail->jumlah -= $item['qty'];
                                $detail->save();
                            } else {
                                $detail->delete();
                            }
                        }
                    }
                }

                $transactions[] = $transaction;
            }

            $keranjang = Keranjang::where('user_id', auth()->id())->first();
            if ($keranjang && $keranjang->keranjangDetail()->count() === 0) {
                $keranjang->delete();
            }
            

            //AGAT
            // if ($request->kode_voucher) {
            //     $pakai = $this->voucherService->pakaiVoucher(
            //         $request->kode_voucher,
            //         count($groupedItems)
            //     );
        
            //     if (!$pakai['status']) {
            //         DB::rollBack();
            //         return response()->json([
            //             'message' => 'Transaksi gagal',
            //             'error' => $pakai['message'],
            //         ], 400);
            //     }
            // }
            

            DB::commit();

            return response()->json([
                'message' => 'Transaksi berhasil dibuat',
                'data' => $transactions,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Transaksi gagal',
                'error' => $th->getMessage(),
            ], 500);
        }
    }





    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Transaksi::with(['transaksiDetail.produkUmkm', 'transaksiDetail.produkVariant'])
            ->where('user_id', auth()->id());

        if ($status) {
            $query->where('status', $status);
        }

        $transaction = $query->get();

        return response()->json([
            'message' => 'Transaksi ditemukan',
            'data' => $transaction,
        ]);
    }



    public function countByStatus()
    {
        $counts = Transaksi::where('user_id', auth()->id())
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'message' => 'Statistik transaksi berhasil diambil',
            'data' => $counts,
        ]);
    }












    











    private function callMidtrans(array $params)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION');
        \Midtrans\Config::$isSanitized = (bool) env('MIDTRANS_IS_SANITIZED');
        \Midtrans\Config::$is3ds = (bool) env('MIDTRANS_IS_3DS');

        $createTransaction = \Midtrans\Snap::createTransaction($params);

        return [
            'redirect_url' => $createTransaction->redirect_url,
            'token' => $createTransaction->token
        ];
    }

    private function buildMidtransParams(array $params)
    {
        $transactionDetails = [
            'order_id' => $params['order_id'],
            'gross_amount' => $params['amount'],
        ];

        $user = auth()->user();
        $splitName = $this->splitName($user->name);

        $customerDetails = [
            'first_name' => $splitName['first_name'],
            'last_name' => $splitName['last_name'],
            'email' => $user->email
        ];

        $enabledPayments = [
            $params['payment_method']
        ];

        return [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'enabled_payments' => $enabledPayments,
        ];
    }

    private function splitName($fullName)
    {
        $name = explode(' ', $fullName);
        $lastName = count($name) > 1 ? array_pop($name) : '';
        $firstName = implode(' ', $name);
        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
        ];
    }

    public function update(Request $request)
    {
        // ✅ Logging awal callback
        \Log::info('🔥 Callback HIT', ['request' => $request->all()]);

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            $notif = new \Midtrans\Notification();

            // ✅ Logging isi notifikasi
            \Log::info('🔥 Midtrans Notification Received', [
                'order_id' => $notif->order_id,
                'status_code' => $notif->status_code,
                'gross_amount' => $notif->gross_amount,
                'transaction_status' => $notif->transaction_status,
                'fraud_status' => $notif->fraud_status,
                'signature_key' => $notif->signature_key,
            ]);

            // Signature Validation
            $expectedSignature = hash('sha512',
                $notif->order_id .
                $notif->status_code .
                $notif->gross_amount .
                env('MIDTRANS_SERVER_KEY')
            );

            if ($notif->signature_key !== $expectedSignature) {
                \Log::warning('❌ Invalid Signature Key', [
                    'expected' => $expectedSignature,
                    'received' => $notif->signature_key,
                ]);
                return response()->json(['message' => 'Invalid signature key'], 403);
            }

            // Mapping status
            $status = match ($notif->transaction_status) {
                'capture' => $notif->fraud_status === 'accept' ? 'success' : 'pending',
                'settlement' => 'success',
                'pending' => 'pending',
                'deny', 'cancel', 'expire' => 'failed',
                default => 'unknown',
            };

            $transaction = Transaksi::where('order_id', $notif->order_id)->first();

            if (!$transaction) {
                \Log::warning('⚠️ Transaksi tidak ditemukan', ['order_id' => $notif->order_id]);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            $transaction->update([
                'status' => $status,
            ]);

            \Log::info('✅ Transaksi berhasil diupdate', [
                'order_id' => $notif->order_id,
                'status' => $status,
            ]);

            return response()->json(['message' => 'Callback processed'], 200);
        } catch (\Throwable $th) {
            \Log::error('❌ Callback error', ['exception' => $th->getMessage()]);
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }


    // public function update(Request $request)
    // {
    //     \Log::info('🔥 Callback HIT', ['data' => $request->all()]);
    //     \Log::info('Callback from Midtrans', $request->all());

    //     \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION');

    //     $notif = new \Midtrans\Notification();
    //     \Log::info('notif midtrans', $notif);
    //     \Log::info('notif midtrans', $notif);
    //     \Log::info('notif midtrans', $notif);
    //     \Log::info('notif midtrans', $notif);

    //     $transactionStatus = $notif->transaction_status;
    //     $fraudStatus = $notif->fraud_status;
    //     $transactionCode = $notif->order_id;
    //     $signatureKey = $notif->signature_key;

        

    //     // Optional: Validasi Signature Key
    //     $expectedSignature = hash('sha512',
    //         $notif->order_id .
    //         $notif->status_code .
    //         $notif->gross_amount .
    //         env('MIDTRANS_SERVER_KEY')
    //     );

    //     if ($signatureKey !== $expectedSignature) {
    //         \Log::warning('Invalid Signature Key', ['expected' => $expectedSignature, 'got' => $signatureKey]);
    //         return response()->json(['message' => 'Invalid signature key'], 403);
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $status = match($transactionStatus) {
    //             'capture' => $fraudStatus === 'accept' ? 'success' : 'pending',
    //             'settlement' => 'success',
    //             'pending' => 'pending',
    //             'deny', 'cancel', 'expire' => 'failed',
    //             default => 'unknown',
    //         };

    //         $transaction = Transaksi::where('order_id', $transactionCode)->first();

    //         if (!$transaction) {
    //             return response()->json(['message' => 'Transaction not found'], 404);
    //         }

    //         $transaction->update([
    //             'status' => $status,
    //         ]);

    //         DB::commit();
    //         return response()->json(['message' => 'Callback processed'], 200);
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         \Log::error('Callback error', ['exception' => $th]);
    //         return response()->json(['message' => $th->getMessage()], 500);
    //     }
    // }

    public function success()
    {
        return response()->json([
            'message' => 'Transaksi berhasil'
        ]);
    }

}
