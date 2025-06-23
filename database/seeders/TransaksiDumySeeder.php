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
    public function run(): void
    {
        $produkId = 1;
        $produkVariantId = 1;
        $transaksiId = 1;

        for ($tahun = 2021; $tahun <= 2025; $tahun++) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                // 8–12 transaksi per bulan biar variasi
                $jumlahTransaksi = rand(8, 12);
                for ($i = 1; $i <= $jumlahTransaksi; $i++) {
                    $harga = match (rand(1, 10)) {
                        1 => 100000,
                        2, 3 => 75000,
                        default => Arr::random([15000, 20000, 25000, 30000, 750000])
                    };

                    if ($tahun < 2025 || $bulan <= 5) {
                        TransaksiDetail::create([
                            'produk_id' => $produkId,
                            'transaksi_id' => $transaksiId,
                            'produk_variant_id' => $produkVariantId,
                            'qty' => rand(1, 5),
                            'harga' => $harga,
                            'created_at' => Carbon::create($tahun, $bulan, rand(1, 28)),
                        ]);
                    }
                    
                }
            }
        }
    }
}
