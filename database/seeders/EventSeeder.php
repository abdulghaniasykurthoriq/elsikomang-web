<?php

namespace Database\Seeders;

use App\Models\OperatorEvent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OperatorEvent::create([
            'foto_event' => 'event/A5jQxiJWMnlMNasQSlUoRu6ksjPoM7wrA998i7vN.jpg',
            'nama_event' => 'event Majemik',
            'deskripsi' => '<p><strong>&nbsp;aku keren </strong>banget</p>',
            'created_by' => 'operator evenet',
        ]);
    }
}
