<?php

namespace App\Http\Controllers\Operator\Umkm;
use App\Http\Controllers\Controller;
use App\Models\ProdukUmkm;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Phpml\Regression\LeastSquares;

use Phpml\Pipeline\Pipeline;
use Phpml\Preprocessing\PolynomialTransformer;
use Phpml\Regression\LeastSquares as Regression;

// use Phpml\Regression\SVR;
// use Phpml\SupportVectorMachine\Kernel;
// use Phpml\Preprocessing\MinMaxScaler;
// use Phpml\Preprocessing\MinMaxScaler; 

// use Phpml\SupportVectorMachine\SupportVectorMachine;
// use Phpml\SupportVectorMachine\Kernel;
// use Phpml\SupportVectorMachine\SVM;

class LaporanTransaksiUmkmController extends Controller
{



    // public function index(Request $request)
    // {
    //     $year = $request->get('tahun', now()->year);
    //     $months = [
    //         1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
    //         7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
    //     ];
    //     $dataView = [];

    //     $allProduk = ProdukUmkm::all();

    //     foreach ($allProduk as $produk) {
    //         $query = DB::table('transaksi_details')
    //             ->selectRaw('MONTH(created_at) as bulan, SUM(qty * harga) as pendapatan')
    //             ->where('produk_id', $produk->id)
    //             ->whereYear('created_at', $year)
    //             ->groupByRaw('MONTH(created_at)')
    //             ->orderByRaw('MONTH(created_at)')
    //             ->get();

    //         $bulanData = [];
    //         $trainSamples = [];
    //         $trainTargets = [];

    //         foreach ($query as $row) {
    //             $bulan = intval($row->bulan);
    //             $pendapatan = floatval($row->pendapatan);

    //             // Data aktual (input dan target untuk training)
    //             $trainSamples[] = [$bulan];
    //             $trainTargets[] = $pendapatan;

    //             // Simpan data aktual
    //             $bulanData[$bulan] = [
    //                 'actual' => $pendapatan,
    //                 'prediksi' => null,
    //                 'error' => null,
    //             ];
    //         }

    //         // Inisialisasi semua bulan agar lengkap
    //         for ($i = 1; $i <= 12; $i++) {
    //             if (!isset($bulanData[$i])) {
    //                 $bulanData[$i] = [
    //                     'actual' => null,
    //                     'prediksi' => null,
    //                     'error' => null,
    //                 ];
    //             }
    //         }

    //         // Proses prediksi hanya jika ada cukup data aktual
    //         if (count($trainSamples) >= 2) {
    //             $model = new LeastSquares();
    //             $model->train($trainSamples, $trainTargets);

    //             $totalError = 0;
    //             $jumlahError = 0;

    //             for ($i = 1; $i <= 12; $i++) {
    //                 $prediksi = $model->predict([$i]);
    //                 $prediksi = max(0, round($prediksi, 2)); 
    //                 $aktual = $bulanData[$i]['actual'];

    //                 $error = null;
    //                 if (!is_null($aktual) && $aktual != 0) {
    //                     $error = abs(($aktual - $prediksi) / $aktual); // error tanpa *100
    //                     $totalError += $error;
    //                     $jumlahError++;
    //                     $error = round($error * 100, 2); // simpan dalam % di UI
    //                 }

    //                 $bulanData[$i]['prediksi'] = $prediksi;
    //                 $bulanData[$i]['error'] = $error;
    //             }

    //             $mape = $jumlahError > 0 ? round($totalError / $jumlahError * 100, 2) : null;
    //         } else {
    //             $mape = null;
    //         }

    //         $dataView[$produk->nama_produk] = [
    //             'bulan' => $bulanData,
    //             'mape' => $mape,
    //         ];
    //     }

    //     // Grafik (produk pertama)
    //     $labels = array_values($months);
    //     $actual = [];
    //     $prediction = [];

    //     if (!empty($dataView)) {
    //         $firstProduk = array_key_first($dataView);
    //         for ($i = 1; $i <= 12; $i++) {
    //             $actual[] = $dataView[$firstProduk]['bulan'][$i]['actual'] ?? null;
    //             $prediction[] = $dataView[$firstProduk]['bulan'][$i]['prediksi'] ?? null;
    //         }
    //     }

