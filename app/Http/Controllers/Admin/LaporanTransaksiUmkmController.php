<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProdukUmkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Phpml\Regression\LeastSquares;

class LaporanTransaksiUmkmController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('tahun', now()->year);
        $months = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
        $dataView = [];

        foreach (ProdukUmkm::all() as $produk) {
            $query = DB::table('transaksi_details')
                ->selectRaw('MONTH(created_at) as bulan, SUM(qty * harga) as pendapatan')
                ->where('produk_id', $produk->id)
                ->whereYear('created_at', $year)
                ->groupByRaw('MONTH(created_at)')
                ->orderByRaw('MONTH(created_at)')
                ->get();

            $samples = [];
            $targets = [];
            $bulanData = [];

            foreach ($query as $row) {
                $samples[] = [$row->bulan];
                $targets[] = $row->pendapatan;

                $bulanData[$row->bulan] = [
                    'actual' => $row->pendapatan,
                    'prediksi' => null,
                    'error' => null,
                ];
            }

            if (count($samples) > 1) {
                $model = new LeastSquares();
                $model->train($samples, $targets);

                for ($i = 1; $i <= 12; $i++) {
                    $prediksi = $model->predict([$i]);
                    $aktual = $bulanData[$i]['actual'] ?? null;
                    $error = null;
                    

                    

                    if (!is_null($aktual)) {
                        $aktual = floatval($aktual);
                        $prediksi = floatval($prediksi);

                        $error = ($aktual - $prediksi) / $aktual;
                        $error = round($error, 6);
                    }

                    // Isi prediksi dan error ke bulanData (meskipun tidak ada realisasi)
                    $bulanData[$i] = [
                        'actual' => $aktual,
                        'prediksi' => $prediksi,
                        'error' => $error,
                    ];
                }
            }

            $dataView[$produk->nama_produk] = $bulanData;
        }

        $labels = array_values($months);
        $actual = []; $prediction = [];

        // Contoh produk pertama untuk chart
        if (!empty($dataView)) {
            $firstProduk = array_key_first($dataView);
            for ($i = 1; $i <= 12; $i++) {
                $actual[] = $dataView[$firstProduk][$i]['actual'] ?? null;
                $prediction[] = $dataView[$firstProduk][$i]['prediksi'] ?? null;
            }
        }

        return view('Admin.Laporan.transaksi_umkm', 
            compact('year', 'months', 'dataView', 'labels', 'actual', 'prediction'));
    }
}
