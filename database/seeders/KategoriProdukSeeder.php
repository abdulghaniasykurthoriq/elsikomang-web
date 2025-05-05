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
            ['id' => 1,'name' => 'Makanan'],
            ['id' => 2,'name' => 'Minuman'],
            ['id' => 3,'name' => 'Fashion'],
            ['id' => 4,'name' => 'Kerajinan Tangan'],
            ['id' => 5,'name' => 'Elektronik',],
        ]);

    }
}