    //     return view('Operator.umkm.Laporan.LaporanTransaksiProdukUmkm.index',
    //         compact('year', 'months', 'dataView', 'labels', 'actual', 'prediction', 'allProduk'));
    // }


    public function index2(Request $request)
    {
        $year = $request->get('tahun', now()->year);
        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        // Ambil total pendapatan semua produk per bulan
        $query = DB::table('transaksi_details')
            ->selectRaw('MONTH(created_at) as bulan, SUM(qty * harga) as pendapatan')
            ->whereYear('created_at', $year)
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();

        $bulanData = [];
        $trainSamples = [];
        $trainTargets = [];

        foreach ($query as $row) {
            $bulan = intval($row->bulan);
            $pendapatan = floatval($row->pendapatan);

            $trainSamples[] = [$bulan];
            $trainTargets[] = $pendapatan;

            $bulanData[$bulan] = [
                'actual' => $pendapatan,
                'prediksi' => null,
                'error' => null,
            ];
        }

        // Inisialisasi semua bulan agar lengkap
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($bulanData[$i])) {
                $bulanData[$i] = [
                    'actual' => null,
                    'prediksi' => null,
                    'error' => null,
                ];
            }
        }

        // Proses prediksi jika data cukup
        $mape = null;
        if (count($trainSamples) >= 2) {
            $model = new LeastSquares();
            $model->train($trainSamples, $trainTargets);

            $totalError = 0;
            $jumlahError = 0;

            for ($i = 1; $i <= 12; $i++) {
                $prediksi = $model->predict([$i]);
                $prediksi = max(0, round($prediksi, 2)); 
                $aktual = $bulanData[$i]['actual'];

                $error = null;
                if (!is_null($aktual) && $aktual != 0) {
                    $error = abs(($aktual - $prediksi) / $aktual);
                    $totalError += $error;
                    $jumlahError++;
                    $error = round($error * 100, 2);
                }

                $bulanData[$i]['prediksi'] = $prediksi;
                $bulanData[$i]['error'] = $error;
            }

            $mape = $jumlahError > 0 ? round($totalError / $jumlahError * 100, 2) : null;
        }

        // Siapkan data untuk chart
        $labels = array_values($months);
        $actual = [];
        $prediction = [];
        for ($i = 1; $i <= 12; $i++) {
            $actual[] = $bulanData[$i]['actual'] ?? null;
            $prediction[] = $bulanData[$i]['prediksi'] ?? null;
        }

        return view('Operator.umkm.Laporan.LaporanTransaksiProdukUmkm.index2', [
            'year' => $year,
            'months' => $months,
            'labels' => $labels,
            'actual' => $actual,
            'prediction' => $prediction,
            'bulanData' => $bulanData,
            'mape' => $mape,
        ]);
    }

    // Contoh: controller method untuk detail per bulan

    
    public function showPerBulan($tahun, $bulan)
    {
        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tanggalLabels = range(1, $jumlahHari);
    
        $harianAktual = DB::table('transaksi_details')
            ->selectRaw('DAY(created_at) as tanggal, SUM(qty * harga) as pendapatan')
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
    
        $samples = [];
        $targets = [];
        foreach ($harianAktual as $item) {
            $samples[] = [$item->tanggal];
            $targets[] = $item->pendapatan;
        }
    
        $model = new LeastSquares();
        if (!empty($samples)) {
            $model->train($samples, $targets);
        }
    
        $actualData = [];
        $predictData = [];
        $totalAktual = 0;
        $totalPrediksiAll = 0;
    
        for ($i = 1; $i <= $jumlahHari; $i++) {
            $prediksi = max(0, round($model->predict([$i]), 2));
            $predictData[] = $prediksi;
            $totalPrediksiAll += $prediksi;
    
            $aktualItem = collect($harianAktual)->firstWhere('tanggal', $i);
            if ($aktualItem) {
                $actualData[] = $aktualItem->pendapatan;
                $totalAktual += $aktualItem->pendapatan;
            } else {
                $actualData[] = null;
            }
        }
    
        return view('Operator.umkm.Laporan.LaporanTransaksiProdukUmkm.perbulan', [
            'tahun' => $tahun,
            'bulan' => $bulan,
            'labels' => $tanggalLabels,
            'actualData' => $actualData,
            'predictData' => $predictData,
            'totalAktual' => $totalAktual,
            'totalPrediksiAll' => $totalPrediksiAll,
        ]);
    }
    

