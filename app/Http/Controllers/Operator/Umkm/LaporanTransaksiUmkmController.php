<?php

namespace App\Http\Controllers\Operator\Umkm;

use App\Http\Controllers\Controller;
use App\Models\ProdukUmkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Phpml\Regression\LeastSquares;

// use Phpml\Regression\SVR;
// use Phpml\SupportVectorMachine\Kernel;
// use Phpml\Preprocessing\MinMaxScaler;
// use Phpml\Preprocessing\MinMaxScaler; 

// use Phpml\SupportVectorMachine\SupportVectorMachine;
// use Phpml\SupportVectorMachine\Kernel;
// use Phpml\SupportVectorMachine\SVM;

class LaporanTransaksiUmkmController extends Controller
{



    public function index(Request $request)
    {
        $year = $request->get('tahun', now()->year);
        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        $dataView = [];

        foreach (ProdukUmkm::all() as $produk) {
            $query = DB::table('transaksi_details')
                ->selectRaw('MONTH(created_at) as bulan, SUM(qty * harga) as pendapatan')
                ->where('produk_id', $produk->id)
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

                // Data aktual (input dan target untuk training)
                $trainSamples[] = [$bulan];
                $trainTargets[] = $pendapatan;

                // Simpan data aktual
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

            // Proses prediksi hanya jika ada cukup data aktual
            if (count($trainSamples) >= 2) {
                $model = new LeastSquares();
                $model->train($trainSamples, $trainTargets);

                $totalError = 0;
                $jumlahError = 0;

                for ($i = 1; $i <= 12; $i++) {
                    $prediksi = $model->predict([$i]);
                    $prediksi = round($prediksi, 2);
                    $aktual = $bulanData[$i]['actual'];

                    $error = null;
                    if (!is_null($aktual) && $aktual != 0) {
                        $error = abs(($aktual - $prediksi) / $aktual); // error tanpa *100
                        $totalError += $error;
                        $jumlahError++;
                        $error = round($error * 100, 2); // simpan dalam % di UI
                    }

                    $bulanData[$i]['prediksi'] = $prediksi;
                    $bulanData[$i]['error'] = $error;
                }

                $mape = $jumlahError > 0 ? round($totalError / $jumlahError * 100, 2) : null;
            } else {
                $mape = null;
            }

            $dataView[$produk->nama_produk] = [
                'bulan' => $bulanData,
                'mape' => $mape,
            ];
        }

        // Grafik (produk pertama)
        $labels = array_values($months);
        $actual = [];
        $prediction = [];

        if (!empty($dataView)) {
            $firstProduk = array_key_first($dataView);
            for ($i = 1; $i <= 12; $i++) {
                $actual[] = $dataView[$firstProduk]['bulan'][$i]['actual'] ?? null;
                $prediction[] = $dataView[$firstProduk]['bulan'][$i]['prediksi'] ?? null;
            }
        }

        return view('Operator.umkm.Laporan.LaporanTransaksiProdukUmkm.index',
            compact('year', 'months', 'dataView', 'labels', 'actual', 'prediction'));
    }


    // public function svr(Request $request)
    // {
    //     $year = $request->get('tahun', now()->year);
    //     $months = [
    //         1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
    //         7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
    //     ];
    //     $dataView = [];

    //     // Initialize a scaler for features
    //     $scaler = new MinMaxScaler(0, 1); // Scale month values between 0 and 1

    //     // Loop through each UMKM product to get their transaction data
    //     foreach (ProdukUmkm::all() as $produk) {
    //         $query = DB::table('transaksi_details')
    //             ->selectRaw('MONTH(created_at) as bulan, SUM(qty * harga) as pendapatan')
    //             ->where('produk_id', $produk->id)
    //             ->whereYear('created_at', $year)
    //             ->groupByRaw('MONTH(created_at)')
    //             ->orderByRaw('MONTH(created_at)')
    //             ->get();

    //         $bulanData = [];
    //         $trainSamples = []; // Features (month)
    //         $trainTargets = []; // Target (revenue)
    //         $actualDataExists = false; // Flag to check if any actual data is present

    //         // Populate actual data and prepare training samples
    //         foreach ($query as $row) {
    //             $bulan = intval($row->bulan);
    //             $pendapatan = floatval($row->pendapatan);

