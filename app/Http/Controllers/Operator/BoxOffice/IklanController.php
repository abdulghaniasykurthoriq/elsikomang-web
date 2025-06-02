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
        return view('Operator.box-office.Iklan.index', compact('iklans'));
    }

    public function create()
    {
        return view('Operator.box-office.Iklan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'slug' => 'required|string|unique:iklans,slug',
        ]);

        $iklan = Iklan::create($request->only('nama', 'slug'));

        // contoh dummy iklan data
        IklanData::create([
            'iklan_id' => $iklan->id,
            'gambar' => 'produk_image/dummy.jpg',
            'link' => 'http://localhost:8000/produk_image/dummy.jpg',
            'status' => 'active',
            'expired_at' => Carbon::now()->addDays(7),
        ]);

        return redirect()->route('Operator.box-office.Iklan.index')->with('success', 'Iklan berhasil ditambahkan.');
    }

    public function edit(Iklan $iklan)
    {
        return view('Operator.box-office.Iklan.edit', compact('iklan'));
    }

    public function update(Request $request, Iklan $iklan)
    {
        $request->validate([
            'nama' => 'required|string',
            'slug' => 'required|string|unique:iklans,slug,' . $iklan->id,
        ]);

        $iklan->update($request->only('nama', 'slug'));

        return redirect()->route('Operator.box-office.Iklan.index')->with('success', 'Iklan berhasil diperbarui.');
    }

    public function destroy(Iklan $iklan)
    {
        $iklan->data()->delete();
        $iklan->delete();
        return redirect()->route('Operator.box-office.Iklan.index')->with('success', 'Iklan berhasil dihapus.');
    }
    



    // public function index($jenis,$slug)
    // {   
    //     $iklan = Iklan::where('slug',$slug)->with('iklanData')->first();

    //     if(!$iklan){
    //         return redirect()->route('dashboard')->with('error', 'Iklan not found.');
    //     }
    //     return view('Operator.box-office.Iklan.index',[
    //         'iklan' => $iklan,
    //         'jenis' => $jenis,
    //     ]);
    // }

    // public function create($slug)
    // {
    //     $iklan = Iklan::where('slug',$slug)->with('iklanData')->first();

    //     if(!$iklan){
    //         return redirect()->route('dashboard')->with('error', 'Iklan not found.');
    //     }
    //     return view('Operator.box-office.Iklan.create',[
    //         'iklan' => $iklan,
    //     ]);
    // }
    // public function store(Request $request)
    // {
    //     // Logic to store the iklan
    //     dd("hello");
    //     return redirect()->route('Operator.BoxOffice.Iklan.index')->with('success', 'Iklan created successfully.');
    // }
}
