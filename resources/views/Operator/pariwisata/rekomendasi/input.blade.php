@extends('layouts.app2')

@section('title', 'Input Preferensi Rekomendasi')

@section('content')
<div class="px-6 py-10">
    <h1 class="text-xl font-bold mb-6">Input Preferensi Wisata</h1>

    <form action="{{ route('operator.pariwisata.rekomendasi.result') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label class="block font-semibold">Jarak Maksimal (km)</label>
            <input type="number" step="0.1" name="max_jarak" class="form-input w-full">
        </div>
        <div>
            <label class="block font-semibold">Harga Tiket Maksimal (Rp)</label>
            <input type="number" name="max_tiket" class="form-input w-full">
        </div>
        <div>
            <label class="block font-semibold">Minimal Rating</label>
            <input type="number" step="0.1" max="5" name="min_rating" class="form-input w-full">
        </div>
        <div>
            <label class="block font-semibold">Minimal Jumlah Fasilitas</label>
            <input type="number" name="min_fasilitas" class="form-input w-full">
        </div>
        <div>
            <label class="block font-semibold">Kategori</label>
            <select name="kategori" class="form-select w-full">
                <option value="">-- Semua Kategori --</option>
                <option value="pantai">Pantai</option>
                <option value="religi">Religi</option>
                <option value="edukasi">Edukasi</option>
                <option value="budaya">Budaya</option>
                <option value="kuliner">Kuliner</option>
            </select>
        </div>

        <button type="submit" class="btn bg-indigo-600 text-white">Lihat Rekomendasi</button>
    </form>
</div>
@endsection
