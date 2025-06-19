@extends('layouts.app2')

@section('title', 'Step 6: Ranking Wisata')

@section('content')

    <!-- Header Section -->
    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Step 6: Hasil Ranking Wisata</h1>
        <a href="{{ route('operator.pariwisata.rekomendasi.step5') }}"
            class="btn bg-white text-indigo-700 hover:bg-indigo-50 shadow font-semibold">
            &larr; Kembali ke Step 5
        </a>
    </div>

    <!-- Table Section -->
    <div class="px-6 -mt-24 relative z-10 mx-2">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full p-6">
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-left text-gray-700 border">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">Peringkat</th>
                            <th class="px-6 py-3">Nama Wisata</th>
                            <th class="px-6 py-3">Skor SAW</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($ranking as $i => $row)
                            <tr @if ($i === 0) class="bg-green-300" @endif>

                                <td class="px-6 py-4 font-bold text-center">{{ $i + 1 }}</td>
                                <td class="px-6 py-4">{{ $row['wisata']->nama }}</td>
                                <td class="px-6 py-4 font-semibold text-indigo-700">{{ number_format($row['skor'], 4) }}
                                <td class="px-6 py-4">
                                    {{ $row['wisata']->nama }}
                                    <div class="text-xs text-gray-500">
                                        Kategori: {{ ucfirst($row['wisata']->kategori) }} |
                                        Rating: {{ $row['wisata']->rating }}
                                    </div>
                                </td>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pt-6 flex justify-end">
                <a href="{{ route('operator.pariwisata.rekomendasi.step1') }}"
                    class="btn bg-gray-300 text-gray-800 hover:bg-gray-400">
                    Ulangi Proses
                </a>
            </div>
        </div>
    </div>

@endsection
