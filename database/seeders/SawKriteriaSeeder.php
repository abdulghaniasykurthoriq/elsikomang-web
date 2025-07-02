<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SawKriteria;

class SawKriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $kriterias = [
            [
                'nama' => 'harga_tiket',
                'label' => 'Harga Tiket',
                'tipe' => 'cost',
            ],
            [
                'nama' => 'fasilitas',
                'label' => 'Fasilitas (Jumlah)',
                'tipe' => 'benefit',
            ],
            [
                'nama' => 'rating',
                'label' => 'Rating',
                'tipe' => 'benefit',
            ],
            [
                'nama' => 'waktu_operasional',
                'label' => 'Jam Operasional (Durasi)',
                'tipe' => 'benefit',
            ],
        ];

        foreach ($kriterias as $item) {
            SawKriteria::updateOrCreate(['nama' => $item['nama']], $item);
        }
    }
}
