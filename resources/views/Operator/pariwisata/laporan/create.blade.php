@extends('layouts.app2')

@section('title', 'Tambah Laporan Pariwisata')

@section('content')

<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Tambah Laporan Pariwisata</h1>
    <a href="{{ route('operator.pariwisata.laporan.index', ['jenis' => request()->route('jenis')]) }}"
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

        <form action="{{ route('operator.pariwisata.laporan.store', ['jenis' => request()->route('jenis')]) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" class="form-input mt-1 block w-full">
                @error('tanggal') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="periode" class="block text-sm font-medium text-gray-700">Periode</label>
                <select name="periode" id="periode" class="form-select mt-1 block w-full">
                    <option value="">Pilih Periode</option>
                    <option value="harian" {{ old('periode') == 'harian' ? 'selected' : '' }}>Harian</option>
                    <option value="bulanan" {{ old('periode') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="tahunan" {{ old('periode') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                </select>
                @error('periode') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="nama_wisata" class="block text-sm font-medium text-gray-700">Nama Wisata</label>
                <input type="text" name="nama_wisata" id="nama_wisata" value="{{ old('nama_wisata') }}" class="form-input mt-1 block w-full">
                @error('nama_wisata') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="jumlah_viewer" class="block text-sm font-medium text-gray-700">Jumlah Viewer</label>
                <input type="number" name="jumlah_viewer" id="jumlah_viewer" value="{{ old('jumlah_viewer') }}" class="form-input mt-1 block w-full" min="0">
                @error('jumlah_viewer') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 flex justify-end gap-2">
                <button type="submit" class="btn bg-indigo-600 text-white hover:bg-indigo-700">Simpan</button>
                <a href="{{ route('operator.pariwisata.laporan.index', ['jenis' => request()->route('jenis')]) }}"
                    class="btn bg-gray-100 text-gray-700 hover:bg-gray-200">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
