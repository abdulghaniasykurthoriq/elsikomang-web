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
                            <th class="px-6 py-3 text-center">Peringkat</th>
                            <th class="px-6 py-3">Nama Wisata</th>
                            <th class="px-6 py-3 text-center">Skor SAW</th>
                            <th class="px-6 py-3">Info Lain</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($ranking as $row)
                            <tr @if ($loop->first) @endif>
                                <td class="px-6 py-4 font-bold text-center">{{ $row->peringkat }}</td>
                                <td class="px-6 py-4 font-medium">{{ $row->pariwisata->nama }}</td>
                                <td class="px-6 py-4 text-center text-indigo-700 font-semibold">
                                    {{ number_format($row->skor_total, 4) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">{{ $row->pariwisata->lokasi }}</div>
                                    <div class="text-xs text-gray-500">
                                        Kategori: {{ ucfirst($row->pariwisata->kategori) }} |
                                        Rating: {{ $row->pariwisata->rating }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                    {{ $ranking->links('components.pagination') }}
                </div>
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
