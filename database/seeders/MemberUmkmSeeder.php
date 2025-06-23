<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class MemberUmkmSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah ada desas dengan id = 1
        $desaId = DB::table('desas')->value('id') ?? 1;

        // Dummy data
        DB::table('member_umkm')->insert([
            [
                'nama_toko' => 'Toko Sejahtera',
                'alamat' => 'Jl. Anggrek No. 12, Indramayu',
                'no_hp' => '081234567890',
                'foto_toko' => 'foto_toko/toko-dummy1.png',
                'desa_id' => $desaId,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_toko' => 'UMKM Makmur Jaya',
                'alamat' => 'Jl. Sawo No. 23, Indramayu',
                'no_hp' => '082345678901',
                'foto_toko' => 'foto_toko/toko-dummy2.png',
                'desa_id' => $desaId,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_toko' => 'Kedai Rakyat',
                'alamat' => 'Jl. Mangga No. 45, Indramayu',
                'no_hp' => '083456789012',
                'foto_toko' => 'foto_toko/toko-dummy3.png',
                'desa_id' => $desaId,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
