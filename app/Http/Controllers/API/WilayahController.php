<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class WilayahController extends Controller
{
    public function provinsi()
    {
        $provinsi = Provinsi::all();

        return response()->json([
            'status' => 'success',
            'data' => $provinsi
        ]);
    }
    public function kota($id)
    {
        $kota = Kota::where('provinsi_id',$id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $kota
        ]);
    }
    public function kecamatan($id)
    {
        $kecamatan = Kecamatan::where('kota_id',$id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $kecamatan
        ]);
    }
    public function desa($id)
    {
        $desa = Desa::where('kecamatan_id',$id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $desa
        ]);
    }




    public function importDestinasi()
    {
        $path = database_path('data/komerce_destinations.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0); // baris pertama sebagai header

        $records = iterator_to_array($csv->getRecords());
        $total = count($records);
        $i = 0;

        $desaData = [];

        DB::beginTransaction();
        try {
            foreach ($records as $record) {
                $provinsi = Provinsi::firstOrCreate(['nama' => $record['province_name']]);
                $kota = Kota::firstOrCreate([
                    'nama' => $record['city_name'],
                    'provinsi_id' => $provinsi->id,
                ]);
                $kecamatan = Kecamatan::firstOrCreate([
                    'nama' => $record['district_name'],
                    'kota_id' => $kota->id,
                ]);

                $desaData[] = [
                    'id' => $record['id'],
                    'id_komerce' => $record['id'],
                    'nama' => $record['subdistrict_name'],
                    'kode_pos' => $record['zip_code'],
                    'kecamatan_id' => $kecamatan->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $i++;
                if ($i % 500 == 0) {
                    echo "⏳ Proses: " . number_format(($i / $total) * 100, 2) . "%\n";
                }
            }

            // Insert/update secara massal
            foreach (array_chunk($desaData, 1000) as $chunk) {
                foreach ($chunk as $desa) {
                    Desa::updateOrCreate(
                        ['id' => $desa['id'], 'id_komerce' => $desa['id_komerce']],
                        $desa
                    );
                }
            }

            DB::commit();
            return response()->json(['message' => '✅ Data wilayah berhasil diimpor.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal import data', 'message' => $e->getMessage()], 500);
        }
    }

}
