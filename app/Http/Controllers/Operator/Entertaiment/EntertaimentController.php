<?php

namespace App\Http\Controllers\Operator\Entertaiment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entertaiment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntertaimentController extends Controller
{
    public function index()
    {
        $entertaiments = Entertaiment::latest()->get();
        return view('Operator.entertaiment.index', compact('entertaiments'));
    }

    public function create()
    {
        return view('Operator.entertaiment.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'foto_entertaiment' => 'required|image|max:2048',
                'nama_entertaiment' => 'required|string',
                'deskripsi' => 'required|string',
            ]);

            if ($request->hasFile('foto_entertaiment')) {
                $data['foto_entertaiment'] = $request->file('foto_entertaiment')->store('entertaiments', 'public');
            }

            $data['created_by'] = Auth::user()->name ?? 'admin';

            Entertaiment::create($data);
            DB::commit();

            return redirect()->route('entertaiment.index')
                             ->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $entertaiments = Entertaiment::findOrFail($id);
        return view('Operator.entertaiment.edit', compact('entertaiments'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $entertaiments = Entertaiment::findOrFail($id);

            $data = $request->validate([
                'foto_entertaiment' => 'nullable|image|max:2048',
                'nama_entertaiment' => 'nullable|string',
                'deskripsi' => 'nullable|string',
            ]);

            if ($request->hasFile('foto_entertaiment')) {
                $data['foto_entertaiment'] = $request->file('foto_entertaiment')->store('entertaiments', 'public');
            }

            $data['updated_by'] = Auth::user()->name ?? 'admin';

            $entertaiments->update($data);
            DB::commit();

            return redirect()->route('entertaiment.index')
                             ->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function destroy( $id)
    {
        $entertaiments = Entertaiment::findOrFail($id);
        $entertaiments->delete();

        return redirect()->route('entertaiment.index')
                         ->with('success', 'Data berhasil dihapus.');
    }
}
