<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VoucherController extends Controller
{
    protected $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function cek(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required|string',
            'total_transaksi' => 'required|numeric|min:0',
        ]);

        // Default jumlah_pemakaian ke 1 jika tidak dikirim
        $jumlah = (int) ($request->input('jumlah_pemakaian') ?? 1);

        $result = $this->voucherService->cekVoucher(
            $request->kode_voucher,
            $request->total_transaksi,
            $jumlah
        );

        return response()->json($result, $result['http_code']);
    }


}
