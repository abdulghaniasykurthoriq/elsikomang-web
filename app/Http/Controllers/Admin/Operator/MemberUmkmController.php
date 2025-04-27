<?php

namespace App\Http\Controllers\Admin\Operator;

use App\Http\Controllers\Controller;
use App\Models\JenisOperator;
use Illuminate\Http\Request;
use App\Models\MemberUmkm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use League\Uri\UriTemplate\Operator;

class MemberUmkmController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role'); 
        if ($role) {
            $member_umkm = User::where('role', 'umkm ' . ucfirst($role))->get();
        } else {
            $member_umkm = MemberUmkm::all();
        }
        return view('Operator.MemberUmkm.index', compact('member_umkm', 'role'));
    }

        public function create()
        {
            return view('Operator.MemberUmkm.create');
        }
    
        public function store(Request $request)
        {
        // dd($request->all());
            $request->validate([
                'nama_toko' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
                'foto_toko' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            ]);
            $data = $request->all();
            $data['created_by'] = Auth::user()->id ?? 'System'; 
            if ($request->hasFile('foto_toko')) {
            $data['foto_toko'] = $request->file('foto_toko')->store('foto_toko', 'public');
            }
            MemberUmkm::create($data);
                    // dd('jjj');
            return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil ditambahkan.');
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
            'nama_toko' => 'nullable',
            'alamat' => 'nullable',
            'no_hp' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->all();
        $data['updated_by'] = Auth::user()->name ?? 'System';

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_umkm', 'public');
        }

        $memberUmkm->update($data);

        return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $memberUmkm = MemberUmkm::findOrFail($id);
        $memberUmkm->delete();

        return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil dihapus.');
    }
}