//     public function index(Request $request)
// {
//     $year = $request->get('tahun', now()->year);
//     $months = [
//         1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
//         7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
//     ];
//     $dataView = [];

//     $allProduk = ProdukUmkm::all();

//     foreach ($allProduk as $produk) {
//         $query = DB::table('transaksi_details')
//             ->selectRaw('MONTH(created_at) as bulan, SUM(qty * harga) as pendapatan')
//             ->where('produk_id', $produk->id)
//             ->whereYear('created_at', $year)
//             ->groupByRaw('MONTH(created_at)')
//             ->orderByRaw('MONTH(created_at)')
//             ->get();

//         $bulanData = [];
//         $trainSamples = [];
//         $trainTargets = [];

//         foreach ($query as $row) {
//             $bulan = intval($row->bulan);
//             $pendapatan = floatval($row->pendapatan);

//             // Ubah jadi input polinomial: [x, x^2]
//             $trainSamples[] = [$bulan, pow($bulan, 2)];
//             $trainTargets[] = $pendapatan;

//             $bulanData[$bulan] = [
//                 'actual' => $pendapatan,
//                 'prediksi' => null,
//                 'error' => null,
//             ];
//         }

//         // Inisialisasi semua bulan agar lengkap
//         for ($i = 1; $i <= 12; $i++) {
//             if (!isset($bulanData[$i])) {
//                 $bulanData[$i] = [
//                     'actual' => null,
//                     'prediksi' => null,
//                     'error' => null,
//                 ];
//             }
//         }

//         if (count($trainSamples) >= 2) {
//             $model = new LeastSquares();
//             $model->train($trainSamples, $trainTargets);

//             $totalError = 0;
//             $jumlahError = 0;

//             for ($i = 1; $i <= 12; $i++) {
//                 $prediksi = $model->predict([$i, pow($i, 2)]);
//                 $prediksi = round($prediksi, 2);
//                 $aktual = $bulanData[$i]['actual'];

//                 $error = null;
//                 if (!is_null($aktual) && $aktual != 0) {
//                     $error = abs(($aktual - $prediksi) / $aktual);
//                     $totalError += $error;
//                     $jumlahError++;
//                     $error = round($error * 100, 2); // persen
//                 }

//                 $bulanData[$i]['prediksi'] = $prediksi;
//                 $bulanData[$i]['error'] = $error;
//             }

//             $mape = $jumlahError > 0 ? round($totalError / $jumlahError * 100, 2) : null;
//         } else {
//             $mape = null;
//         }

//         $dataView[$produk->nama_produk] = [
//             'bulan' => $bulanData,
//             'mape' => $mape,
//         ];
//     }

//     // Grafik (produk pertama)
//     $labels = array_values($months);
//     $actual = [];
//     $prediction = [];

//     if (!empty($dataView)) {
//         $firstProduk = array_key_first($dataView);
//         for ($i = 1; $i <= 12; $i++) {
//             $actual[] = $dataView[$firstProduk]['bulan'][$i]['actual'] ?? null;
//             $prediction[] = $dataView[$firstProduk]['bulan'][$i]['prediksi'] ?? null;
//         }
//     }

//     return view('Operator.umkm.Laporan.LaporanTransaksiProdukUmkm.index',
//         compact('year', 'months', 'dataView', 'labels', 'actual', 'prediction', 'allProduk'));
// }







// public function proses(Request $request)
// {
//     $barang_id = $request->input('barang_id') ?? 1;

//     $barang = ProdukUmkm::find($barang_id);
//     if (!$barang) {
//         return back()->with('error', 'Barang tidak ditemukan.');
//     }

