<?php

namespace App\Http\Controllers\Admin\Operator;

use App\Http\Controllers\Controller;
use App\Models\MemberUmkm;
use Illuminate\Http\Request;

class ProdukUmkmController extends Controller
{
    public function index()
    {
        $members = MemberUmkm::all();
        return view('member_umkm.index', compact('members'));
    }

    public function create()
    {
        return view('member_umkm.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_toko' => 'required|string',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('member_umkm');
        }

        MemberUmkm::create($data);

        return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil dibuat.');
    }

    public function edit(MemberUmkm $memberUmkm)
    {
        return view('member_umkm.edit', compact('memberUmkm'));
    }

    public function update(Request $request, MemberUmkm $memberUmkm)
    {
        $data = $request->validate([
            'nama_toko' => 'required|string',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('member_umkm');
        }

        $memberUmkm->update($data);

        return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil diupdate.');
    }

    public function destroy(MemberUmkm $memberUmkm)
    {
        $memberUmkm->delete();
        return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil dihapus.');
    }
}