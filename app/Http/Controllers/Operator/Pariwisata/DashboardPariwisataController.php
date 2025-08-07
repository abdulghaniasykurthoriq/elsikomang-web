<?php

namespace App\Http\Controllers\Operator\Pariwisata;

use App\Http\Controllers\Controller;
use App\Models\Pariwisata;

class DashboardPariwisataController extends Controller
{
    public function index()
    {
        $totalPariwisata = Pariwisata::count();

        // Rating Tertinggi
        $ratingTertinggi = Pariwisata::max('rating');

        // Harga Tiket Tertinggi
        $hargaTiketTertinggi = Pariwisata::max('harga_tiket');

        return view('Operator.pariwisata.dashboard', compact('totalPariwisata', 'ratingTertinggi', 'hargaTiketTertinggi'));
    }
}
