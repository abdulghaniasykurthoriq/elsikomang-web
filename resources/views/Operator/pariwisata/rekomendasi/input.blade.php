@extends('layouts.app2')

@section('title', 'Input Preferensi Wisata')

@section('content')

<!-- Header Section -->
<div class="bg-indigo-600 px-8 pt-10 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Input Preferensi Wisata</h1>
</div>

<!-- Form Section -->
<div class="px-6 -mt-24 relative z-10 mx-2">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full p-6">

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

        <form action="{{ route('operator.pariwisata.rekomendasi.result') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Harga Tiket -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Harga Tiket</label>
                <select name="max_tiket" class="form-select block w-full rounded-md">
                    <option value="">-- Pilih Batas Harga --</option>
                    <option value="10000" {{ old('max_tiket') == '10000' ? 'selected' : '' }}>Murah (≤ Rp 10.000)</option>
                    <option value="20000" {{ old('max_tiket') == '20000' ? 'selected' : '' }}>Sedang (≤ Rp 20.000)</option>
                    <option value="50000" {{ old('max_tiket') == '50000' ? 'selected' : '' }}>Mahal (≤ Rp 50.000)</option>
                </select>
            </div>

            <!-- Rating -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Minimal Rating</label>
                <select name="min_rating" class="form-select block w-full rounded-md">
                    <option value="">-- Pilih Minimal Rating --</option>
                    @for ($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ old('min_rating') == $i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                    @endfor
                </select>
            </div>

            <!-- Fasilitas -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Minimal Jumlah Fasilitas</label>
                <input type="range" name="min_fasilitas" min="1" max="5" value="{{ old('min_fasilitas', 3) }}"
                    class="w-full" oninput="document.getElementById('fasilitas_val').innerText = this.value">
                <div class="text-right text-sm text-gray-600">
                    Jumlah: <span id="fasilitas_val">{{ old('min_fasilitas', 3) }}</span>
                </div>
            </div>

            <!-- Waktu Operasional -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Buka</label>
                    <input type="time" name="jam_buka" class="form-input block w-full rounded-md"
                        value="{{ old('jam_buka') }}">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Tutup</label>
                    <input type="time" name="jam_tutup" class="form-input block w-full rounded-md"
                        value="{{ old('jam_tutup') }}">
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-1">*Durasi akan dihitung otomatis sebagai preferensi waktu operasional.</p>

            <!-- Kategori -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori / Minat Wisata</label>
                <select name="kategori" class="form-select block w-full rounded-md">
                    <option value="">-- Semua Kategori --</option>
                    @foreach (['pantai', 'religi', 'edukasi', 'budaya', 'kuliner','buatan'] as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                            {{ ucfirst($kategori) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit -->
            <div class="pt-6 flex justify-end">
                <button type="submit" class="btn bg-indigo-600 text-white hover:bg-indigo-700">
                    Lihat Rekomendasi &rarr;
                </button>
            </div>
        </form>

    </div>
</div>

@endsection
