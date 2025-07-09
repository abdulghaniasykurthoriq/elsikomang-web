@extends('layouts.app2')

@section('title', 'Hasil Rekomendasi Berdasarkan Preferensi')

@section('content')

    <!-- Header -->
    <div class="bg-indigo-600 px-8 pt-10 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Hasil Rekomendasi Awal</h1>
        <a href="{{ route('operator.pariwisata.rekomendasi.input') }}"
            class="btn bg-white text-indigo-700 hover:bg-indigo-50 shadow font-semibold">
            &larr; Ubah Preferensi
        </a>
    </div>

    <!-- Result Section -->
    <div class="px-6 -mt-24 relative z-10 mx-2">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full p-6">

            @if ($result->isEmpty())
                <div class="text-center py-10 text-gray-600 text-lg">
                    <p>Tidak ada wisata yang cocok dengan preferensi Anda.</p>
                </div>
            @else
                @foreach ($result as $index => $item)
                    <div class="border border-gray-200 rounded-lg p-4 mb-4 shadow-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-bold text-indigo-700">{{ $index + 1 }}.
                                    {{ $item['wisata']->nama }}</h2>
                                <p class="text-sm text-gray-600">
                                    Harga: Rp{{ number_format($item['wisata']->harga_tiket) }} |
                                    Rating: {{ $item['wisata']->rating }} |
                                    Fasilitas: {{ $item['wisata']->fasilitas->count() }} |
                                    Skor: <span class="font-semibold text-indigo-700">{{ $item['skor'] }}</span>
                                </p>
                            </div>
                            <button type="button"
                                onclick="document.getElementById('detail-{{ $index }}').classList.toggle('hidden')"
                                class="text-sm text-indigo-600 hover:underline focus:outline-none">
                                Lihat Detail
                            </button>
                        </div>

                        <div id="detail-{{ $index }}" class="mt-4 hidden">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full text-sm text-left text-gray-700 border mt-2">
                                    <thead class="bg-gray-100 border-b">
                                        <tr>
                                            <th class="px-4 py-2">Kriteria</th>
                                            <th class="px-4 py-2">Normalisasi</th>
                                            <th class="px-4 py-2">Bobot</th>
                                            <th class="px-4 py-2">Perkalian</th>
                                            <th class="px-4 py-2">Hasil</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($item['detail'] as $kriteria => $detail)
                                            <tr>
                                                <td class="px-4 py-2 capitalize">{{ str_replace('_', ' ', $kriteria) }}</td>
                                                <td class="px-4 py-2">{{ $detail['normalisasi'] }}</td>
                                                <td class="px-4 py-2">{{ $detail['bobot'] }}</td>
                                                <td class="px-4 py-2">{{ $detail['perkalian'] }}</td>
                                                <td class="px-4 py-2 font-semibold">{{ $detail['hasil'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-50 font-semibold text-indigo-700">
                                            <td colspan="4" class="px-4 py-2 text-right">Total Skor Akhir</td>
                                            <td class="px-4 py-2">{{ $item['skor'] }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach

            @endif

        </div>
    </div>

@endsection
