<?php

namespace App\Http\Controllers\Operator\BoxOffice;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use App\Models\IklanData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    return redirect()
    ->to(route('iklandata.index') . '?q=' . $request->iklan_slug)
    ->with('success', 'Data berhasil dihapus.');

}


    public function edit($id)
    {
        $iklandata = IklanData::findOrFail($id);
        $iklan = Iklan::findOrFail($iklandata->iklan_id);
        return view('Operator.box-office.Iklan.content.edit', compact('iklandata', 'iklan'));
    }


public function update(Request $request, $id)
{
    $iklanData = IklanData::with('iklan')->findOrFail($id);

    // Validasi umum
    $request->validate([
        'link' => 'required|url',
        'status' => 'required|in:active,inactive',
        'expired_at' => 'required|date',
    ]);

    // Validasi & proses upload gambar jika ada
    if ($request->hasFile('gambar')) {
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hapus gambar lama jika ada
        if ($iklanData->gambar && Storage::disk('public')->exists($iklanData->gambar)) {
            Storage::disk('public')->delete($iklanData->gambar);
        }

        // Simpan gambar baru
        $gambarPath = $request->file('gambar')->store('iklan_images', 'public');
        $iklanData->gambar = $gambarPath;
    }

    // Update data lainnya (manual agar tidak overwrite gambar jika kosong)
    $iklanData->link = $request->link;
    $iklanData->status = $request->status;
    $iklanData->expired_at = $request->expired_at;

    $iklanData->save();

    return redirect()
        ->to(route('iklandata.index') . '?q=' . $request->iklan_slug)
        ->with('success', 'Data berhasil diubah.');
}


    public function destroy($id)
{
    $iklanData = IklanData::findOrFail($id);

    // Jika path gambar ada dan file ada di disk 'public'
    if ($iklanData->gambar && Storage::disk('public')->exists($iklanData->gambar)) {
        Storage::disk('public')->delete($iklanData->gambar);
    }

    $iklanData->delete();

    return redirect()->back()->with('success', 'Data berhasil dihapus.');
}
}
