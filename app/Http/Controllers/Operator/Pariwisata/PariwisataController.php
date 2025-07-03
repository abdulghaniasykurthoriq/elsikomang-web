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
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'harga_tiket' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'fasilitas' => 'nullable|array',
            'rating' => 'nullable|numeric|min:0|max:5',
            'jam_buka' => 'nullable|regex:/^\d{2}:\d{2}$/',
            'jam_tutup' => 'nullable|regex:/^\d{2}:\d{2}$/',
        ]);

        // Format jam agar sesuai H:i:s
        $validated['jam_buka'] = $request->jam_buka ? $request->jam_buka . ':00' : null;
        $validated['jam_tutup'] = $request->jam_tutup ? $request->jam_tutup . ':00' : null;

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('pariwisata_images', 'public');
        }

        // Simpan data
        $pariwisata = Pariwisata::create($validated);

        // Simpan relasi fasilitas
        if ($request->has('fasilitas')) {
            $pariwisata->fasilitas()->sync($request->fasilitas);
        }

        return redirect()->route('operator.pariwisata.data.index')->with('success', 'Pariwisata berhasil ditambahkan!');
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
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'harga_tiket' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'fasilitas' => 'nullable|array',
            'rating' => 'nullable|numeric|min:0|max:5',
            'jam_buka' => 'nullable',
            'jam_tutup' => 'nullable',
        ]);

        $pariwisata = Pariwisata::findOrFail($id);

        // Format waktu ke H:i:s
        $validated['jam_buka'] = $request->jam_buka ? $request->jam_buka . ':00' : null;
        $validated['jam_tutup'] = $request->jam_tutup ? $request->jam_tutup . ':00' : null;

        // Ganti gambar jika diupload
        if ($request->hasFile('gambar')) {
            if ($pariwisata->gambar && Storage::disk('public')->exists($pariwisata->gambar)) {
                Storage::disk('public')->delete($pariwisata->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('pariwisata_images', 'public');
        } else {
            unset($validated['gambar']);
        }

        // Update data
        $pariwisata->update($validated);

        // Update relasi fasilitas
        $pariwisata->fasilitas()->sync($request->input('fasilitas', []));

        return redirect()->route('operator.pariwisata.data.index')->with('success', 'Data pariwisata berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pariwisata = Pariwisata::findOrFail($id);

        if ($pariwisata->gambar) {
            Storage::disk('public')->delete($pariwisata->gambar);
        }

        $pariwisata->fasilitas()->detach();
        $pariwisata->delete();

        return redirect()->route('operator.pariwisata.data.index')->with('success', 'Data pariwisata berhasil dihapus!');
    }
}
