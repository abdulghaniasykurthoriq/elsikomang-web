<?php

namespace App\Http\Controllers\Operator\Investasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Investasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvestasiController extends Controller
{
    public function index($jenis)
    {
        $investasis = Investasi::latest()->get();
        return view('Operator.Investasi.index', compact('investasis', 'jenis'));
    }

    public function create($jenis)
    {
        return view('Operator.Investasi.create', compact('jenis'));
    }

    public function store(Request $request, $jenis)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'foto_investasi' => 'required|image|max:2048',
                'nama_investasi' => 'required|string',
                'deskripsi' => 'required|string',
            ]);

            if ($request->hasFile('foto_investasi')) {
                $data['foto_investasi'] = $request->file('foto_investasi')->store('investasis', 'public');
            }

            $data['created_by'] = Auth::user()->name ?? 'admin';

            Investasi::create($data);
            DB::commit();

            return redirect()->route('investasi.index', ['jenis' => $jenis])->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit($jenis, $id)
    {
        $investasi = Investasi::findOrFail($id);
        return view('Operator.Investasi.edit', compact('investasi', 'jenis'));
    }

    public function update(Request $request, $jenis, $id)
    {
        DB::beginTransaction();
        try {
            $investasi = Investasi::findOrFail($id);

            $data = $request->validate([
                'foto_investasi' => 'nullable|image|max:2048',
                'nama_investasi' => 'nullable|string',
                'deskripsi' => 'nullable|string',
            ]);

            if ($request->hasFile('foto_investasi')) {
                $data['foto_investasi'] = $request->file('foto_investasi')->store('investasis', 'public');
            }

            $data['updated_by'] = Auth::user()->name ?? 'admin';

            $investasi->update($data);
            DB::commit();

            return redirect()->route('investasi.index', ['jenis' => $jenis])->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function destroy($jenis, $id)
    {
        $investasi = Investasi::findOrFail($id);
        $investasi->delete();

        return redirect()->route('investasi.index', ['jenis' => $jenis])->with('success', 'Data berhasil dihapus.');
    }
}
