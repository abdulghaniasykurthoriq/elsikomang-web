<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\JenisOperator; // Pastikan model JenisOperator sudah ada
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($jenis)
    {
        $view = 'Operator.' . strtolower($jenis) . '.dashboard';
    
        if (view()->exists($view)) {
            return view($view);
        }
    
        abort(404, 'Halaman dashboard untuk jenis operator ini tidak ditemukan.');
    }
    

    }

