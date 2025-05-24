<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProdukUmkm;
use Illuminate\Http\Request;
use Phpml\Clustering\KMeans;

class KMeansController extends Controller
{
    public function klasterisasiProduk()
    {
        // Ambil semua produk beserta variannya
        $produk = ProdukUmkm::with('produk_variant')->get();
    
        // Ambil fitur harga dari tiap varian produk
        $samples = [];
        $produkMap = []; // Untuk menyimpan mapping hasil ke produk
    
        foreach ($produk as $index => $item) {
            foreach ($item->produk_variant as $variant) {
                $samples[] = [(float)$variant->harga];
                $produkMap[] = [
                    'produk_id' => $item->id,
                    'nama_produk' => $item->nama_produk,
                    'varian' => $variant->varian,
                    'harga' => $variant->harga,
                ];
            }
        }
    
        if (count($samples) < 2) {
            return back()->withErrors('Data tidak cukup untuk klasterisasi.');
        }
    
        // Jumlah cluster (misalnya 3: murah, sedang, mahal)
        $clusterCount = 3;
    
        // Jalankan KMeans
        $kmeans = new KMeans($clusterCount);
        $clusters = $kmeans->cluster($samples);
    
        // Gabungkan hasil klaster dengan data produk
        $hasilKlaster = [];
        foreach ($clusters as $i => $cluster) {
            foreach ($cluster as $point) {
                // Cari posisi point di sample
                $index = array_search($point, $samples);
                $hasilKlaster[] = [
                    'cluster' => $i,
                    'produk' => $produkMap[$index],
                ];
            }
        }
    
        return view('Operator.ProdukUmkm.klaster', compact('hasilKlaster'));
    }
}    