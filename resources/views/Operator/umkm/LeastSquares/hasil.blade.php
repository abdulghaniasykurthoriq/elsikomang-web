@extends('layouts.app2')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        📊 Hasil Prediksi Pendapatan Transaksi UMKM
    </h1>

    {{-- Informasi Koefisien --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach ([
            ['label' => 'ΣX', 'value' => $nilaiX],
            ['label' => 'ΣY', 'value' => number_format($nilaiY, 2)],
            ['label' => 'ΣXY', 'value' => number_format($nilaiXY, 2)],
            ['label' => 'ΣX²', 'value' => number_format($nilaiXX, 2)],
        ] as $info)
            <div class="p-4 bg-white rounded-lg shadow hover:shadow-md transition">
                <p class="text-sm text-gray-500">{{ $info['label'] }}</p>
                <p class="text-lg font-semibold text-gray-800">{{ $info['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Evaluasi Historis --}}
    <div class="mb-10">
        <h2 class="text-xl font-semibold text-green-700 mb-4">📉 Evaluasi Data Historis</h2>
        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="table-auto w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        @foreach (['Bulan', 'Tahun', 'Aktual', 'Prediksi', 'MAD', 'MAPE', 'Akurasi', 'Keterangan'] as $header)
                            <th class="px-4 py-2 font-semibold">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($evaluasi as $item)
                        @php
                            $akurasi = 100 - $item['mape'];
                            $keterangan = match (true) {
                                $item['mape'] < 10 => 'Sangat Baik',
                                $item['mape'] < 20 => 'Baik',
                                $item['mape'] < 50 => 'Cukup Baik',
                                default => 'Buruk',
                            };
                        @endphp
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $item['bulan'] }}</td>
                            <td class="px-4 py-2">{{ $item['tahun'] }}</td>
                            <td class="px-4 py-2">{{ number_format($item['aktual'], 2) }}</td>
                            <td class="px-4 py-2 text-blue-600">{{ number_format($item['prediksi'], 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($item['mad'], 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($item['mape'], 2) }}%</td>
                            <td class="px-4 py-2 text-green-600">{{ number_format($akurasi, 2) }}%</td>
                            <td class="px-4 py-2 italic">{{ $keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-400 italic">Tidak ada data historis</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 flex justify-between items-center">
            <div>
                @if ($evaluasi->onFirstPage())
                    <span class="text-gray-400">← Previous</span>
                @else
                    <a href="{{ $evaluasi->previousPageUrl() }}" class="text-blue-600 hover:underline">← Previous</a>
                @endif
            </div>
            <span class="text-gray-600 text-sm">
                Page {{ $evaluasi->currentPage() }} of {{ $evaluasi->lastPage() }}
            </span>
            <div>
                @if ($evaluasi->hasMorePages())
                    <a href="{{ $evaluasi->nextPageUrl() }}" class="text-blue-600 hover:underline">Next →</a>
                @else
                    <span class="text-gray-400">Next →</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Prediksi Ke Depan --}}
    <div>
        <h2 class="text-xl font-semibold text-blue-700 mb-4">
            📅 Prediksi {{ $jumlahBulanPrediksi ?? count($prediksiKeDepan) }} Bulan ke Depan
        </h2>
        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="table-auto w-full text-sm text-left text-gray-700">
                <thead class="bg-blue-100">
                    <tr>
                        @foreach (['Bulan', 'Tahun', 'Prediksi', 'MAD', 'MAPE'] as $header)
                            <th class="px-4 py-2 font-semibold">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prediksiKeDepan as $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $item['bulan'] }}</td>
                            <td class="px-4 py-2">{{ $item['tahun'] }}</td>
                            <td class="px-4 py-2 text-blue-600">{{ number_format($item['prediksi'], 2) }}</td>
                            <td class="px-4 py-2 text-gray-400 italic">{{ $item['mad'] }}</td>
                            <td class="px-4 py-2 text-gray-400 italic">{{ $item['mape'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-400 italic">Belum ada prediksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
