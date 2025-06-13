<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Entertaiment;
use Illuminate\Http\Request;

class EntertaitmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Entertaiment::query();

        // Search by nama
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_entertaiment', 'like', '%' . $request->search . '%');
        }

        // Pagination, default 10 per halaman
        $entertaiments = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json([
            'message' => 'List data entertaiment',
            'data' => $entertaiments
        ]);
    }
    public function show($id)
    {
        $entertaiment = Entertaiment::findOrFail($id);

        return response()->json([
            'message' => 'Detail data entertaiment',
            'data' => $entertaiment
        ]);
    }
}
