<?php

namespace Database\Seeders;

use App\Models\CoverMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoverMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CoverMenu::create([
            'id' => 1,
            'nama' => 'UMKM',
            'foto' => 'cover-menu/dumy.jpg',
        ]);
        CoverMenu::create([
            'id' => 2,
            'nama' => 'Pariwisata',
            'foto' => 'cover-menu/dumy.jpg',
        ]);
        CoverMenu::create([
            'id' => 3,
            'nama' => 'Investasi',
            'foto' => 'cover-menu/dumy.jpg',
        ]);
        CoverMenu::create([
            'id' => 4,
            'nama' => 'Entertaintment',
            'foto' => 'cover-menu/dumy.jpg',
        ]);
        CoverMenu::create([
            'id' => 5,
            'nama' => 'Event',
            'foto' => 'cover-menu/dumy.jpg',
        ]);
    }
}
