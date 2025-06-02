@extends('layouts.app2')
@section('title', 'Tambah Produk UMKM')
@section('content')

@php
    $jenis = request()->route('jenis');
@endphp

<div class=" bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">+ Tambah Produk UMKM</h1>

    <a href="{{ route('produk_umkm.index', ['jenis' => $jenis]) }}"
        class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100 hover:text-gray-800 hover:border-gray-200 active:bg-gray-100 active:text-gray-800 active:border-gray-200 focus:outline-none focus:ring-4 focus:ring-indigo-300">
        Kembali
    </a>
</div>

<div class="mx-2 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl p-6 shadow-xl overflow-hidden w-full">

        {{-- Tampilkan error validasi --}}
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

        <form action="{{ route('produk_umkm.store', ['jenis' => $jenis]) }}" method="POST" enctype="multipart/form-data" id="produkForm">
            @csrf

            {{-- Member UMKM --}}
            <div class="mb-4">
                <label for="member_id" class="block text-sm font-medium text-gray-700">Member UMKM</label>
                <select name="member_id" id="member_id" class="form-select mt-1 block w-full" required>
                    <option value="">Pilih Member UMKM</option>
                    @foreach($member_umkms as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
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
                       value="{{ old('nama_produk') }}" required>
                @error('nama_produk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori --}}
            <div class="mb-4">
                <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-select mt-1 block w-full" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori_produk as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
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
                <textarea id="deskripsi" name="deskripsi" class="form-textarea mt-1 block w-full" rows="3" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Galeri --}}
            <div class="mb-4">
                <label for="files" class="block text-sm font-medium text-gray-700">Upload Galeri (Gambar/Video)</label>
                <input type="file" name="files[]" id="files" multiple accept="image/*,video/*" class="form-input mt-1 block w-full"required>
                @error('files.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Varian Produk --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Varian Produk</label>

                <div id="produk_variant">
                    <div class="produk_variant flex gap-2 mb-2">
                        <input type="text" name="produk_variant[0][varian]" placeholder="Varian" class="form-input w-1/3" required>
                        <input type="number" name="produk_variant[0][harga]" placeholder="Harga" class="form-input w-1/3" required>
                        <input type="number" name="produk_variant[0][stok]" placeholder="Stok" class="form-input w-1/3" required>
                        <button type="button" onclick="removeVariant(this)" class="bg-red-500 text-white px-2 rounded">X</button>
                    </div>
                </div>

                <button type="button" onclick="addVariant()" class="mt-2 bg-green-600 text-white px-4 py-2 rounded">+ Tambah Varian</button>
            </div>

            {{-- Submit --}}
            <div class="pt-4 flex justify-end gap-2">
                <button type="submit" id="submitBtn"
                    class="btn bg-indigo-600 text-white hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 flex items-center justify-center">
                    <span id="btnText">Simpan</span>
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

        </form>
    </div>
</div>
<script>
    let variantIndex = 1;

    function addVariant() {
        const wrapper = document.getElementById('produk_variant');
        const div = document.createElement('div');
        div.className = 'variant-item flex gap-2 mb-2';
        div.innerHTML = `
            <input type="text" name="produk_variant[${variantIndex}][varian]" placeholder="Varian" class="form-input w-1/3" required>
            <input type="number" name="produk_variant[${variantIndex}][harga]" placeholder="Harga" class="form-input w-1/3" required>
            <input type="number" name="produk_variant[${variantIndex}][stok]" placeholder="Stok" class="form-input w-1/3" required>
            <button type="button" onclick="removeVariant(this)" class="bg-red-500 text-white px-2 rounded">X</button>
        `;
        wrapper.appendChild(div);
        variantIndex++;
    }

    function removeVariant(button) {
        button.parentElement.remove();
    }
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


