<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProdukUmkm;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search'); // menangkap parameter ?search=
        $perPage = $request->query('per_page', 10); // Default ke 10 jika tidak diberikan

        $produk = ProdukUmkm::with(['produk_variant', 'images', 'member', 'kategori'])
            ->when($search, function ($query) use ($search) {
                $query->where('nama_produk', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return response()->json($produk);
    }
    public function show($id)
    {
        $produk = ProdukUmkm::with(['produk_variant', 'images', 'member', 'kategori'])
            ->where('id', $id)
            ->first();

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json($produk);
    }
}
