<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AlamatRequest;
use App\Models\Alamat;
use App\Models\Desa;

class AlamatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $alamat = Alamat::where('user_id', $userId)
            ->with(['provinsi', 'kota', 'kecamatan', 'desa'])
            ->get();

        return response()->json([
            'message' => 'Daftar alamat berhasil diambil',
            'data' => $alamat,
        ]);
    }

    public function store(AlamatRequest $request)
    {
        $desa = Desa::with('kecamatan.kota.provinsi')->findOrFail($request->desa_id);

        $alamat = Alamat::create([
            'desa_id' => $desa->id,
            'kecamatan_id' => $desa->kecamatan->id,
            'kota_id' => $desa->kecamatan->kota->id,
            'provinsi_id' => $desa->kecamatan->kota->provinsi->id,
            'kode_pos' => $request->kode_pos ?? $desa->kode_pos,
            'detail' => $request->detail,
            'default' => $request->boolean('default', false),
            'no_hp' => $request->no_hp,
            'nama_penerima' => $request->nama_penerima,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Alamat berhasil ditambahkan',
            'data' => $alamat->load(['provinsi', 'kota', 'kecamatan', 'desa']),
        ], 201);
    }

    public function show($id)
    {
        $alamat = Alamat::where('id', $id)
            ->where('user_id', auth()->id())
            ->with(['provinsi', 'kota', 'kecamatan', 'desa'])
            ->first();
        if (!$alamat) {
            return response()->json(['message' => 'Alamat tidak ditemukan'], 404);
        }

        return response()->json($alamat);
    }

    public function update(AlamatRequest $request, $id)
    {
        $alamat = Alamat::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $desa = Desa::with('kecamatan.kota.provinsi')->findOrFail($request->desa_id);

        $alamat->update([
            'desa_id' => $desa->id,
            'kecamatan_id' => $desa->kecamatan->id,
            'kota_id' => $desa->kecamatan->kota->id,
            'provinsi_id' => $desa->kecamatan->kota->provinsi->id,
            'kode_pos' => $request->kode_pos ?? $desa->kode_pos,
            'detail' => $request->detail,
            'default' => $request->boolean('default', false),
            'no_hp' => $request->no_hp,
            'nama_penerima' => $request->nama_penerima,
        ]);

        return response()->json([
            'message' => 'Alamat berhasil diperbarui',
            'data' => $alamat->load(['provinsi', 'kota', 'kecamatan', 'desa']),
        ]);
    }

    public function destroy($id)
    {
        $alamat = Alamat::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $alamat->delete();

        return response()->json(['message' => 'Alamat berhasil dihapus']);
    }
}