//     $historis = TransaksiDetail::where('produk_id', $barang_id)
//         ->orderBy('created_at')
//         ->get();

//     if ($historis->count() < 2) {
//         return back()->with('error', 'Data historis tidak cukup untuk prediksi.');
//     }

//     $data = [];
//     foreach ($historis as $item) {
//         $periode = Carbon::parse($item->created_at)->format('Y-m');
//         $pendapatan = $item->qty * $item->harga;
//         if (!isset($data[$periode])) {
//             $data[$periode] = 0;
//         }
//         $data[$periode] += $pendapatan;
//     }

//     // Urutkan tahun descending, bulan ascending
//     uksort($data, function ($a, $b) {
//         $aDate = Carbon::parse($a . '-01');
//         $bDate = Carbon::parse($b . '-01');

//         if ($aDate->year === $bDate->year) {
//             return $aDate->month <=> $bDate->month;
//         }

//         return $bDate->year <=> $aDate->year; // Tahun menurun
//     });

//     $periodeList = array_values($data);
//     $n = count($periodeList);
//     $mid = floor($n / 2);
//     $sumX = $sumY = $sumXY = $sumXX = 0;

//     $indexed = [];
//     foreach ($periodeList as $i => $y) {
//         $x = $i - $mid;
//         $xy = $x * $y;
//         $xx = $x * $x;

//         $sumX += $x;
//         $sumY += $y;
//         $sumXY += $xy;
//         $sumXX += $xx;

//         $indexed[] = compact('x', 'y', 'xy', 'xx');
//     }

//     $nilaiA = $sumY / $n;
//     $nilaiB = $sumXX !== 0 ? $sumXY / $sumXX : 0;

//     $evaluasi = [];
//     foreach (array_keys($data) as $i => $periodeKey) {
//         $x = $i - $mid;
//         $prediksi = $nilaiA + ($nilaiB * $x);
//         $aktual = $data[$periodeKey];

//         $mad = abs($aktual - $prediksi);
//         $mape = $aktual != 0 ? ($mad / $aktual) * 100 : 0;

//         $evaluasi[] = [
//             'bulan' => Carbon::parse($periodeKey . '-01')->translatedFormat('F'),
//             'tahun' => Carbon::parse($periodeKey . '-01')->year,
//             'prediksi' => $prediksi,
//             'aktual' => $aktual,
//             'mad' => $mad,
//             'mape' => $mape,
//         ];
//     }
//     dd(array_keys($data));
//     // PAGINASI
//     $page = request('page', 1);
//     $perPage = 6;
//     $offset = ($page - 1) * $perPage;
//     $evaluasiPaginated = new LengthAwarePaginator(
//         array_slice($evaluasi, $offset, $perPage),
//         count($evaluasi),
//         $perPage,
//         $page,
//         ['path' => request()->url(), 'query' => request()->query()]
//     );

//     $prediksiKeDepan = [];
//     $lastPeriode = array_key_last($data);
//     $lastDate = Carbon::parse($lastPeriode . '-01')->startOfMonth();
//     $bulanMulaiPrediksi = $lastDate->copy()->addMonth();

//     for ($i = 0; $i < 12; $i++) {
//         $target = $bulanMulaiPrediksi->copy()->addMonths($i);
//         $x = $n + $i - $mid;
//         $prediksi = $nilaiA + ($nilaiB * $x);

//         $prediksiKeDepan[] = [
//             'bulan' => $target->translatedFormat('F'),
//             'tahun' => $target->year,
//             'prediksi' => $prediksi,
//             'mad' => '-',
//             'mape' => '-',
//         ];
//     }

//     return view('Operator.umkm.LeastSquares.hasil', [
//         'barang' => $barang,
//         'nilaiX' => $sumX,
//         'nilaiY' => $sumY,
//         'nilaiXY' => $sumXY,
//         'nilaiXX' => $sumXX,
//         'nilaiA' => $nilaiA,
//         'nilaiB' => $nilaiB,
//         'evaluasi' => $evaluasiPaginated,
//         'prediksiKeDepan' => $prediksiKeDepan,
//     ]);
// }

