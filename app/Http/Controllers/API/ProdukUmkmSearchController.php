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
        $query = $request->input('q');
        if (!$query) {
            return response()->json(['error' => 'Query kosong'], 400);
        }

        $produk = ProdukUmkm::all();
        $hasil = (new TfidfSearchService)->search($produk, $query);

        return response()->json(['results' => array_map(function ($item) {
            $produk = $item['produk'];
            return [
                'id' => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'deskripsi' => $produk->deskripsi,
                'produk_variant' => $produk->produk_variant, // Tambahkan
                'images' => $produk->images, // Tambahkan
                'member' => $produk->member, // Tambahkan
                'kategori' => $produk->kategori, // Sudah ada
                'created_at' => $produk->created_at,
                'updated_at' => $produk->updated_at,
                'score' => $item['score'],
            ];
        }, $hasil)]);
    }
}
