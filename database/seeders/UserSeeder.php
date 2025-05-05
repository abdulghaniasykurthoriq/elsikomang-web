<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Elsikomang',
            'email' => 'admin@gmail.com',
            'role' => 'Admin',
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'name' => 'Operator UMKM',
            'email' => 'agatinfo17@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'cus',
            'email' => 'cus@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}