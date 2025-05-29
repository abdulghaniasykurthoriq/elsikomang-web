<?php

namespace App\Http\Controllers\Operator\Pariwisata;

use App\Models\Pariwisata;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            'deskripsi' => 'required',
            'gambar' => 'required|image',
            'harga_tiket' => 'required|integer',
            'kategori' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'fasilitas' => 'array|nullable',
        ]);

        $path = $request->file('gambar')->store('pariwisata_images', 'public');
        $validated['gambar'] = $path;

        $pariwisata = Pariwisata::create($validated);

        if ($request->has('fasilitas')) {
            $pariwisata->fasilitas()->sync($request->fasilitas);
        }

        return redirect()
            ->route('operator.pariwisata.data.index', ['jenis' => request()->route('jenis')])
            ->with('success', 'Pariwisata berhasil ditambahkan!');
    }

    public function edit($jenis, $id)
    {
        $pariwisata = Pariwisata::with('fasilitas')->findOrFail($id);
        $fasilitas = Fasilitas::all();
        return view('Operator.pariwisata.data.edit', [
            'item' => $pariwisata,
            'fasilitas' => $fasilitas,
            'jenis' => $jenis,
        ]);
    }

    public function update(Request $request, $jenis, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image',
            'harga_tiket' => 'required|integer',
            'kategori' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'fasilitas' => 'array|nullable',
        ]);

        $pariwisata = Pariwisata::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('pariwisata_images', 'public');
            $validated['gambar'] = $path;
        } else {
            unset($validated['gambar']);
        }

        $pariwisata->update($validated);
        $pariwisata->fasilitas()->sync($request->fasilitas);

        return redirect()
            ->route('operator.pariwisata.data.index', ['jenis' => request()->route('jenis')])
            ->with('success', 'Data pariwisata berhasil diupdate!');
    }

    public function destroy($jenis, $id)
    {
        $pariwisata = Pariwisata::findOrFail($id);
        $pariwisata->fasilitas()->detach();
        $pariwisata->delete();

        return redirect()
            ->route('operator.pariwisata.data.index', ['jenis' => request()->route('jenis')])
            ->with('success', 'Data pariwisata berhasil dihapus!');
    }
}
