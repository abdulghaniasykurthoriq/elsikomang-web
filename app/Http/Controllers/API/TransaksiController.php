<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|integer|min:10000',
            'payment_method_code' => 'required|in:bni_va,mandiri_va,bri_va',
        ]);

        $orderId = 'TRX' . now()->format('YmdHis') . rand(1000, 9999); // order_id unik
        $amount = $validatedData['amount'];

        $params = $this->buildMidtransParams([
            'order_id' => $orderId,
            'amount' => $amount,
            'payment_method' => $validatedData['payment_method_code'],
        ]);

        $midtrans = $this->callMidtrans($params);

        DB::beginTransaction();
        try {
            $transaction = Transaksi::create([
                'user_id' => auth()->user()->id,
                'order_id' => $orderId,
                'amount' => $amount,
                'payment_method' => $validatedData['payment_method_code'],
                'snap_token' => $midtrans['token'],
                'snap_redirect_url' => $midtrans['redirect_url'],
                'status' => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Transaksi berhasil dibuat',
                'data' => $transaction
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Transaksi gagal dibuat',
                'error' => $th->getMessage()
            ], 500);
        }
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
