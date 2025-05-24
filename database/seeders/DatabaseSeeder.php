<?php

namespace Database\Seeders;

use App\Models\JenisOperator;
use App\Models\TransaksiDetail;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(JenisOperatorSeeder::class);  
        $this->call(UserSeeder::class);
        $this->call(KategoriProdukSeeder::class);
        $this->call(PariwisataSeeder::class);
        $this->call(CoverMenuSeeder::class);
        $this->call(ProdukUmkmSeeder::class);
        $this->call(KeranjangSeeder::class);
        $this->call(TransaksiDumySeeder::class);
        $this->call(IklanSeeder::class);

    }
}
