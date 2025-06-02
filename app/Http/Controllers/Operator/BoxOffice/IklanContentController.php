<?php

namespace App\Http\Controllers\Operator\BoxOffice;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use App\Models\IklanData;
use Illuminate\Http\Request;

class IklanContentController extends Controller
{
    public function index(Request $request)
    {
        $slug = $request->query('q'); // Default slug, bisa diubah sesuai kebutuhan
        $iklan = Iklan::where('slug', $slug)->firstOrFail();


        $iklanData = IklanData::where('iklan_id',$iklan->id)->get();
        return view('Operator.box-office.Iklan.content.index', compact('iklanData','iklan'));
    }

    public function create(Request $request)
    {
        $slug = $request->query('q'); // Default slug, bisa diubah sesuai kebutuhan
        $iklan = Iklan::where('slug', $slug)->firstOrFail();
        
        return view('Operator.box-office.Iklan.content.create',compact('iklan'));
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'iklan_id' => 'required|integer',
        'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'link' => 'required|url',
        'status' => 'required|in:active,inactive',
        'expired_at' => 'required|date',
    ]);

    // Simpan file gambar
    $gambarPath = $request->file('gambar')->store('iklan_images', 'public');

    // Buat data iklan
    IklanData::create([
        'iklan_id' => $request->iklan_id,
        'gambar' => $gambarPath, // path file disimpan di DB
        'link' => $request->link,
        'status' => $request->status,
        'expired_at' => $request->expired_at,
    ]);

    return redirect()->route('iklan-data.index')->with('success', 'Data berhasil ditambahkan.');
}


    public function edit($jenis,$id)
    {
        $iklanData = IklanData::findOrFail($id);
        $iklan = Iklan::findOrFail($iklanData->iklan_id);
        return view('Operator.box-office.Iklan.content.edit', compact('iklanData','iklan'));
    }

    public function update(Request $request, $jenis, $id)
    {
        $iklanData = IklanData::with('iklan')->findOrFail($id);

        // Validasi input
        if ($request->hasFile('gambar')) {
            $request->validate([
                'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);
            // Simpan file gambar
            $gambarPath = $request->file('gambar')->store('iklan_images', 'public');
            $iklanData->gambar = $gambarPath; // Update path file
        }
        $request->validate([
            'iklan_id' => 'required|integer',
            'link' => 'required|url',
            'status' => 'required|in:active,inactive',
            'expired_at' => 'required|date',
        ]);

        $iklanData->update($request->all());

        return redirect()->route('iklandata.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(IklanData $iklanData)
    {
        $iklanData->delete();
        return redirect()->route('iklan-data.index')->with('success', 'Data berhasil dihapus.');
    }
}
