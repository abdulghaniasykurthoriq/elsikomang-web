<?php

namespace App\Http\Controllers\Operator\Pariwisata;

use App\Models\Pariwisata;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PariwisataController extends Controller
{
    public function index()
    {
        $data = Pariwisata::with('fasilitas')->latest()->get();
        return view('Operator.pariwisata.data.index', compact('data'));
    }

    public function create()
    {
        $fasilitas = Fasilitas::all();
        return view('Operator.pariwisata.data.create', compact('fasilitas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image',
            'harga_tiket' => 'required|integer',
            'kategori' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'fasilitas' => 'nullable|array',
            'rating' => 'nullable|numeric|min:0|max:5',
            'jam_buka' => 'nullable|date_format:H:i',
            'jam_tutup' => 'nullable|date_format:H:i',
        ]);

        // Upload gambar
        $validated['gambar'] = $request->file('gambar')->store('pariwisata_images', 'public');

        $pariwisata = Pariwisata::create($validated);

        if ($request->has('fasilitas')) {
            $pariwisata->fasilitas()->sync($request->fasilitas);
        }

        return redirect()
            ->route('operator.pariwisata.data.index')
            ->with('success', 'Pariwisata berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pariwisata = Pariwisata::with('fasilitas')->findOrFail($id);
        $fasilitas = Fasilitas::all();

        return view('Operator.pariwisata.data.edit', [
            'item' => $pariwisata,
            'fasilitas' => $fasilitas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image',
            'harga_tiket' => 'required|integer',
            'kategori' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'fasilitas' => 'nullable|array',
            'rating' => 'nullable|numeric|min:0|max:5',
            'jam_buka' => 'nullable|date_format:H:i',
            'jam_tutup' => 'nullable|date_format:H:i',
        ]);

        $pariwisata = Pariwisata::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($pariwisata->gambar) {
                Storage::disk('public')->delete($pariwisata->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('pariwisata_images', 'public');
        } else {
            unset($validated['gambar']);
        }

        $pariwisata->update($validated);

        if ($request->has('fasilitas')) {
            $pariwisata->fasilitas()->sync($request->fasilitas);
        } else {
            $pariwisata->fasilitas()->sync([]); 
        }
        
        return redirect()
            ->route('operator.pariwisata.data.index')
            ->with('success', 'Data pariwisata berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pariwisata = Pariwisata::findOrFail($id);

        if ($pariwisata->gambar) {
            Storage::disk('public')->delete($pariwisata->gambar);
        }

        $pariwisata->fasilitas()->detach();
        $pariwisata->delete();

        return redirect()
            ->route('operator.pariwisata.data.index')
            ->with('success', 'Data pariwisata berhasil dihapus!');
    }
}
