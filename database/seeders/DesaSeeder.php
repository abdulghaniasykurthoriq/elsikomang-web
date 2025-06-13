<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/komerce_destinations.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0); // baris pertama sebagai header

        foreach ($csv->getRecords() as $record) {
            $provinsi = Provinsi::firstOrCreate(['nama' => $record['province_name']]);
            $kota = Kota::firstOrCreate([
                'nama' => $record['city_name'],
                'provinsi_id' => $provinsi->id
            ]);
            $kecamatan = Kecamatan::firstOrCreate([
                'nama' => $record['district_name'],
                'kota_id' => $kota->id
            ]);
            Desa::updateOrCreate([
                'id' => $record['id'],
                'id_komerce' => $record['id'],
            ], [
                'nama' => $record['subdistrict_name'],
                'kode_pos' => $record['zip_code'],
                'kecamatan_id' => $kecamatan->id,
            ]);
        }

        echo "✅ Seeder selesai dijalankan!\n";
    }
}
