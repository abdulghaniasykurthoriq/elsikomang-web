@extends('layouts.app2')

@section('title', 'Edit Data Pariwisata')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-lg mt-10">
    <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Edit Data Pariwisata</h2>

    <form action="{{ route('operator.pariwisata.data.update', ['jenis' => request()->route('jenis'), 'data' => $item->id]) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">Nama</label>
            <input
                type="text" id="nama" name="nama" required
                value="{{ old('nama', $item->nama) }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition"
                placeholder="Masukkan nama tempat wisata" />
        </div>

        <div>
            <label for="lokasi" class="block mb-2 text-sm font-medium text-gray-700">Lokasi</label>
            <input
                type="text" id="lokasi" name="lokasi" required
                value="{{ old('lokasi', $item->lokasi) }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition"
                placeholder="Masukkan lokasi" />
        </div>

        <div>
            <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea
                id="deskripsi" name="deskripsi" rows="5" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition"
                placeholder="Tuliskan deskripsi singkat">{{ old('deskripsi', $item->deskripsi) }}</textarea>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('operator.pariwisata.data.index', ['jenis' => request()->route('jenis')]) }}"
                class="px-6 py-3 rounded-lg bg-gray-300 text-gray-800 hover:bg-gray-400 transition font-semibold">
                Batal
            </a>

            <button type="submit"
                class="px-6 py-3 rounded-lg bg-yellow-600 text-white hover:bg-yellow-700 transition font-semibold shadow-lg">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
