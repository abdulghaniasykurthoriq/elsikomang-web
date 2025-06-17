<?php

namespace App\Http\Controllers\Operator\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\MemberUmkm;

class MemberUmkmController extends Controller
{
    public function index(Request $request)
    {
        $member_umkm = MemberUmkm::with('desa.kecamatan.kota.provinsi')->latest()->paginate(10);
        return view('Operator.umkm.MemberUmkm.index', compact('member_umkm'));
    }

    public function create(Request $request)
    {
        return view('Operator.umkm.MemberUmkm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'desa_id' => 'required|integer',
            'foto_toko' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['nama_toko', 'alamat', 'no_hp', 'desa_id']);
            $data['created_by'] = Auth::id() ?? 'System';

            if ($request->hasFile('foto_toko')) {
                $data['foto_toko'] = $request->file('foto_toko')->store('foto_toko', 'public');
            }

            MemberUmkm::create($data);

            DB::commit();
            return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menambahkan member: ' . $th->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $memberUmkm = MemberUmkm::find($id);

        if (!$memberUmkm) {
            return redirect()->route('member_umkm.index')->with('error', 'Data member tidak ditemukan.');
        }

        return view('Operator.umkm.MemberUmkm.edit', compact('memberUmkm'));
    }

    public function update(Request $request, $id)
    {
        $memberUmkm = MemberUmkm::find($id);

        if (!$memberUmkm) {
            return redirect()->route('member_umkm.index')->with('error', 'Data member tidak ditemukan.');
        }

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'desa_id' => 'required|integer',
            'foto_toko' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['nama_toko', 'alamat', 'no_hp', 'desa_id']);
            $data['updated_by'] = Auth::id() ?? 'System';

            if ($request->hasFile('foto_toko')) {
                if ($memberUmkm->foto_toko && Storage::disk('public')->exists($memberUmkm->foto_toko)) {
                    Storage::disk('public')->delete($memberUmkm->foto_toko);
                }
                $data['foto_toko'] = $request->file('foto_toko')->store('foto_toko', 'public');
            }

            $memberUmkm->update($data);

            DB::commit();
            return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal memperbarui member: ' . $th->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $memberUmkm = MemberUmkm::find($id);

            if (!$memberUmkm) {
                return redirect()->route('member_umkm.index')->with('error', 'Data member tidak ditemukan.');
            }

            if ($memberUmkm->foto_toko && Storage::disk('public')->exists($memberUmkm->foto_toko)) {
                Storage::disk('public')->delete($memberUmkm->foto_toko);
            }

            $memberUmkm->delete();

            DB::commit();
            return redirect()->route('member_umkm.index')->with('success', 'Member UMKM berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menghapus member: ' . $th->getMessage());
        }
    }
}
