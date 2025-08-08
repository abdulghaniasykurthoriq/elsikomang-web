<?php

namespace App\Http\Controllers\Operator\Investasi;

use App\Http\Controllers\Controller;
use App\Models\Investasi;

class DashboardInvestasiController extends Controller
{
    public function index()
    {
        $totalInvestasi = Investasi::count();
        $investasiTerbaru = Investasi::latest()->take(5)->get();

        return view('Operator.investasi.dashboard', compact(
            'totalInvestasi',
            'investasiTerbaru'
        ));
    }
}
