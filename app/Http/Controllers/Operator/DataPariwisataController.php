<?php

namespace App\Http\Controllers\operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataPariwisata;

class DataPariwisataController extends Controller
{
    public function index($jenis)
    {
        $data = DataPariwisata::all();
        return view("operator.$jenis.data.index", compact('data'));
    }

    public function create($jenis)
    {
        return view("operator.$jenis.data.create");
    }

    public function store(Request $request, $jenis)
    {
        DataPariwisata::create($request->all());
        return redirect()->route('operator.pariwisata.data.index', ['jenis' => $jenis])
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($jenis, $id)
    {
        $item = DataPariwisata::findOrFail($id);
        return view("operator.$jenis.data.edit", compact('item'));
    }

    public function update(Request $request, $jenis, $id)
    {
        $item = DataPariwisata::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('operator.pariwisata.data.index', ['jenis' => $jenis])
            ->with('success', 'Data berhasil diperbarui.');
    }


    public function destroy(Request $request, $jenis, $id)
    {
        DataPariwisata::destroy($id);
        return redirect()->route('operator.pariwisata.data.index', ['jenis' => $jenis])
            ->with('success', 'Data berhasil dihapus.');
    }
}
