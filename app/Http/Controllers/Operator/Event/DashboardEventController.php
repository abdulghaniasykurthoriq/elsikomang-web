<?php

namespace App\Http\Controllers\Operator\Event;

use App\Http\Controllers\Controller;

class DashboardEventController extends Controller
{
    public function index()
    {return view('Operator.event.dashboard');
    }
}
