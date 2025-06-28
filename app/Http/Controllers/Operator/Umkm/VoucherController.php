<?php

namespace App\Http\Controllers\Operator\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->get();
        return view('Operator.umkm.Voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('Operator.umkm.Voucher.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required|string|max:100|unique:vouchers,kode_voucher',
            'nama_voucher' => 'required|string|max:255',
            'tipe_diskon' => 'required|in:persen,nominal',
            'nilai_diskon' => 'required|numeric|min:0',
            'minimum_transaksi' => 'required|numeric|min:0',
            'maks_diskon' => 'nullable|numeric|min:0',
            'kuota' => 'required|integer|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'is_aktif' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only([
                'kode_voucher',
                'nama_voucher',
                'tipe_diskon',
                'nilai_diskon',
                'minimum_transaksi',
                'maks_diskon',
                'kuota',
                'tanggal_mulai',
                'tanggal_berakhir',
                'is_aktif'
            ]);

            $data['created_by'] = Auth::id() ?? 'system';

            Voucher::create($data);

            DB::commit();
            return redirect()->route('voucher.index')->with('success', 'Voucher berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menambahkan voucher: ' . $th->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('Operator.umkm.Voucher.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'kode_voucher' => 'required|string|max:100|unique:vouchers,kode_voucher,' . $voucher->id,
            'nama_voucher' => 'required|string|max:255',
            'tipe_diskon' => 'required|in:persen,nominal',
            'nilai_diskon' => 'required|numeric|min:0',
            'minimum_transaksi' => 'required|numeric|min:0',
            'maks_diskon' => 'nullable|numeric|min:0',
            'kuota' => 'required|integer|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'is_aktif' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only([
                'kode_voucher',
                'nama_voucher',
                'tipe_diskon',
                'nilai_diskon',
                'minimum_transaksi',
                'maks_diskon',
                'kuota',
                'tanggal_mulai',
                'tanggal_berakhir',
                'is_aktif'
            ]);

            $data['updated_by'] = Auth::id() ?? 'system';

            $voucher->update($data);

            DB::commit();
            return redirect()->route('voucher.index')->with('success', 'Voucher berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal memperbarui voucher: ' . $th->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->delete();

            DB::commit();
            return redirect()->route('voucher.index')->with('success', 'Voucher berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menghapus voucher: ' . $th->getMessage());
        }
    }
}
