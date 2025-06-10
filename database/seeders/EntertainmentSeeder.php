<?php

namespace Database\Seeders;

use App\Models\Entertaiment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntertainmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Entertaiment::create([
            'foto_entertaiment' => 'entertaiments/A5jQxiJWMnlMNasQSlUoRu6ksjPoM7wrA998i7vN.jpg',
            'nama_entertaiment' => 'Entertaiment Majemik',
            'deskripsi' => '<p><strong>&nbsp;aku keren </strong>banget</p>',
            'created_by' => 'operator entertaiment',
        ]);
    }
}
