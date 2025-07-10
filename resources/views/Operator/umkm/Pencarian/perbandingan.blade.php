@extends('layouts.app2')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">🔍 Perbandingan Pencarian LIKE SQL vs TF-IDF</h1>

    {{-- Form pencarian --}}
    <form method="GET" action="{{ route('pencarian.perbandingan') }}" class="mb-6">
        <div class="flex gap-4">
            <input type="text" name="q" placeholder="Masukkan kata kunci..." value="{{ $query }}"
                class="w-full p-3 rounded border border-gray-300 focus:ring focus:outline-none" />
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                Bandingkan
            </button>
        </div>
    </form>

    {{-- Hasil pencarian --}}
    @if($query)
        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500 mb-4">Hasil untuk kata kunci: <span class="font-semibold text-gray-800">{{ $query }}</span></p>

            <div class="grid md:grid-cols-2 gap-6">
                {{-- LIKE SQL --}}
                <div>
                    <h2 class="text-lg font-semibold text-blue-700 mb-2">LIKE SQL</h2>
                    @forelse ($likeResults as $item)
                        <div class="border p-3 rounded mb-3">
                            <p class="font-bold">{{ $item->nama_produk }}</p>
                            <p class="text-sm text-gray-600">{{ $item->deskripsi }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada hasil.</p>
                    @endforelse
                </div>

                {{-- TF-IDF --}}
                <div>
                    <h2 class="text-lg font-semibold text-green-700 mb-2">TF-IDF</h2>
                    @forelse ($tfidfResults as $result)
                        <div class="border p-3 rounded mb-3">
                            <p class="font-bold">{{ $result['produk']->nama_produk }}</p>
                            <p class="text-sm text-gray-600">{{ $result['produk']->deskripsi }}</p>
                            <p class="text-sm mt-1 text-green-600">Skor: {{ $result['score'] }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada hasil.</p>
                    @endforelse
                </div>
            </div>

            {{-- Evaluasi --}}
            <div class="mt-6">
                <h3 class="text-md font-semibold text-gray-700 mb-2">Evaluasi:</h3>
                <ul class="text-sm text-gray-800">
                    <li><strong>Precision:</strong> {{ number_format($precision, 2) }}</li>
                    <li><strong>Recall:</strong> {{ number_format($recall, 2) }}</li>
                    <li><strong>F1-Score:</strong> {{ number_format($f1, 2) }}</li>
                </ul>
            </div>
        </div>
    @endif
</div>
@endsection
