<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPariwisata;

class LaporanPariwisataController extends Controller
{

    public function index($jenis)
    {
        $laporanPariwisatas = LaporanPariwisata::all();
        return view('operator.pariwisata.laporan.index', compact('laporanPariwisatas', 'jenis'));
    }

    public function create($jenis)
    {
        return view('operator.pariwisata.laporan.create', compact('jenis'));
    }

    public function store(Request $request, $jenis)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'periode' => 'required|in:harian,bulanan,tahunan',
            'nama_wisata' => 'required|string',
            'jumlah_viewer' => 'required|integer|min:0',
        ]);

        LaporanPariwisata::create($request->all());
        return redirect()->route('operator.pariwisata.laporan.index', ['jenis' => $jenis])
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit($jenis, $id)
    {
        $laporan = LaporanPariwisata::findOrFail($id);
        return view('operator.pariwisata.laporan.edit', compact('laporan', 'jenis'));
    }

    public function update(Request $request, $jenis, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'periode' => 'required|in:harian,bulanan,tahunan',
            'nama_wisata' => 'required|string',
            'jumlah_viewer' => 'required|integer|min:0',
        ]);

        $laporan = LaporanPariwisata::findOrFail($id);
        $laporan->update($request->all());

        return redirect()->route('operator.pariwisata.laporan.index', ['jenis' => $jenis])
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($jenis, $id)
    {
        LaporanPariwisata::destroy($id);
        return redirect()->route('operator.pariwisata.laporan.index', ['jenis' => $jenis])
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
