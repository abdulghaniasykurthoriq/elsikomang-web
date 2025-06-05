<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use Illuminate\Http\Request;

class IklanController extends Controller
{
    public function index()
    {
        $iklans = Iklan::with('iklanData')->get();
        return response()->json([
            'status' => 'success',
            'data' => $iklans
        ]);
    }
}
