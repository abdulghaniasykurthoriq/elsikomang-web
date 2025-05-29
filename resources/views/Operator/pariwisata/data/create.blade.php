@extends('layouts.app2')

@section('title', 'Tambah Data Pariwisata')

@section('content')

    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Tambah Data Pariwisata</h1>
        <a href="{{ route('operator.pariwisata.data.index', ['jenis' => request()->route('jenis')]) }}"
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

            <form action="{{ route('operator.pariwisata.data.store', ['jenis' => request()->route('jenis')]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Wisata</label>
                    <input type="text" id="nama" name="nama" class="form-input mt-1 block w-full"
                        value="{{ old('nama') }}" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-textarea mt-1 block w-full" rows="3" required>{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Upload Gambar</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*"
                        class="form-input mt-1 block w-full">
                </div>

                <div class="mb-4">
                    <label for="harga_tiket" class="block text-sm font-medium text-gray-700">Harga Tiket</label>
                    <input type="number" name="harga_tiket" id="harga_tiket" class="form-input mt-1 block w-full"
                        value="{{ old('harga_tiket') }}" required>
                </div>

                <div class="mb-4">
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori / Minat Wisata</label>
                    <select name="kategori" id="kategori" class="form-select mt-1 block w-full" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach (['pantai', 'hutan', 'religi', 'budaya', 'kuliner', 'edukasi'] as $kategori)
                            <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                                {{ ucfirst($kategori) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                        <input type="text" name="latitude" id="latitude" class="form-input mt-1 block w-full"
                            placeholder="-6.1234567" value="{{ old('latitude') }}">
                    </div>
                    <div>
                        <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                        <input type="text" name="longitude" id="longitude" class="form-input mt-1 block w-full"
                            placeholder="108.1234567" value="{{ old('longitude') }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fasilitas</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($fasilitas as $item)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="fasilitas[]" value="{{ $item->id }}"
                                    class="form-checkbox text-indigo-600">
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
