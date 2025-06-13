<?php

namespace App\Console\Commands;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Console\Command;
use League\Csv\Reader;

class ImportDestinasiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-destinasi-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = database_path('data/komerce_destinations.csv');

        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        $barisTotal = iterator_count($records); // total record
        $csv = Reader::createFromPath($path, 'r'); // ulang karena tadi habis
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        $this->output->progressStart($barisTotal);

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

            Desa::updateOrCreate([
                'id' => $record['id'],
                'id_komerce' => $record['id'],
            ], [
                'nama' => $record['subdistrict_name'],
                'kode_pos' => $record['zip_code'],
                'kecamatan_id' => $kecamatan->id,
            ]);

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
        $this->info("✅ Import selesai!");
    }
}
