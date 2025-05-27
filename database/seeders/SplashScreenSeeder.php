<?php

namespace Database\Seeders;

use App\Models\SplashScreen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SplashScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SplashScreen::create([
            'image_content'=> 'splashscreen/',
            'image_footer' => 'splashscreen/'
        ]);
    }
}
