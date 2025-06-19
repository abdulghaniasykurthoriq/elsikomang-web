<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKeranjangRequest;
use App\Models\Keranjang;
use App\Models\KeranjangDetail;

class KeranjangController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $keranjang = Keranjang::with([
            'keranjangDetail.produkUmkm.images',
            'keranjangDetail.produkVariant'
        ])->where('user_id', $user->id)->get();

        return response()->json([
            'message' => 'Keranjang retrieved successfully',
            'data' => $keranjang
        ]);
    }

    public function add(StoreKeranjangRequest $request)
    {
        $validated = $request->validated();
        $user = auth()->user();
        $keranjang = Keranjang::firstOrCreate(
            [
                'user_id' => $user->id,
                'member_id' => $validated['member_id'],
            ]
        );
        $keranjangDetail = KeranjangDetail::where('keranjang_id', $keranjang->id)
            ->where('produk_umkm_id', $validated['produk_umkm_id'])
            ->where('produk_variant_id', $validated['produk_variant_id'])
            ->first();

        if ($keranjangDetail) {
            $keranjangDetail->jumlah += 1;
            $keranjangDetail->save();
        } else {
            KeranjangDetail::create([
                'keranjang_id' => $keranjang->id,
                'produk_umkm_id' => $validated['produk_umkm_id'],
                'produk_variant_id' => $validated['produk_variant_id'],
                'jumlah' => 1,
            ]);
        }

        return response()->json(['message' => 'Keranjang berhasil ditambahkan/diperbarui']);
    }

    public function minus(StoreKeranjangRequest $request)
    {
        $validated = $request->validated();
        $user = auth()->user();

        // Cari keranjang berdasarkan user dan member
        $keranjang = Keranjang::where('user_id', $user->id)
            ->where('member_id', $validated['member_id'])
            ->first();

        if (!$keranjang) {
            return response()->json(['message' => 'Keranjang tidak ditemukan'], 404);
        }

        // Cari item di dalam keranjang
        $keranjangDetail = KeranjangDetail::where('keranjang_id', $keranjang->id)
            ->where('produk_umkm_id', $validated['produk_umkm_id'])
            ->where('produk_variant_id', $validated['produk_variant_id'])
            ->first();

        if (!$keranjangDetail) {
            return response()->json(['message' => 'Produk tidak ditemukan dalam keranjang'], 404);
        }

        // Kurangi jumlah atau hapus jika tinggal 1
        if ($keranjangDetail->jumlah > 1) {
            $keranjangDetail->jumlah -= 1;
            $keranjangDetail->save();
        } else {
            $keranjangDetail->delete();
        }

        // Cek apakah keranjang masih punya detail
        $sisaDetail = KeranjangDetail::where('keranjang_id', $keranjang->id)->count();

        // Jika tidak ada detail tersisa, hapus keranjang juga
        if ($sisaDetail === 0) {
            $keranjang->delete();
        }

        return response()->json(['message' => 'Jumlah produk berhasil dikurangi / dihapus']);
    }


    public function countKeranjang()
    {
        $counts = Keranjang::select('status')
            ->where('user_id', auth()->id())
            ->join('keranjang_details', 'keranjang_details.keranjang_id', '=', 'keranjangs.id')
            ->selectRaw('status, SUM(keranjang_details.qty) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'message' => 'Statistik keranjang berhasil diambil',
            'data' => $counts,
        ]);
    }




}
