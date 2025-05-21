<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\JenisOperator; // Pastikan model JenisOperator sudah ada
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, $jenis)
    {
        $jenisOperator = JenisOperator::where('url_parameter', $jenis)->first();

        if (!$jenisOperator) {
            abort(404); // Jika jenis_operator tidak ditemukan
        }

        return view("Operator.$jenis.dashboard", compact('jenis'));
    }

    }

