@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Hasil Prediksi: {{ $barang->nama }}</h1>

    {{-- Info Koefisien --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="p-4 bg-white rounded shadow">
            <p class="text-gray-500">ΣX</p>
            <p class="text-lg font-semibold">{{ $nilaiX }}</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <p class="text-gray-500">ΣY</p>
            <p class="text-lg font-semibold">{{ number_format($nilaiY, 2) }}</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <p class="text-gray-500">ΣXY</p>
            <p class="text-lg font-semibold">{{ number_format($nilaiXY, 2) }}</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <p class="text-gray-500">ΣX²</p>
            <p class="text-lg font-semibold">{{ number_format($nilaiXX, 2) }}</p>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4 text-green-700">Evaluasi Data Historis</h2>
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="table-auto w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Bulan</th>
                        <th class="px-4 py-2">Tahun</th>
                        <th class="px-4 py-2">Aktual</th>
                        <th class="px-4 py-2">Prediksi</th>
                        <th class="px-4 py-2">MAD</th>
                        <th class="px-4 py-2">MSE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluasi as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $item['bulan'] }}</td>
                            <td class="px-4 py-2">{{ $item['tahun'] }}</td>
                            <td class="px-4 py-2">{{ number_format($item['aktual'], 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($item['prediksi'], 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($item['mad'], 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($item['mse'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <h2 class="text-xl font-bold mb-4 text-blue-700">Prediksi 12 Bulan ke Depan</h2>
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="table-auto w-full text-sm text-left text-gray-700">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 py-2">Bulan</th>
                        <th class="px-4 py-2">Tahun</th>
                        <th class="px-4 py-2">Prediksi</th>
                        <th class="px-4 py-2">MAD</th>
                        <th class="px-4 py-2">MSE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prediksiKeDepan as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $item['bulan'] }}</td>
                            <td class="px-4 py-2">{{ $item['tahun'] }}</td>
                            <td class="px-4 py-2">{{ number_format($item['prediksi'], 2) }}</td>
                            <td class="px-4 py-2 text-gray-400 italic">{{ $item['mad'] }}</td>
                            <td class="px-4 py-2 text-gray-400 italic">{{ $item['mse'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
