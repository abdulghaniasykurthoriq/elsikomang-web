<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProdukUmkm;
use App\Services\TfidfSearchService;

class ProdukUmkmSearchController extends Controller
{
    public function search(Request $request)
{
    $produk = ProdukUmkm::all();
    $hasil = (new TfidfSearchService)->search($produk, $request->input('q'));

    return response()->json(['results' => array_map(function ($item) {
        return [
            'id' => $item['produk']->id,
            'nama_produk' => $item['produk']->nama_produk,
            'deskripsi' => $item['produk']->deskripsi,
            'score' => $item['score'],
        ];
    }, $hasil)]);
}
}
