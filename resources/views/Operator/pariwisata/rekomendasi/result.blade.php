@extends('layouts.app2')

@section('title', 'Step 0: Hasil Filter Preferensi')

@section('content')

    <!-- Header -->
    <div class="bg-indigo-600 px-8 pt-10 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Step 0: Hasil Filter Awal Rekomendasi</h1>
        <a href="{{ route('operator.pariwisata.rekomendasi.input') }}"
            class="btn bg-white text-indigo-700 hover:bg-indigo-50 shadow font-semibold">
            &larr; Kembali Ubah Preferensi
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
                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-sm text-left text-gray-700 border">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3">Nama Wisata</th>
                                <th class="px-6 py-3">Harga Tiket</th>
                                <th class="px-6 py-3">Rating</th>
                                <th class="px-6 py-3">Jumlah Fasilitas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($result as $item)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-indigo-700">{{ $item['wisata']->nama }}                                    </td>
                                    <td class="px-6 py-4">Rp{{ number_format($item['wisata']->harga_tiket) }}</td>
                                    <td class="px-6 py-4">{{ $item['wisata']->rating ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $item['wisata']->fasilitas->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="pt-6 flex justify-end">
                <a href="{{ route('operator.pariwisata.rekomendasi.step1') }}"
                    class="btn bg-indigo-600 text-white hover:bg-indigo-700">
                    Lanjutkan ke Step 1 &rarr;
                </a>
            </div>

        </div>
    </div>

@endsection
