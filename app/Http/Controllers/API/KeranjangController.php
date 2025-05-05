<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\KeranjangKuDumy;
use App\Models\ProdukDumy;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        
        
        $keranjang = Keranjang::with([
    'keranjangDetail.produkUmkm.images',
    'keranjangDetail.produkVariant'
])->where('user_id', 2)->get();

// Sembunyikan relasi `produk_umkm` di setiap item keranjangDetail
// $keranjang->each(function ($item) {
//     $item->keranjangDetail->each(function ($detail) {
//         // Pastikan ini model KeranjangDetail
//         $detail->setRelation('produkUmkm', null); // Hapus relasi
//     });
// });
            // dd($keranjang);

        return response()->json([
            'message' => 'Keranjang retrieved successfully',
            'data' => $keranjang
        ]);
    }

    public function add(Request $request)
    {
        $userId = 2; // Atau ambil dari autentikasi user: auth()->id()
        $varianId = 9; // Pastikan Anda mengirimkan varian_id dari form

        KeranjangKuDumy::updateOrCreate(
            [
                'user_id' => $userId,
                'varian_id' => $varianId,
            ],
            [
                'jumlah' => $request->jumlah, // Nilai yang akan dibuat atau diperbarui
                'member_id' => $request->member_id ?? null, // Contoh kolom lain yang mungkin perlu diisi
                // Kolom lain yang ingin Anda atur saat membuat atau memperbarui
            ]
        );

    return response()->json(['message' => 'Keranjang berhasil ditambahkan/diperbarui']);
}
}
