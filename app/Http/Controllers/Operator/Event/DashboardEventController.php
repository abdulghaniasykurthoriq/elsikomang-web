<?php

namespace App\Http\Controllers\Operator\Event;

use App\Http\Controllers\Controller;
use App\Models\OperatorEvent;

class DashboardEventController extends Controller
{
    public function index()
    {
        $totalEvent = OperatorEvent::count();

        return view('Operator.event.dashboard', compact('totalEvent'));
    }
}
