<?php

namespace App\Http\Controllers\Operator\Umkm;

use App\Http\Controllers\Controller;
use App\Models\JenisOperator;
use Illuminate\Http\Request;
use App\Models\MemberUmkm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberUmkmController extends Controller
{
    public function index(Request $request, $jenis)
    {
        $member_umkm = MemberUmkm::all();
        return view('Operator.umkm.MemberUmkm.index', compact('member_umkm', 'jenis'));
    }

    public function create(Request $request, $jenis)
    {
        return view('Operator.umkm.MemberUmkm.create', compact('jenis'));
    }

    public function store(Request $request, $jenis)
    {
        $request->validate([
            'nama_toko' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'foto_toko' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only('nama_toko', 'alamat', 'no_hp');
            $data['created_by'] = Auth::id() ?? 'System';

            if ($request->hasFile('foto_toko')) {
                $data['foto_toko'] = $request->file('foto_toko')->store('foto_toko', 'public');
            }

            MemberUmkm::create($data);

            DB::commit();
            return redirect()->route('member_umkm.index', ['jenis' => $jenis])
                ->with('success', 'Member UMKM berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menambahkan member: ' . $th->getMessage());
        }
    }

    public function edit(Request $request, $jenis, $id)
    {
        $memberUmkm = MemberUmkm::findOrFail($id);
        return view('Operator.umkm.MemberUmkm.edit', compact('memberUmkm', 'jenis'));
    }

    public function update(Request $request, $jenis, $id)
    {
        $memberUmkm = MemberUmkm::findOrFail($id);

        $request->validate([
            'nama_toko' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'foto_toko' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only('nama_toko', 'alamat', 'no_hp');
            $data['updated_by'] = Auth::id() ?? 'System';

            if ($request->hasFile('foto_toko')) {
                $data['foto_toko'] = $request->file('foto_toko')->store('foto_toko', 'public');
            }

            $memberUmkm->update($data);

            DB::commit();
            return redirect()->route('member_umkm.index', ['jenis' => $jenis])
                ->with('success', 'Member UMKM berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal memperbarui member: ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, $jenis, $id)
    {
        DB::beginTransaction();
        try {
            $memberUmkm = MemberUmkm::findOrFail($id);
            $memberUmkm->delete();

            DB::commit();
            return redirect()->route('member_umkm.index', ['jenis' => $jenis])
                ->with('success', 'Member UMKM berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menghapus member: ' . $th->getMessage());
        }
    }
}
