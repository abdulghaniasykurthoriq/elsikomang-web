<?php

namespace Database\Seeders;

use App\Models\Iklan;
use App\Models\IklanData;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class IklanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $iklan = Iklan::create([
            'id' => 1,
            'nama' => 'Home 1',
            'slug' => 'home-1'
        ]);
        IklanData   ::create([
            'iklan_id' => 1,
            'gambar' => 'produk_image/dummy.jpg',
            'link' => 'http://localhost:8000/produk_image/dummy.jpg',
            'status' => 'active',
            'expired_at' => Carbon::now()->addDays(7),
        ]);
        IklanData::create([
            'iklan_id' => 1,
            'gambar' => 'produk_image/dummy.jpg',
            'link' => 'http://localhost:8000/produk_image/dummy.jpg',
            'status' => 'active',
            'expired_at' => Carbon::now()->addDays(7),
        ]);
    }
}
