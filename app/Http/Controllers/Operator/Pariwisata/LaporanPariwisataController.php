<?php

namespace App\Http\Controllers\Operator\Pariwisata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPariwisata;

class LaporanPariwisataController extends Controller
{
    public function index()
    {
        $laporanPariwisatas = LaporanPariwisata::all();
        return view('Operator.pariwisata.laporan.index', compact('laporanPariwisatas'));
    }

    public function create()
    {
        return view('Operator.pariwisata.laporan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'periode' => 'required|in:harian,bulanan,tahunan',
            'nama_wisata' => 'required|string',
            'jumlah_viewer' => 'required|integer|min:0',
        ]);

        LaporanPariwisata::create($request->all());
        return redirect()
            ->route('operator.pariwisata.laporan.index')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit( $id)
    {
        $laporan = LaporanPariwisata::findOrFail($id);
        return view('Operator.pariwisata.laporan.edit', compact('laporan'));
    }

    public function update(Request $request,  $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'periode' => 'required|in:harian,bulanan,tahunan',
            'nama_wisata' => 'required|string',
            'jumlah_viewer' => 'required|integer|min:0',
        ]);

        $laporan = LaporanPariwisata::findOrFail($id);
        $laporan->update($request->all());

        return redirect()
            ->route('operator.pariwisata.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy( $id)
    {
        LaporanPariwisata::destroy($id);
        return redirect()
            ->route('operator.pariwisata.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
