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

        User::create([
            'name' => 'operator umkm   ',
            'email' => 'umkm@gmail.com ',
            'password' => Hash::make('12345678'),
            'role' => 'Operator umkm',
            'jenis_operator_id' => '1',
        ]);

        User::create([
            'name' => 'operator pariwisata',
            'email' => 'pariwisata@gmail.com ',
            'password' => Hash::make('12345678'),
            'role' => 'Operator pariwisata',
            'jenis_operator_id' => '2',
        ]);

        User::create([
            'name' => 'operator investasi',
            'email' => 'investasi@gmail.com ',
            'password' => Hash::make('12345678'),
            'role' => 'Operator investasi',
            'jenis_operator_id' => '3',
        ]);

        User::create([
            'name' => 'operator event',
            'email' => 'event@gmail.com ',
            'password' => Hash::make('12345678'),
            'role' => 'Operator event',
            'jenis_operator_id' => '4',
        ]);

        User::create([
            'name' => 'operator entertaiment',
            'email' => 'entertaiment@gmail.com ',
            'password' => Hash::make('12345678'),
            'role' => 'Operator entertaiment',
            'jenis_operator_id' => '5',
        ]);

        User::create([
            'name' => 'operator box office',
            'email' => 'boxoffice@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Operator box office',
            'jenis_operator_id' => '6',
        ]);
    }
}
