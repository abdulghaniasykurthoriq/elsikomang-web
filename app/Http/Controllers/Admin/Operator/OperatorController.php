<?php

namespace App\Http\Controllers\Admin\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->query('jenis');

        // nanti kamu bisa filter data berdasarkan ini
        // contoh: $operators = Operator::where('jenis', $jenis)->get();

        return view('Admin.Operator.index', compact('jenis'));
    }
}
