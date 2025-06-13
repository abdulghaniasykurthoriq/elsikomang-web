<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now()->toDateTimeString();

        DB::table('provinsis')->insert([
            ['id' => 1, 'nama' => 'NANGGROE ACEH DARUSSALAM (NAD)', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'nama' => 'SUMATERA UTARA', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'nama' => 'RIAU', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'nama' => 'SUMATERA SELATAN', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'nama' => 'MALUKU UTARA', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'nama' => 'SUMATERA BARAT', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'nama' => 'SULAWESI UTARA', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'nama' => 'KALIMANTAN SELATAN', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9, 'nama' => 'KALIMANTAN TIMUR', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'nama' => 'KEPULAUAN RIAU', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 11, 'nama' => 'DKI JAKARTA', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 12, 'nama' => 'GORONTALO', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 13, 'nama' => 'SULAWESI TENGGARA', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 14, 'nama' => 'NUSA TENGGARA TIMUR (NTT)', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 15, 'nama' => 'JAWA TENGAH', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 16, 'nama' => 'SULAWESI TENGAH', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 17, 'nama' => 'KALIMANTAN BARAT', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 18, 'nama' => 'PAPUA BARAT', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 19, 'nama' => 'LAMPUNG', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 20, 'nama' => 'KALIMANTAN UTARA', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 21, 'nama' => 'SULAWESI SELATAN', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 22, 'nama' => 'NUSA TENGGARA BARAT (NTB)', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 23, 'nama' => 'MALUKU', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 24, 'nama' => 'KALIMANTAN TENGAH', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 25, 'nama' => 'JAWA BARAT', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 26, 'nama' => 'BENGKULU', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 27, 'nama' => 'BANTEN', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 28, 'nama' => 'JAMBI', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 29, 'nama' => 'PAPUA', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 30, 'nama' => 'BALI', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 31, 'nama' => 'JAWA TIMUR', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 32, 'nama' => 'SULAWESI BARAT', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 33, 'nama' => 'BANGKA BELITUNG', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 34, 'nama' => 'DI YOGYAKARTA', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 35, 'nama' => 'PAPUA TENGAH', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
