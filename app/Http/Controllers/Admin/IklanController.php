<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use Illuminate\Http\Request;

class IklanController extends Controller
{
    public function index($slug)
    {   
        $iklan = Iklan::where('slug',$slug)->with('iklanData')->first();

        if(!$iklan){
            return redirect()->route('dashboard')->with('error', 'Iklan not found.');
        }
        return view('Operator.BoxOffice.Iklan.index',[
            'iklan' => $iklan,
        ]);
    }

    public function create($slug)
    {
        $iklan = Iklan::where('slug',$slug)->with('iklanData')->first();

        if(!$iklan){
            return redirect()->route('dashboard')->with('error', 'Iklan not found.');
        }
        return view('Operator.BoxOffice.Iklan.create',[
            'iklan' => $iklan,
        ]);
    }
    public function store(Request $request)
    {
        // Logic to store the iklan
        dd("hello");
        return redirect()->route('admin.iklan.index')->with('success', 'Iklan created successfully.');
    }
}
