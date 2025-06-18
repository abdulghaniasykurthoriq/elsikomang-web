<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\KeranjangDetail;
use App\Models\ProdukVariant;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.produk_variant_id' => 'required|exists:produk_variants,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();
        $items = $validatedData['items'];

        $orderId = 'TRX' . now()->format('YmdHis') . rand(1000, 9999);
        $pay_method = 'bri_va';
        $amount = 0;

        $variants = [];

        foreach ($items as $item) {
            $variant = ProdukVariant::with('produk_umkm')->find($item['produk_variant_id']);

            if (!$variant || !$variant->produk_umkm) {
                return response()->json([
                    'message' => 'Produk atau varian tidak ditemukan.',
                    'variant_id' => $item['produk_variant_id'],
                ], 404);
            }

            if ($variant->harga < 0.01) {
                return response()->json([
                    'message' => 'Harga produk tidak valid (kurang dari 0.01)',
                    'produk_id' => $variant->produk_umkm->id,
                    'harga' => $variant->harga,
                ], 422);
            }

            $variants[$item['produk_variant_id']] = $variant;
            $amount += $variant->harga * $item['qty'];
        }

        if ($amount < 0.01) {
            return response()->json([
                'message' => 'Total transaksi tidak valid (kurang dari 0.01)',
                'amount' => $amount,
            ], 422);
        }

        $params = $this->buildMidtransParams([
            'order_id' => $orderId,
            'amount' => $amount,
            'payment_method' => $pay_method,
        ]);
        $midtrans = $this->callMidtrans($params);

        DB::beginTransaction();
        try {
            $transaction = Transaksi::create([
                'user_id' => auth()->id(),
                'order_id' => $orderId,
                'amount' => $amount,
                'payment_method' => $pay_method,
                'snap_token' => $midtrans['token'],
                'snap_redirect_url' => $midtrans['redirect_url'],
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                $variant = $variants[$item['produk_variant_id']];

                TransaksiDetail::create([
                    'produk_id' => $variant->produk_umkm->id,
                    'transaksi_id' => $transaction->id,
                    'produk_variant_id' => $item['produk_variant_id'],
                    'qty' => $item['qty'],
                    'harga' => $variant->harga,
                ]);

                // Hapus dari keranjang
                $keranjang = Keranjang::where('user_id', auth()->id())->first();
                if ($keranjang) {
                    $keranjangDetail = KeranjangDetail::where('keranjang_id', $keranjang->id)
                        ->where('produk_variant_id', $item['produk_variant_id'])
                        ->first();

                    if ($keranjangDetail) {
                        if ($keranjangDetail->jumlah > $item['qty']) {
                            $keranjangDetail->jumlah -= $item['qty'];
                            $keranjangDetail->save();
                        } else {
                            $keranjangDetail->delete();
                        }
                    }
                }
            }

            // Cek sisa detail keranjang dan hapus keranjang kalau kosong
            $keranjang = Keranjang::where('user_id', auth()->id())->first();
            if ($keranjang && $keranjang->keranjangDetail()->count() === 0) {
                $keranjang->delete();
            }

            DB::commit();

            return response()->json([
                'message' => 'Transaksi berhasil dibuat',
                'snap_token' => $transaction->snap_token,
                'redirect_url' => $transaction->snap_redirect_url,
                'data' => $transaction,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Transaksi gagal dibuat',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        $transaction = Transaksi::with(['transaksiDetail.produkUmkm','transaksiDetail.produkVariant'])
            ->where('user_id', auth()->id())
            ->get();

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }

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
        \Log::info('Callback from Midtrans', $request->all());

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION');

        $notif = new \Midtrans\Notification();

        $transactionStatus = $notif->transaction_status;
        $fraudStatus = $notif->fraud_status;
        $transactionCode = $notif->order_id;
        $signatureKey = $notif->signature_key;

        // Optional: Validasi Signature Key
        $expectedSignature = hash('sha512',
            $notif->order_id .
            $notif->status_code .
            $notif->gross_amount .
            env('MIDTRANS_SERVER_KEY')
        );

        if ($signatureKey !== $expectedSignature) {
            \Log::warning('Invalid Signature Key', ['expected' => $expectedSignature, 'got' => $signatureKey]);
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        DB::beginTransaction();
        try {
            $status = match($transactionStatus) {
                'capture' => $fraudStatus === 'accept' ? 'success' : 'pending',
                'settlement' => 'success',
                'pending' => 'pending',
                'deny', 'cancel', 'expire' => 'failed',
                default => 'unknown',
            };

            $transaction = Transaksi::where('order_id', $transactionCode)->first();

            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            $transaction->update([
                'status' => $status,
            ]);

            DB::commit();
            return response()->json(['message' => 'Callback processed'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error('Callback error', ['exception' => $th]);
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function success()
    {
        return response()->json([
            'message' => 'Transaksi berhasil'
        ]);
    }

}
