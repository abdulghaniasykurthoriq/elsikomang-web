<?php

namespace App\Http\Controllers\Operator\BoxOffice;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use App\Models\IklanData;

class DashboardBoxOfficeController extends Controller
{
    public function index()
    {
        $totalIklan = Iklan::count();
        $totalDataIklan = IklanData::count();
        $iklanAktif = IklanData::where('status', 'aktif')->count();
        $iklanExpired = IklanData::where('expired_at', '<', now())->count();

        return view('Operator.box-office.dashboard', compact(
            'totalIklan',
            'totalDataIklan',
            'iklanAktif',
            'iklanExpired'
        ));
    }
}
