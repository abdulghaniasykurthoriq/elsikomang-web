<?php

namespace Database\Seeders;

use App\Models\JenisOperator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisOperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisOperator::create([
            'name' => 'Umkm',
            'url' => 'operator?role=umkm',
        ]);

        JenisOperator::create([
            'name' => 'Pariwisata',
            'url' => 'operator?role=pariwisata',
        ]);
        JenisOperator::create([
            'name' => 'Investasi',
            'url' => 'operator?role=investasi',
        ]);
        JenisOperator::create([
            'name' => 'Event',
            'url' => 'operator?role=event',
        ]);

        JenisOperator::create([
            'name' => 'Entertiment',
            'url' => 'operator?role=entertaiment',
        ]);
        JenisOperator::create([
            'name' => 'Box Office',
            'url' => 'operator?role=box-office',
        ]);
    }
}