    //             $trainSamples[] = [$bulan]; // SVR expects samples as arrays of arrays
    //             $trainTargets[] = $pendapatan;

    //             $bulanData[$bulan] = [
    //                 'actual' => $pendapatan,
    //                 'prediksi' => null,
    //                 'error' => null,
    //             ];
    //             $actualDataExists = true;
    //         }

    //         // Inisialisasi semua bulan agar lengkap dengan nilai default
    //         for ($i = 1; $i <= 12; $i++) {
    //             if (!isset($bulanData[$i])) {
    //                 $bulanData[$i] = [
    //                     'actual' => null,
    //                     'prediksi' => null,
    //                     'error' => null,
    //                 ];
    //             }
    //         }

    //         // Process prediction only if there's enough actual data for training
    //         // SVR generally needs more than 1 point, ideally at least 2 or more for any meaningful pattern
    //         if (count($trainSamples) > 1) {
    //             try {
    //                 // Scale the training samples (months)
    //                 $scaledTrainSamples = $scaler->fit($trainSamples)->transform($trainSamples);

    //                 // You might also want to scale the targets if they vary widely
    //                 // For now, let's keep targets unscaled to directly predict revenue
    //                 // If scaling targets, remember to inverse transform predictions

    //                 // Initialize SVR model
    //                 // You can experiment with different Kernels (RBF, Linear, Polynomial)
    //                 // and hyperparameters (C, epsilon).
    //                 // C: Regularization parameter. Higher C means less regularization.
    //                 // Epsilon: Defines the epsilon-tube within which no penalty is associated in the training loss function.
    //                 $model = new SVR(Kernel::RBF, $C = 1.0, $epsilon = 0.1);

    //                 // Train the model
    //                 $model->train($scaledTrainSamples, $trainTargets);

    //                 $totalError = 0;
    //                 $jumlahError = 0;

    //                 for ($i = 1; $i <= 12; $i++) {
    //                     // Scale the month for prediction
    //                     $scaledMonth = $scaler->transform([[$i]])[0]; // Transform expects array of arrays

    //                     $prediksi = $model->predict($scaledMonth);
    //                     $prediksi = round($prediksi, 2);

    //                     $aktual = $bulanData[$i]['actual'];

    //                     $error = null;
    //                     // Calculate error only if actual data is available for that month and not zero
    //                     if (!is_null($aktual) && $aktual != 0) {
    //                         $error = abs(($aktual - $prediksi) / $aktual); // Error without *100
    //                         $totalError += $error;
    //                         $jumlahError++;
    //                         $error = round($error * 100, 2); // Store in % for UI
    //                     }

    //                     $bulanData[$i]['prediksi'] = $prediksi;
    //                     $bulanData[$i]['error'] = $error;
    //                 }

    //                 // Calculate Mean Absolute Percentage Error (MAPE)
    //                 $mape = $jumlahError > 0 ? round($totalError / $jumlahError * 100, 2) : null;

    //             } catch (\Exception $e) {
    //                 // Handle potential errors during SVR training (e.g., not enough distinct samples)
    //                 // Log the error for debugging
    //                 \Log::error("SVR prediction failed for product {$produk->nama_produk}: " . $e->getMessage());
    //                 $mape = null;
    //                 // Reset predictions for this product if an error occurs
    //                 foreach ($bulanData as &$data) {
    //                     $data['prediksi'] = null;
    //                     $data['error'] = null;
    //                 }
    //             }
    //         } else {
    //             // Not enough data to train SVR
    //             $mape = null;
    //             // If there's no actual data at all, set predictions to null
    //             if (!$actualDataExists) {
    //                 foreach ($bulanData as &$data) {
    //                     $data['prediksi'] = null;
    //                     $data['error'] = null;
    //                 }
    //             }
    //         }

    //         $dataView[$produk->nama_produk] = [
    //             'bulan' => $bulanData,
    //             'mape' => $mape,
    //         ];
    //     }

    //     // Prepare data for the chart (using the first product's data as an example)
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
    //         compact('year', 'months', 'dataView', 'labels', 'actual', 'prediction'));
    // }



}
