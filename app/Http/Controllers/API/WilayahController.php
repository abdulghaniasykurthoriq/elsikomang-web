<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use Illuminate\Http\Request;
use App\Models\Provinsi;
class WilayahController extends Controller
{
    public function provinsi()
    {
        $provinsi = Provinsi::all();

        return response()->json([
            'status' => 'success',
            'data' => $provinsi
        ]);
    }
    public function kota($id)
    {
        $kota = Kota::where('provinsi_id',$id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $kota
        ]);
    }
    public function kecamatan($id)
    {
        $kecamatan = Kecamatan::where('kota_id',$id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $kecamatan
        ]);
    }
    public function desa($id)
    {
        $desa = Desa::where('kecamatan_id',$id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $desa
        ]);
    }
}
