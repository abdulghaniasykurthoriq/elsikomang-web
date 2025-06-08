<?php

namespace App\Http\Controllers\Operator\BoxOffice;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use App\Models\IklanData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IklanController extends Controller
{

    public function index()
    {
        $iklans = Iklan::with('iklanData')->get();
        return view('Operator.box-office.iklan.index', compact('iklans'));
    }
    
}
