@extends('layouts.app2')

@section('title', 'Step 3: Normalisasi Nilai')

@section('content')

    <!-- Header Section -->
    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Step 3: Normalisasi Nilai Alternatif</h1>
        <a href="{{ route('operator.pariwisata.rekomendasi.step2') }}"
            class="btn bg-white text-indigo-700 hover:bg-indigo-50 shadow font-semibold">
            &larr; Kembali ke Step 2
        </a>
    </div>

    <!-- Table Section -->
    <div class="px-6 -mt-24 relative z-10 mx-2">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
            <div class="p-4 border-b border-gray-100 font-semibold">
                Total: {{ $data->total() }} wisata

            </div>

            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">Nama Wisata</th>
                            <th class="px-6 py-3">Harga Tiket (Cost)</th>
                            <th class="px-6 py-3">Fasilitas (Benefit)</th>
                            <th class="px-6 py-3">Rating (Benefit)</th>
                            <th class="px-6 py-3">Waktu Operasional (Benefit)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($normalisasi as $row)
                            <tr>
                                <td class="px-6 py-4 font-medium">{{ $row['wisata']->nama }}</td>

                                @foreach (['harga_tiket', 'fasilitas', 'rating', 'waktu_operasional'] as $kriteria)
                                    <td class="px-6 py-4">
                                        <div class="text-gray-800">
                                            <strong>Skor:</strong> {{ $row['normalisasi'][$kriteria]['nilai'] ?? '-' }}
                                        </div>

                                        @if ($kriteria == 'fasilitas')
                                            <div class="text-xs text-gray-500 mt-1">
                                                Total fasilitas: {{ $row['wisata']->fasilitas->count() }}
                                            </div>
                                        @elseif ($kriteria == 'waktu_operasional')
                                            <div class="text-xs text-gray-500 mt-1">
                                                Durasi buka:
                                                {{ \Carbon\Carbon::parse($row['wisata']->jam_buka)->diffInHours(\Carbon\Carbon::parse($row['wisata']->jam_tutup)) }}
                                                jam
                                            </div>
                                        @elseif ($kriteria == 'harga_tiket')
                                            <div class="text-xs text-gray-500 mt-1">
                                                Harga: Rp{{ number_format($row['wisata']->harga_tiket, 0, ',', '.') }}
                                            </div>
                                        @elseif ($kriteria == 'rating')
                                            <div class="text-xs text-gray-500 mt-1">
                                                Rating asli: {{ $row['wisata']->rating }}
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                    {{ $data->links('components.pagination') }}
                </div>
            </div>
            <div class="p-4 flex justify-end">
                <a href="{{ route('operator.pariwisata.rekomendasi.step4') }}"
                    class="btn bg-indigo-600 text-white hover:bg-indigo-700">
                    Lanjut ke Step 4 &rarr;
                </a>
            </div>
        </div>
    </div>

@endsection
