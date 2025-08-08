<?php

namespace App\Http\Controllers\Operator\Entertaiment;

use App\Http\Controllers\Controller;
use App\Models\Entertaiment;

class DashboardEntertaimentController extends Controller
{
    public function index()
    {
        $totalEntertaiment = Entertaiment::count();

        return view('Operator.entertaiment.dashboard', compact('totalEntertaiment'));
    }
}
