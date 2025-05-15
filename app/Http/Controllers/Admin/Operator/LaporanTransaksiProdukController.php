<?php

namespace App\Http\Controllers\Admin\Operator;

use App\Http\Controllers\Controller;
use App\Models\ProdukUmkm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Phpml\Regression\LeastSquares;

class LaporanTransaksiProdukController extends Controller
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
                    'pendapatan' => $row->pendapatan,
                    'status' => 'Realisasi',
                ];
            }

            if (count($samples) > 1) {
                $model = new LeastSquares();
                $model->train($samples, $targets);

                $lastMonth = max(array_column($samples, 0));
                if ($lastMonth < 12) {
                    $nextMonth = $lastMonth + 1;
                    $predicted = $model->predict([$nextMonth]);

                    $bulanData[$nextMonth] = [
                        'pendapatan' => $predicted,
                        'status' => 'Prediksi',
                    ];
                }
            }

            $dataView[$produk->nama_produk] = $bulanData;
        }
        // dd($dataView);
        // return view('Operator.Laporan.LaporanTransaksiProdukUmkm.index');     
        return view('Operator.Laporan.LaporanTransaksiProdukUmkm.index', 
        compact('year', 'months', 'dataView'));

    }
}
