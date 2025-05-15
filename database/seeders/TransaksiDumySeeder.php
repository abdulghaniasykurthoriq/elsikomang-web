<?php

namespace Database\Seeders;

use App\Models\ProdukUmkm;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiDumySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    for ($i = 1; $i <= 5; $i++) {
        for ($m = 1; $m <= 5; $m++) {
            TransaksiDetail::create([
                'produk_id' => 1,
                'transaksi_id' => 1,
                'produk_variant_id' => 1,
                'qty' => rand(1, 10),
                'harga' => rand(1000, 5000),
                'created_at' => Carbon::create(2025, $m, rand(1, 28)),
            ]);
        }
    }
    }
}
