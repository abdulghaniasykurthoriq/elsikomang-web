@extends('layouts.app2')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Laporan Parawisata</h2>

    <form action="{{ route('operator.pariwisata.laporan.store', ['jenis' => 'pariwisata']) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="tanggal" class="block text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" class="w-full p-2 border rounded">
            @error('tanggal') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="periode" class="block text-gray-700">Periode</label>
            <select name="periode" id="periode" class="w-full p-2 border rounded">
                <option value="">Pilih Periode</option>
                <option value="harian" {{ old('periode') == 'harian' ? 'selected' : '' }}>Harian</option>
                <option value="bulanan" {{ old('periode') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                <option value="tahunan" {{ old('periode') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
            </select>
            @error('periode') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="nama_wisata" class="block text-gray-700">Nama Wisata</label>
            <input type="text" name="nama_wisata" id="nama_wisata" value="{{ old('nama_wisata') }}" class="w-full p-2 border rounded">
            @error('nama_wisata') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="jumlah_viewer" class="block text-gray-700">Jumlah Viewer</label>
            <input type="number" name="jumlah_viewer" id="jumlah_viewer" value="{{ old('jumlah_viewer') }}" class="w-full p-2 border rounded" min="0">
            @error('jumlah_viewer') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        <a href="{{ route('operator.pariwisata.laporan.index', ['jenis' => 'pariwisata']) }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
