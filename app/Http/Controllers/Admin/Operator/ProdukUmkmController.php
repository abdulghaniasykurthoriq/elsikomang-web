<?php

namespace App\Http\Controllers\Admin\Operator;

use App\Http\Controllers\Controller;
use App\Models\MemberUmkm;
use App\Models\ProdukUmkm;
use App\Models\KategoriProduk;
use App\Models\ProdukImage;
use App\Models\ProdukVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukUmkmController extends Controller
{
    public function index()
    {
        $produk_umkm = ProdukUmkm::with('member', 'images')->get();
        return view('Operator.ProdukUmkm.index', compact('produk_umkm'));
    }

    public function create()
    {
        $member_umkms = MemberUmkm::all();
        $kategori_produk = KategoriProduk::all();
        return view('Operator.ProdukUmkm.create', compact('member_umkms', 'kategori_produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:member_umkm,id',
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_produk,id',
            'deskripsi' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:51200',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->only(['member_id', 'nama_produk', 'kategori_id', 'deskripsi']);
            $data['created_by'] = Auth::id() ?? 'System';

            $produk_umkm = ProdukUmkm::create($data);

            // Upload galeri
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('produk_image', 'public');
                    $type = in_array($file->extension(), ['mp4', 'mov']) ? 'video' : 'image';

                    ProdukImage::create([
                        'produk_umkm_id' => $produk_umkm->id,
                        'file_path' => $path,
                        'type' => $type,
                    ]);
                }
            }

            // Simpan varian
            if ($request->has('produk_variant')) {
                foreach ($request->produk_variant as $dataVarian) {
                    $produk_umkm->produk_variant()->create([
                        'varian' => $dataVarian['varian'],
                        'harga' => $dataVarian['harga'],
                        'stok' => $dataVarian['stok'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('produk_umkm.index')->with('success', 'Produk UMKM berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menambahkan produk: ' . $th->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $produk_umkm = ProdukUmkm::with('images', 'produk_variant')->findOrFail($id);
        $member_umkms = MemberUmkm::all();
        $kategori_produk = KategoriProduk::all();
        return view('Operator.ProdukUmkm.edit', compact('produk_umkm', 'member_umkms', 'kategori_produk'));
    }

    public function update(Request $request, $id)
    {
        $produk_umkm = ProdukUmkm::findOrFail($id);

        $request->validate([
            'member_id' => 'required|exists:member_umkm,id',
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_produk,id',
            'deskripsi' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:51200',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->only(['member_id', 'nama_produk', 'kategori_id', 'deskripsi']);
            $data['updated_by'] = Auth::id() ?? 'System';

            $produk_umkm->update($data);
            if ($request->filled('hapus_galeri')) {
                $galeriIds = $request->input('hapus_galeri');
                
                // Ambil data galeri yang dipilih hapus
                $galeriUntukHapus = $produk_umkm->images()->whereIn('id', $galeriIds)->get();
            
                foreach ($galeriUntukHapus as $item) {
                    // Hapus file dari storage
                    Storage::disk('public')->delete($item->file_path);
            
                    // Hapus data dari database
                    $item->delete();
                }
            }
            

            // Upload file galeri baru
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('produk_image', 'public');
                    $type = in_array($file->extension(), ['mp4', 'mov']) ? 'video' : 'image';

                    ProdukImage::create([
                        'produk_umkm_id' => $produk_umkm->id,
                        'file_path' => $path,
                        'type' => $type,
                    ]);
                }
            }

            // Update varian
            if ($request->has('produk_variant')) {
                $produk_umkm->produk_variant()->delete();
                foreach ($request->produk_variant as $dataVarian) {
                    $produk_umkm->produk_variant()->create([
                        'varian' => $dataVarian['varian'],
                        'harga' => $dataVarian['harga'],
                        'stok' => $dataVarian['stok'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('produk_umkm.index')->with('success', 'Produk UMKM berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal memperbarui produk: ' . $th->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $produk_umkm = ProdukUmkm::findOrFail($id);


            // Hapus galeri
            foreach ($produk_umkm->images as $image) {
                if (Storage::disk('public')->exists($image->file_path)) {
                    Storage::disk('public')->delete($image->file_path);
                }
                $image->delete();
            }

            // Hapus varian
            $produk_umkm->produk_variant()->delete();

            $produk_umkm->delete();

            DB::commit();
            return redirect()->route('produk_umkm.index')->with('success', 'Produk UMKM berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors('Gagal menghapus produk: ' . $th->getMessage());
        }
    }
}
