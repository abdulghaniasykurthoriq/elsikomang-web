<?php

namespace Database\Seeders;

use App\Models\Keranjang;
use App\Models\KeranjangDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeranjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Keranjang::create([
            'user_id' => 2,
            'member_id' => 1,
        ]);
        KeranjangDetail::create([
            'keranjang_id' => 1,
            'produk_umkm_id' => 1,
            'produk_variant_id' => 1,
            'jumlah' => 2,
        ]);


    }
}
