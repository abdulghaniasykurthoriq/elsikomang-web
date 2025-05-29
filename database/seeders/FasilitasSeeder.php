<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fasilitas;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Toilet',
            'Mushola',
            'Area Parkir',
            'Tempat Makan',
            'Wifi',
            'Spot Foto',
            'Pusat Informasi',
        ];

        foreach ($data as $nama) {
            Fasilitas::create(['nama' => $nama]);
        }
    }
}
