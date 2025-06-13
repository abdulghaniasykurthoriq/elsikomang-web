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
        $totalProduk = ProdukUmkm::count();
        $totalMember = MemberUmkm::count();
        $totalKategori = KategoriProduk::count();
        $produkTerbaru = ProdukUmkm::latest()->take(5)->with('member')->get();

        return view('Operator.umkm.ProdukUmkm.dashboard', compact(
            'totalProduk', 'totalMember', 'totalKategori', 'produkTerbaru'
        ));
    }
}
