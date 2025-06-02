<?php

namespace Database\Seeders;

use App\Models\Iklan;
use App\Models\IklanData;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class IklanSeeder extends Seeder
{
    public function run(): void
    {
        $iklan = Iklan::create([
            'id' => 1,
            'nama' => 'Home 1',
            'slug' => 'home-1'
        ]);
        $iklan = Iklan::create([
            'id' => 2,
            'nama' => 'Pariwisata 1',
            'slug' => 'pariwisata-1'
        ]);
        $iklan = Iklan::create([
            'id' => 3,
            'nama' => 'UMKM 1',
            'slug' => 'umkm-1'
        ]);
        $iklan = Iklan::create([
            'id' => 4,
            'nama' => 'Entertaiment 1',
            'slug' => 'entertaiment-1'
        ]);
        $iklan = Iklan::create([
            'id' => 5,
            'nama' => 'Investasi 1',
            'slug' => 'Investasi-1'
        ]);
        $iklan = Iklan::create([
            'id' => 6,
            'nama' => 'Event 1',
            'slug' => 'event-1'
        ]);
        IklanData   ::create([
            'iklan_id' => 1,
            'gambar' => 'produk_image/dummy.jpg',
            'link' => 'http://localhost:8000/produk_image/dummy.jpg',
            'status' => 'active',
            'expired_at' => Carbon::now()->addDays(7),
        ]);
        IklanData   ::create([
            'iklan_id' => 1,
            'gambar' => 'produk_image/dummy.jpg',
            'link' => 'http://localhost:8000/produk_image/dummy.jpg',
            'status' => 'active',
            'expired_at' => Carbon::now()->addDays(7),
        ]);

    }
}
