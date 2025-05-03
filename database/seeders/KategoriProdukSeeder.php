<?php

namespace Database\Seeders;

// use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class KategoriProdukSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_produk')->insert([
            ['name' => 'Makanan'],
            ['name' => 'Minuman'],
            ['name' => 'Fashion'],
            ['name' => 'Kerajinan Tangan'],
            ['name' => 'Elektronik'],
        ]);
        
        //
    }
}
