<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PariwisataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('pariwisatas')->insert([
                'nama'       => 'Produk ' . $i,
                'deskripsi'  => 'Deskripsi menarik untuk Produk ' . $i,
                'image'      => 'https://picsum.photos/seed/produk' . $i . '/300/200',
                'link'       => 'https://example.com/produk/' . $i,
                'rate'       => rand(1, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
