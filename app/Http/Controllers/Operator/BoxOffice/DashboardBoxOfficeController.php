<?php

namespace App\Http\Controllers\Operator\BoxOffice;

use App\Http\Controllers\Controller;

class DashboardBoxOfficeController extends Controller
{
    public function index()
    {return view('Operator.box-office.dashboard');
    }
}
