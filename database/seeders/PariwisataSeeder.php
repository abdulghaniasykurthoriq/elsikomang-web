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
        $faker = \Faker\Factory::create('id_ID');
        $kategori = ['pantai', 'hutan', 'religi', 'budaya', 'kuliner', 'edukasi', 'buatan'];
        $now = Carbon::now();

        $namaWisata = ['Pantai Tirtamaya', 'Pantai Glayem', 'Pantai Karangsong', 'Pantai Dadap', 'Pantai Tebing Patrol', 'Pantai Cibugel', 'Pantai Eretan Wetan', 'Pantai Lemah Abang', 'Pantai Balongan Indah', 'Pantai Solikin', 'Pantai Limbangan', 'Taman Cimanuk', 'Water Boom Tirta Djaya', 'Waduk Cipancuh', 'Rangdu Gede', 'Hutan Mangrove Pantai Lestari Karangsong', 'Agung Fantasi Waterpark', 'Tugu Bor Kertanegara', 'Monumen Bumi Patra', 'Alun-Alun Indramayu', 'Masjid Agung Indramayu', 'Pulau Biawak Indramayu', 'Science Center Mutiara Bangsa', 'Situs Buyut Banjar', 'Jembatan Terusan Indramayu', 'Tugu Perjuangan Indramayu', 'Situ Bolang Indramayu', 'Taman Rusa Bumi Patra', 'Tiga Bintang Firdaus Waterpark', 'Waterboom Bojongsari'];

        $fasilitasIds = DB::table('fasilitas')->pluck('id')->toArray();

        foreach ($namaWisata as $nama) {
            $slug = Str::slug($nama);

            $jamBuka = Carbon::createFromTime(rand(6, 10), 0, 0);
            $jamTutup = (clone $jamBuka)->addHours(rand(7, 12));

            $pariwisata = Pariwisata::create([
                'nama' => $nama,
                'deskripsi' => $faker->text(120),
                'alamat' => $faker->randomElement(['Anjatan', 'Arahan', 'Balongan', 'Bangodua', 'Bongas', 'Cantigi', 'Cikedung', 'Gabuswetan', 'Gantar', 'Haurgeulis', 'Indramayu', 'Jatibarang', 'Kandanghaur', 'Karangampel', 'Kedokanbunder', 'Kertasemaya', 'Krangkeng', 'Losarang', 'Pasekan', 'Patrol', 'Sindang', 'Sliyeg', 'Sukagumiwang', 'Sukra', 'Terisi', 'Tukdana', 'Widasari']) . ', Indramayu',

                'gambar' => 'pariwisata_images/' . $slug . '.jpg',
                'harga_tiket' => $faker->randomElement([5000, 10000, 15000, 25000, 35000, 50000]),
                'kategori' => $faker->randomElement($kategori),
                'rating' => $faker->randomFloat(2, 3.0, 5.0),
                'jam_buka' => $jamBuka->format('H:i:s'),
                'jam_tutup' => $jamTutup->format('H:i:s'),
                'latitude' => $faker->randomFloat(7, -6.4, -6.3),
                'longitude' => $faker->randomFloat(7, 108.3, 108.4),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $pariwisata->fasilitas()->sync(collect($fasilitasIds)->random(rand(1, min(4, count($fasilitasIds)))));
        }
    }
}
