<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SawBobot;

class SawBobotSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kriteria' => 'harga_tiket', 'bobot' => 0.25],
            ['kriteria' => 'fasilitas', 'bobot' => 0.25],
            ['kriteria' => 'rating', 'bobot' => 0.25],
            ['kriteria' => 'waktu_operasional', 'bobot' => 0.25],
        ];

        foreach ($data as $item) {
            SawBobot::updateOrCreate(
                ['kriteria' => $item['kriteria']],
                ['bobot' => $item['bobot']]
            );
        }
    }
}
