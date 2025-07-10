@extends('layouts.app2')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
            🔎 Pencarian Produk UMKM <span class="text-blue-600">(LIKE SQL)</span>
        </h1>

        <form action="{{ route('pencarian.index') }}" method="GET" class="flex items-center space-x-4 mb-6">
            <input type="text" name="q" class="form-input w-full border border-gray-300 rounded px-3 py-2" placeholder="Cari produk..." value="{{ request('q') }}">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>
        </form>

        @if ($query)
            <p class="mb-4 text-sm text-gray-600">Hasil pencarian untuk: <strong>{{ $query }}</strong></p>

            @forelse ($produk as $item)
                <div class="bg-blue-50 p-4 mb-3 rounded shadow-sm">
                    <p class="font-semibold">{{ $item->nama_produk }}</p>
                    <p class="text-sm text-gray-700">{{ $item->deskripsi }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Tidak ada hasil ditemukan.</p>
            @endforelse
        @else
            <p class="text-sm text-gray-500">Silakan ketik kata kunci untuk mencari produk.</p>
        @endif
    </div>
</div>
@endsection
