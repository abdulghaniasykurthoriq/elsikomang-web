@extends('layouts.app2')

@section('title', 'Step 0: Input Preferensi Wisata')

@section('content')

    <!-- Header Section -->
    <div class="bg-indigo-600 px-8 pt-10 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Step 0: Input Preferensi Wisata</h1>
        <a href="{{ route('operator.pariwisata.rekomendasi.step1') }}"
            class="btn bg-white text-indigo-700 hover:bg-indigo-50 shadow font-semibold">
            Lewati &rarr;
        </a>
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

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Harga Tiket Maksimal (Rp)</label>
                    <input type="number" name="max_tiket" class="form-input block w-full rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Minimal Rating</label>
                    <input type="number" step="0.1" max="5" name="min_rating" class="form-input block w-full rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Minimal Jumlah Fasilitas</label>
                    <input type="number" name="min_fasilitas" class="form-input block w-full rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori / Minat Wisata</label>
                    <select name="kategori" class="form-select block w-full rounded-md">
                        <option value="">-- Semua Kategori --</option>
                        @foreach (['pantai', 'religi', 'edukasi', 'budaya', 'kuliner'] as $kategori)
                            <option value="{{ $kategori }}">{{ ucfirst($kategori) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-6 flex justify-end">
                    <button type="submit" class="btn bg-indigo-600 text-white hover:bg-indigo-700">
                        Lihat Rekomendasi &rarr;
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection
