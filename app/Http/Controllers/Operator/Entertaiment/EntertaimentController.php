<?php

namespace App\Http\Controllers\Operator\Entertaiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entertaiment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntertaimentController extends Controller
{
    public function index($jenis)
    {
        $entertaiments = Entertaiment::latest()->get();
        return view('Operator.Entertaiment.index', compact('entertaiments', 'jenis'));
    }

    public function create($jenis)
    {
        return view('Operator.Entertaiment.create', compact('jenis'));
    }

    public function store(Request $request, $jenis)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'foto_entertaiment' => 'nullable|image|max:2048',
                'nama_entertaiment' => 'required|string',
                'deskripsi' => 'required|string',
            ]);

            if ($request->hasFile('foto_entertaiment')) {
                $data['foto_entertaiment'] = $request->file('foto_entertaiment')->store('entertaiments', 'public');
            }

            $data['created_by'] = Auth::user()->name ?? 'admin';

            Entertaiment::create($data);
            DB::commit();

            return redirect()->route('entertaiment.index', ['jenis' => $jenis])
                             ->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit($jenis, $id)
    {
        $entertaiments = Entertaiment::findOrFail($id);
        return view('Operator.Entertaiment.edit', compact('entertaiments', 'jenis'));
    }

    public function update(Request $request, $jenis, $id)
    {
        DB::beginTransaction();
        try {
            $entertaiments = Entertaiment::findOrFail($id);

            $data = $request->validate([
                'foto_entertaiment' => 'nullable|image|max:2048',
                'nama_entertaiment' => 'required|string',
                'deskripsi' => 'required|string',
            ]);

            if ($request->hasFile('foto_entertaiment')) {
                $data['foto_entertaiment'] = $request->file('foto_entertaiment')->store('entertaiments', 'public');
            }

            $data['updated_by'] = Auth::user()->name ?? 'admin';

            $entertaiments->update($data);
            DB::commit();

            return redirect()->route('entertaiment.index', ['jenis' => $jenis])
                             ->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function destroy($jenis, $id)
    {
        $entertaiments = Entertaiment::findOrFail($id);
        $entertaiments->delete();

        return redirect()->route('entertaiment.index', ['jenis' => $jenis])
                         ->with('success', 'Data berhasil dihapus.');
    }
}
