<?php

namespace App\Http\Controllers\Operator\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeastSquaresController extends Controller
{
    public function index()
    {
        return view('Operator.umkm.LeastSquares.index');
    }

    public function proses(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|array|min:5',
            'bulan.*' => 'required|numeric',
        ]);

        $samples = [];
        $targets = [];

        foreach ($validated['bulan'] as $index => $nilai) {
            $samples[] = [$index + 1];
            $targets[] = $nilai;
        }

        // Hitung Least Squares
        $n = count($samples);
        $sumX = $sumY = $sumXY = $sumX2 = 0;

        foreach ($samples as $i => $x) {
            $xi = $x[0];
            $yi = $targets[$i];
            $sumX += $xi;
            $sumY += $yi;
            $sumXY += $xi * $yi;
            $sumX2 += $xi * $xi;
        }

        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $intercept = ($sumY - $slope * $sumX) / $n;

        $prediksi = [];
        for ($i = 1; $i <= 12; $i++) {
            $prediksi[$i] = round($intercept + $slope * $i, 2);
        }

        return view('Operator.umkm.LeastSquares.index', [
            'input' => $validated['bulan'],
            'prediksi' => $prediksi,
        ]);
    }
}
