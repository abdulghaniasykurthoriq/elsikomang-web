<?php

namespace Database\Seeders;

use App\Models\Investasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Investasi::create([
            'foto_investasi' => 'investasis/A5jQxiJWMnlMNasQSlUoRu6ksjPoM7wrA998i7vN.jpg',
            'nama_investasi' => 'investasis Majemik',
            'deskripsi' => '<p><strong>&nbsp;aku keren </strong>banget</p>',
            'created_by' => 'operator investasi',
        ]);
    }
}
