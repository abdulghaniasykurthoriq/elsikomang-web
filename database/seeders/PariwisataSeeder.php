<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pariwisata;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PariwisataSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = ['pantai', 'hutan', 'religi', 'budaya', 'kuliner', 'edukasi'];
        $now = Carbon::now();
        $faker = \Faker\Factory::create('id_ID');

        $namaWisata = [
            "Pantai Tirtamaya", "Situ Bolang", "Hutan Mangrove Karangsong", "Waterboom Bojongsari", "Curug Cipeuteuy",
            "Pulau Biawak", "Cimanuk Riverside", "Agro Wisata Mangga", "Alun-Alun Indramayu", "Kampung Batik Paoman",
            "Waduk Cipancuh", "Pantai Balongan Indah", "Taman Cimanuk", "Situ Cipai", "Cagar Alam Cibodas",
            "Pantai Eretan", "Situ Cikuda", "Bukit Cikeusik", "Goa Lalay", "Kebun Raya Indramayu",
            "Situs Buyut Banjar", "Masjid Agung Indramayu", "Wisata Edukasi Karangsong", "Pantai Lemah Abang",
            "Hutan Kota Sindang", "Situ Girang", "Taman Air Pabean", "Museum Indramayu", "Situ Sukra", "Situ Cileuleuy",
            "Bukit Seribu Tangga", "Cikalahang Adventure", "Waduk Bugel", "Kampung Wisata Nelayan", "Pantai Glayem",
            "Pasar Seni Paoman", "Kampung Cengkir", "Hutan Lindung Rancajawad", "Wisata Religi Syeikh Abdul Manan",
            "Pantai Cibugel", "Taman 1000 Lampu", "Ciwaringin Lake", "Kolam Renang Sindang", "Bukit Kunci",
            "Hutan Jati Kertasemaya", "Situ Jaya", "Situ Gede", "Pantai Plentong", "Kampung Tangguh Indramayu",
            "Wisata Embung Tegaldana"
        ];

        $fasilitasIds = DB::table('fasilitas')->pluck('id')->toArray();

        foreach ($namaWisata as $nama) {
            $slug = Str::slug($nama);

            $pariwisata = Pariwisata::create([
                'nama' => $nama,
                'deskripsi' => $faker->text(120),
                'gambar' => 'pariwisata_images/' . $slug . '.jpg',
                'harga_tiket' => $faker->randomElement([5000, 10000, 15000, 20000, 25000]),
                'kategori' => $faker->randomElement($kategori),
                'rating' => $faker->randomFloat(2, 3.0, 5.0),
                'latitude' => $faker->randomFloat(7, -6.40, -6.30),
                'longitude' => $faker->randomFloat(7, 108.30, 108.40),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Hubungkan fasilitas acak
            $pariwisata->fasilitas()->sync(
                collect($fasilitasIds)->random(rand(1, min(4, count($fasilitasIds))))
            );
        }
    }
}
