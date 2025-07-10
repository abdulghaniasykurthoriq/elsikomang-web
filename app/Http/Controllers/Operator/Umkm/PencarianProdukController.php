<?php

namespace App\Http\Controllers\Operator\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProdukUmkm;
use App\Services\TfidfSearchService;

class PencarianProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $produk = ProdukUmkm::when($query, function ($qBuilder) use ($query) {
            $qBuilder->where('nama_produk', 'like', "%$query%")
                     ->orWhere('deskripsi', 'like', "%$query%");
        })->get();

        return view('Operator.umkm.Pencarian.index', compact('produk', 'query'));
    }

    public function perbandingan(Request $request)
    {
        $query = $request->input('q');
        $produkAll = ProdukUmkm::all();

        $likeResults = ProdukUmkm::where('nama_produk', 'like', "%$query%")
            ->orWhere('deskripsi', 'like', "%$query%")
            ->get();

        $tfidfResults = (new TfidfSearchService)->search($produkAll, $query);

        // Ambil id untuk evaluasi
        $likeIds = $likeResults->pluck('id')->toArray();
        $tfidfIds = array_map(fn($item) => $item['produk']->id, $tfidfResults);

        $truePositive = count(array_intersect($likeIds, $tfidfIds));
        $precision = $truePositive / (count($tfidfIds) ?: 1);
        $recall = $truePositive / (count($likeIds) ?: 1);
        $f1 = ($precision + $recall) ? 2 * ($precision * $recall) / ($precision + $recall) : 0;

        return view('Operator.umkm.Pencarian.perbandingan', compact(
            'likeResults', 'tfidfResults', 'query', 'precision', 'recall', 'f1'
        ));
    }
}
