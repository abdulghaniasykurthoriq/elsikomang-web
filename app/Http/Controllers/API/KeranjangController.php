<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KeranjangKuDumy;
use App\Models\ProdukDumy;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        

        $keranjang = KeranjangKuDumy::where('user_id', 2)
            ->with('varian.produk.member')
            ->get()
            ->groupBy('varian.produk.member_id')
            ->map(function ($items, $memberId) {
                $firstItem = $items->first();
                return [
                    'member_id' => $memberId,
                    'member_nama' => $firstItem->varian->produk->member->nama ?? null, // Ambil nama member
                    'items' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'user_id' => $item->user_id,
                            'varian_id' => $item->varian_id,
                            'member_id' => $item->member_id,
                            'jumlah' => $item->jumlah,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
                            'varian_nama' => $item->varian_nama,
                            'varian_harga' => $item->varian_harga,
                            'nama_produk' => $item->nama_produk,
                            'foto_produk' => $item->foto_produk,
                        ];
                    })->values()->toArray(),
                ];
            })->values()->toArray();


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
