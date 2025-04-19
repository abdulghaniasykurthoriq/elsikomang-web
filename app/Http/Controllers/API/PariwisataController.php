<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pariwisata;
use Illuminate\Http\Request;

class PariwisataController extends Controller
{
    public function index(Request $request){
        $search  = $request->query('search');
        $perPage = $request->query('per_page', 10);
        $query = Pariwisata::query();
        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }
        $data = $query->paginate($perPage);

        return response()->json($data);
    }
}
