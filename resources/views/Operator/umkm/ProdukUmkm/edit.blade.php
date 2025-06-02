@extends('layouts.app2')
@section('title', 'Edit Produk UMKM')
@section('content')

<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Edit Produk UMKM</h1>
    <a href="{{ route('produk_umkm.index', ['jenis' => request()->route('jenis')]) }}"
        class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100">
        Kembali
    </a>
</div>

<div class="mx-2 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl p-6 shadow-xl w-full">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 rounded text-red-700">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produk_umkm.update', ['produk_umkm' => $produk_umkm->id]) }}" method="POST" enctype="multipart/form-data" id="produkForm">
            @csrf
            @method('PUT')

            {{-- Member UMKM --}}
            <div class="mb-4">
                <label for="member_id" class="block text-sm font-medium text-gray-700">Member UMKM</label>
                <select name="member_id" id="member_id" class="form-select mt-1 block w-full" >
                    @foreach($member_umkms as $member)
                        <option value="{{ $member->id }}" {{ old('member_id', $produk_umkm->member_id) == $member->id ? 'selected' : '' }}>
                            {{ $member->nama_toko }}
                        </option>
                    @endforeach
                </select>
                @error('member_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Produk --}}
            <div class="mb-4">
                <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" class="form-input mt-1 block w-full"
                    value="{{ old('nama_produk', $produk_umkm->nama_produk) }}" >
                @error('nama_produk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori --}}
            <div class="mb-4">
                <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-select mt-1 block w-full" >
                    @foreach($kategori_produk as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $produk_umkm->kategori_id) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->name }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-textarea mt-1 block w-full" rows="3" >{{ old('deskripsi', $produk_umkm->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Galeri --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
                @foreach ($produk_umkm->images as $image)
                    <div class="border rounded p-2 relative">
                        @if ($image->type === 'image')
                            <img src="{{ asset('storage/' . $image->file_path) }}" class="w-full h-32 object-cover rounded">
                        @elseif ($image->type === 'video')
                            <video src="{{ asset('storage/' . $image->file_path) }}" controls class="w-full h-32 object-cover rounded"></video>
                        @endif
                        <div class="mt-2 flex items-center gap-1">
                            <input type="checkbox" name="hapus_galeri[]" value="{{ $image->id }}" id="hapus_{{ $image->id }}" class="form-checkbox text-red-600">
                            <label for="hapus_{{ $image->id }}" class="text-sm text-red-600">Hapus</label>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Upload Baru --}}
            <div class="mb-4">
                <label for="files" class="block text-sm font-medium text-gray-700">Upload Galeri Baru</label>
                <input type="file" name="files[]" id="files" multiple accept="image/*,video/*" class="form-input mt-1 block w-full">
                @error('files.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Varian Produk --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Varian Produk</label>
                <div id="produk_variant" class="space-y-2">
                    @php $variants = old('produk_variant') ?: $produk_umkm->produk_variant; @endphp
                    @foreach($variants as $index => $varian)
                        <div class="flex gap-2 items-center">
                            <input type="text" name="produk_variant[{{ $index }}][varian]" class="form-input w-1/3" placeholder="Varian" value="{{ is_array($varian) ? $varian['varian'] : $varian->varian }}" >
                            <input type="number" name="produk_variant[{{ $index }}][harga]" class="form-input w-1/3" placeholder="Harga" value="{{ is_array($varian) ? $varian['harga'] : $varian->harga }}" >
                            <input type="number" name="produk_variant[{{ $index }}][stok]" class="form-input w-1/4" placeholder="Stok" value="{{ is_array($varian) ? $varian['stok'] : $varian->stok }}" >
                            <button type="button" class="btn bg-red-500 text-white hover:bg-red-600 remove-varian">X</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-varian" class="mt-2 bg-green-600 text-white px-4 py-2 rounded">+ Tambah Varian</button>
            </div>

            <div class="pt-4 flex justify-end gap-2">
                <button type="submit" id="submitBtn"
                    class="btn bg-indigo-600 text-white hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 flex items-center justify-center">
                    <span id="btnText">Perbarui</span>
                    <svg id="btnSpinner" class="hidden animate-spin ml-2 h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('produk_variant');
    const addBtn = document.getElementById('add-varian');

    function reindexVarian() {
        const items = wrapper.querySelectorAll('.flex');
        items.forEach((item, index) => {
            const inputs = item.querySelectorAll('input');
            inputs[0].setAttribute('name', `produk_variant[${index}][varian]`);
            inputs[1].setAttribute('name', `produk_variant[${index}][harga]`);
            inputs[2].setAttribute('name', `produk_variant[${index}][stok]`);
        });
    }

    addBtn.addEventListener('click', function() {
        const div = document.createElement('div');
        div.classList.add('flex', 'gap-2', 'items-center');
        div.innerHTML = `
            <input type="text" class="form-input w-1/3" placeholder="Varian" >
            <input type="number" class="form-input w-1/3" placeholder="Harga" >
            <input type="number" class="form-input w-1/4" placeholder="Stok" >
            <button type="button" class="btn bg-red-500 text-white hover:bg-red-600 remove-varian">X</button>
        `;
        wrapper.appendChild(div);
        reindexVarian();
    });

    wrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-varian')) {
            e.target.parentElement.remove();
            reindexVarian();
        }
    });
});
</script>
<script>
    document.getElementById('produkForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        // Disable tombol dan tampilkan spinner
        btn.disabled = true;
        btnText.textContent = 'Menyimpan...';
        btnSpinner.classList.remove('hidden');
    });
</script>


@endsection