public function proses(Request $request)
{
    // Ambil jumlah bulan dari input user, default 12
    $jumlahBulanPrediksi = (int) $request->input('jumlah_bulan', 12);

    // Ambil histori transaksi dari semua produk
    $historis = DB::table('transaksi_details')
        ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as periode, SUM(qty * harga) as pendapatan")
        ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m')")
        ->orderByRaw("DATE_FORMAT(created_at, '%Y-%m')")
        ->get();

    if ($historis->count() < 2) {
        return back()->with('error', 'Data historis tidak cukup untuk prediksi.');
    }

    // Simpan ke array
    $data = [];
    foreach ($historis as $item) {
        $periode = $item->periode;
        $data[$periode] = $item->pendapatan;
    }

    // Urutkan berdasarkan waktu
    uksort($data, fn ($a, $b) => strtotime($a) <=> strtotime($b));

    $periodeList = array_values($data);
    $n = count($periodeList);
    $mid = floor($n / 2);

    $sumX = $sumY = $sumXY = $sumXX = 0;
    $sumXTampil = $sumXYTampil = $sumX2Tampil = 0;

    foreach ($periodeList as $i => $y) {
        $x = $i - $mid;
        $xy = $x * $y;
        $xx = $x * $x;

        $sumX += $x;
        $sumY += $y;
        $sumXY += $xy;
        $sumXX += $xx;

        $xTampil = $i + 1;
        $sumXTampil += $xTampil;
        $sumXYTampil += $xTampil * $y;
        $sumX2Tampil += $xTampil * $xTampil;
    }

    $nilaiA = $sumY / $n;
    $nilaiB = $sumXX !== 0 ? $sumXY / $sumXX : 0;

    // Evaluasi aktual dan prediksi
    $evaluasi = [];
    $periodeKeys = array_keys($data);
    foreach ($periodeKeys as $i => $periodeKey) {
        $x = $i - $mid;
        $prediksi = $nilaiA + ($nilaiB * $x);
        $aktual = $data[$periodeKey];

        $mad = abs($aktual - $prediksi);
        $mape = $aktual != 0 ? ($mad / $aktual) * 100 : 0;

        $evaluasi[] = [
            'bulan' => Carbon::parse($periodeKey . '-01')->translatedFormat('F'),
            'tahun' => Carbon::parse($periodeKey . '-01')->year,
            'prediksi' => round($prediksi, 2),
            'aktual' => $aktual,
            'mad' => round($mad, 2),
            'mape' => round($mape, 2),
        ];
    }

    // Paginasi manual
    $page = request('page', 1);
    $perPage = 6;
    $offset = ($page - 1) * $perPage;
    $evaluasiPaginated = new LengthAwarePaginator(
        array_slice($evaluasi, $offset, $perPage),
        count($evaluasi),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    // Prediksi N bulan ke depan berdasarkan input user
    $lastPeriode = array_key_last($data);
    $lastDate = Carbon::parse($lastPeriode . '-01')->startOfMonth();
    $bulanMulaiPrediksi = $lastDate->copy()->addMonth();

    $prediksiKeDepan = [];
    for ($i = 0; $i < $jumlahBulanPrediksi; $i++) {
        $target = $bulanMulaiPrediksi->copy()->addMonths($i);
        $x = $n + $i - $mid;
        $prediksi = $nilaiA + ($nilaiB * $x);

        $prediksiKeDepan[] = [
            'bulan' => $target->translatedFormat('F'),
            'tahun' => $target->year,
            'prediksi' => round($prediksi, 2),
            'mad' => '-',
            'mape' => '-',
        ];
    }

    return view('Operator.umkm.LeastSquares.hasil', [
        'barang' => null,
        'nilaiX' => $sumXTampil,
        'nilaiY' => $sumY,
        'nilaiXY' => $sumXYTampil,
        'nilaiXX' => $sumX2Tampil,
        'nilaiA' => round($nilaiA, 2),
        'nilaiB' => round($nilaiB, 2),
        'evaluasi' => $evaluasiPaginated,
        'prediksiKeDepan' => $prediksiKeDepan,
        'jumlahBulanPrediksi' => $jumlahBulanPrediksi,
    ]);
}











}
