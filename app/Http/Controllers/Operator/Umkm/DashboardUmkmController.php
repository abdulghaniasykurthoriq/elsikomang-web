<?php

namespace App\Http\Controllers\Operator\Umkm;

use App\Http\Controllers\Controller;
use App\Models\ProdukUmkm;
use App\Models\MemberUmkm;
use App\Models\KategoriProduk;

class DashboardUmkmController extends Controller
{
    public function index()
    {
        // Total data
        $totalProduk = ProdukUmkm::count();
        $totalMember = MemberUmkm::count();
        $totalKategori = KategoriProduk::count();

        // Produk terbaru (5 terakhir)
        $produkTerbaru = ProdukUmkm::with('member')
            ->latest()
            ->take(5)
            ->get();

        return view('Operator.umkm.dashboard', compact(
            'totalProduk',
            'totalMember',
            'totalKategori',
            'produkTerbaru'
        ));
    }
}
