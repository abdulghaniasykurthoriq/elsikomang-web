@extends('layouts.app2')

@section('title', 'Tambah Data Pariwisata')

@section('content')

    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Tambah Data Pariwisata</h1>
        <a href="{{ route('operator.pariwisata.data.index') }}"
            class="btn bg-white text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-indigo-300">
            Kembali
        </a>
    </div>

    <div class="mx-2 px-6 -mt-24 relative z-10">
        <div class="bg-white rounded-xl p-6 shadow-xl overflow-hidden w-full">

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

            <form action="{{ route('operator.pariwisata.data.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Wisata</label>
                    <input type="text" id="nama" name="nama" class="form-input mt-1 block w-full"
                        value="{{ old('nama') }}" required>
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="form-input mt-1 block w-full"
                        value="{{ old('alamat') }}" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-textarea mt-1 block w-full" rows="3" required>{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Upload Gambar</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*"
                        class="form-input mt-1 block w-full" required>

                </div>

                <div class="mb-4">
                    <label for="harga_tiket" class="block text-sm font-medium text-gray-700">Harga Tiket</label>
                    <input type="number" name="harga_tiket" id="harga_tiket" class="form-input mt-1 block w-full"
                        value="{{ old('harga_tiket') }}" required>
                </div>

                <div class="mb-4">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                    <input type="number" step="0.01" name="rating" id="rating" class="form-input mt-1 block w-full"
                        min="0" max="5" value="{{ old('rating') }}">
                </div>

                <div class="mb-4">
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori / Minat Wisata</label>
                    <select name="kategori" id="kategori" class="form-select mt-1 block w-full" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach (['pantai','religi', 'budaya', 'kuliner', 'edukasi', 'buatan'] as $kategori)
                            <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                                {{ ucfirst($kategori) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="jam_buka" class="block text-sm font-medium text-gray-700">Jam Buka</label>
                        <input type="time" name="jam_buka" id="jam_buka" class="form-input mt-1 block w-full"
                            value="{{ old('jam_buka') }}">
                    </div>
                    <div>
                        <label for="jam_tutup" class="block text-sm font-medium text-gray-700">Jam Tutup</label>
                        <input type="time" name="jam_tutup" id="jam_tutup" class="form-input mt-1 block w-full"
                            value="{{ old('jam_tutup') }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fasilitas</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($fasilitas as $item)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="fasilitas[]" value="{{ $item->id }}"
                                    class="form-checkbox text-indigo-600"
                                    {{ is_array(old('fasilitas')) && in_array($item->id, old('fasilitas')) ? 'checked' : '' }}>
                                <span class="ml-2">{{ ucfirst($item->nama) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-2">
                    <button type="submit" class="btn bg-indigo-600 text-white hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection
