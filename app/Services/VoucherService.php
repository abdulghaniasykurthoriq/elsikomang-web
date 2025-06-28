<?php

namespace App\Services;

use App\Models\Voucher;
use Carbon\Carbon;

class VoucherService
{
    public function cekVoucher(string $kode, float $total, int $jumlahPemakaian = 1): array
    {
        $voucher = Voucher::where('kode_voucher', $kode)
            ->where('is_aktif', true)
            ->whereDate('tanggal_mulai', '<=', Carbon::today())
            ->whereDate('tanggal_berakhir', '>=', Carbon::today())
            ->lockForUpdate()
            ->first();

        if (!$voucher) {
            return [
                'status' => false,
                'message' => 'Voucher tidak ditemukan atau tidak berlaku.',
                'http_code' => 404
            ];
        }

        if ($voucher->kuota < $jumlahPemakaian) {
            return [
                'status' => false,
                'message' => "Voucher hanya tersedia untuk {$voucher->kuota} transaksi lagi.",
                'http_code' => 400
            ];
        }

        if ($total < $voucher->minimum_transaksi) {
            return [
                'status' => false,
                'message' => 'Total transaksi belum memenuhi minimum penggunaan voucher.',
                'minimum_transaksi' => $voucher->minimum_transaksi,
                'http_code' => 400
            ];
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

        // Kurangi kuota
        $voucher->kuota -= $jumlahPemakaian;
        $voucher->save();

        return [
            'status' => true,
            'message' => 'Voucher valid.',
            'data' => [
                'kode_voucher' => $voucher->kode_voucher,
                'tipe_diskon' => $voucher->tipe_diskon,
                'nilai_diskon' => $voucher->nilai_diskon,
                'maks_diskon' => $voucher->maks_diskon,
                'potongan' => round($diskon, 2),
                'total_setelah_diskon' => round(max(0, $total - $diskon), 2),
            ],
            'http_code' => 200
        ];
    }
}
