<?php

namespace Database\Seeders;

use App\Models\ProdukUmkm;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TransaksiDumySeeder extends Seeder
{
    // punya agat untuk transaksi detail jangan diganti yaa jol
    // punya agat untuk transaksi detail jangan diganti yaa jol
    // punya agat untuk transaksi detail jangan diganti yaa jol
    // punya agat untuk transaksi detail jangan diganti yaa jol
    public function run(): void
    {
        $produkId = 1;
        $produkVariantId = 1;
        $transaksiId = 1;

        $baseQty = 2; // rata-rata qty awal
        $growthRate = 0.06; // naik 6% per bulan
        $baseHarga = 25000; // harga stabil dasar

        for ($tahun = 2025; $tahun <= 2025; $tahun++) {
            for ($bulan = 1; $bulan <= 7; $bulan++) { // hanya Januari-Juli 2025
                $jumlahTransaksi = rand(10, 15); // variasi realistis

                // Hitung rata-rata qty bulan ini dengan tren naik
                $qtyBulanIni = (int) round($baseQty * pow(1 + $growthRate, $bulan - 1));

                for ($i = 1; $i <= $jumlahTransaksi; $i++) {
                    $qty = max(1, $qtyBulanIni + rand(-1, 1)); // sedikit variasi
                    $harga = $baseHarga + rand(-3000, 3000); // variasi harga ±3rb

                    TransaksiDetail::create([
                        'produk_id' => $produkId,
                        'transaksi_id' => $transaksiId++,
                        'produk_variant_id' => $produkVariantId,
                        'qty' => $qty,
                        'harga' => $harga,
                        'created_at' => Carbon::create($tahun, $bulan, rand(1, 28)),
                    ]);
                }
            }
        }
    }
}