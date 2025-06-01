<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OperatorEvent;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = OperatorEvent::query();
        if ($request->has('nama_event') && $request->nama_event != '') {
            $query->where('nama_event', 'like', '%' . $request->nama_event . '%');
        }
        $operator_events = $query->latest()->paginate(10);

        return response()->json($operator_events);
    }
}
