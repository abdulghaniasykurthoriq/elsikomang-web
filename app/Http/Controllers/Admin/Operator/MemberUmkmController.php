<?php

namespace App\Http\Controllers\Admin\Operator;

use App\Http\Controllers\Controller;
use App\Models\JenisOperator;
use Illuminate\Http\Request;
use App\Models\MemberUmkm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberUmkmController extends Controller
{
    public function index(Request $request)
    {
            $member_umkm = MemberUmkm::all();
        return view('Operator.MemberUmkm.index', compact('member_umkm'));
    }

    public function create()
    {
        return view('Operator.MemberUmkm.create');
    }
    
    public function store(Request $request)
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
            return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menambahkan member: ' . $th->getMessage());
        }
    }    

    public function edit($id)
    {
        $memberUmkm = MemberUmkm::findOrFail($id);
        return view('Operator.MemberUmkm.edit', compact('memberUmkm'));
    }

    public function update(Request $request, $id)
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
            return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal memperbarui member: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $memberUmkm = MemberUmkm::findOrFail($id);
            $memberUmkm->delete();

            DB::commit();
            return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menghapus member: ' . $th->getMessage());
        }
    }
}
