<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VoucherController extends Controller
{

    public function cek(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required|string',
            'total_transaksi' => 'required|numeric|min:0',
        ]);

        $kode = $request->kode_voucher;
        $total = $request->total_transaksi;

        $voucher = Voucher::where('kode_voucher', $kode)
            ->where('is_aktif', true)
            ->whereDate('tanggal_mulai', '<=', Carbon::today())
            ->whereDate('tanggal_berakhir', '>=', Carbon::today())
            ->first();

        if (!$voucher) {
            return response()->json([
                'status' => false,
                'message' => 'Voucher tidak ditemukan atau tidak berlaku.'
            ], 404);
        }

        if ($voucher->kuota <= 0) {
            return response()->json([
                'status' => false,
                'message' => 'Voucher sudah habis kuotanya.'
            ], 400);
        }

        if ($total < $voucher->minimum_transaksi) {
            return response()->json([
                'status' => false,
                'message' => 'Total transaksi belum memenuhi minimum penggunaan voucher.',
                'minimum_transaksi' => $voucher->minimum_transaksi
            ], 400);
        }

        // Hitung diskon
        $diskon = 0;
        if ($voucher->tipe_diskon === 'persen') {
            $diskon = ($voucher->nilai_diskon / 100) * $total;
            if ($voucher->maks_diskon && $diskon > $voucher->maks_diskon) {
                $diskon = $voucher->maks_diskon;
            }
        } else {
            $diskon = $voucher->nilai_diskon;
        }

        return response()->json([
            'status' => true,
            'message' => 'Voucher valid.',
            'data' => [
                'kode_voucher' => $voucher->kode_voucher,
                'tipe_diskon' => $voucher->tipe_diskon,
                'nilai_diskon' => $voucher->nilai_diskon,
                'maks_diskon' => $voucher->maks_diskon,
                'potongan' => round($diskon, 2),
                'total_setelah_diskon' => round(max(0, $total - $diskon), 2),
            ]
        ]);
    }

    
    function validasiVoucher(string $kodeVoucher, float $totalTransaksi): array
    {
        $voucher = Voucher::where('kode_voucher', $kodeVoucher)
            ->where('is_aktif', true)
            ->whereDate('tanggal_mulai', '<=', Carbon::today())
            ->whereDate('tanggal_berakhir', '>=', Carbon::today())
            ->first();

        if (!$voucher) {
            return [
                'status' => false,
                'message' => 'Voucher tidak ditemukan atau tidak berlaku.',
            ];
        }

        if ($voucher->kuota <= 0) {
            return [
                'status' => false,
                'message' => 'Voucher sudah habis kuotanya.',
            ];
        }

        if ($totalTransaksi < $voucher->minimum_transaksi) {
            return [
                'status' => false,
                'message' => 'Total transaksi belum memenuhi syarat minimum penggunaan voucher.',
            ];
        }

        // Hitung diskon
        if ($voucher->tipe_diskon === 'persen') {
            $diskon = ($voucher->nilai_diskon / 100) * $totalTransaksi;
            if ($voucher->maks_diskon && $diskon > $voucher->maks_diskon) {
                $diskon = $voucher->maks_diskon;
            }
        } else {
            $diskon = $voucher->nilai_diskon;
        }

        return [
            'status' => true,
            'message' => 'Voucher berhasil digunakan.',
            'voucher' => $voucher,
            'potongan' => round($diskon, 2),
            'total_setelah_diskon' => round(max(0, $totalTransaksi - $diskon), 2),
        ];
    }
}
