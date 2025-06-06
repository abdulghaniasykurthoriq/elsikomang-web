<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Investasi;
use Illuminate\Http\Request;

class InvestasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Investasi::query();

        // Search by nama
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_investasi', 'like', '%' . $request->search . '%');
        }

        // Pagination, default 10 per halaman
        $entertaiments = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json([
            'message' => 'List data investasi',
            'data' => $entertaiments
        ]);
    }
    public function show($id)
    {
        $investasi = Investasi::findOrFail($id);

        return response()->json([
            'message' => 'Detail data investasi',
            'data' => $investasi
        ]);
    }
}
