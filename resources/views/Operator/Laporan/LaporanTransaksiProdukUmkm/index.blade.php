@extends('layouts.app')

@section('title', 'Prediksi Pendapatan Produk')

@section('content')

<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Prediksi Pendapatan Produk - Tahun {{ $year }}</h1>
</div>

<div class="mx-2 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Prediksi Pendapatan</h2>

            <form method="GET">
                <label for="tahun" class="mr-2 text-sm text-gray-600">Pilih Tahun:</label>
                <div class="relative inline-block w-20">
                    <select name="tahun" id="tahun"
                        class="w-full border border-gray-300 rounded-md px-2 pr-8 py-1 text-sm appearance-none bg-white"
                        onchange="this.form.submit()">
                        @for ($i = now()->year; $i >= now()->year - 3; $i--)
                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    
                </div>

            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-center">Produk</th>
                        @foreach($months as $month)
                            <th class="px-4 py-3 text-center">{{ $month }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @foreach($dataView as $produk => $bulanData)
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-800 whitespace-nowrap">{{ $produk }}</td>
                      
                            @foreach($bulanData as $data)
                                <td class="px-4 py-3 text-center">
                                    @if ($data['pendapatan'] > 0)
                                        <span class="text-green 600 font-semibold">{{ number_format($data['pendapatan'], 0, ',', '.') }}</span> <br/>
                                        @if ($data['status'] === 'Prediksi')
                                            <span class="text-red-600 font-semibold animate-blink">Prediksi</span>
                                        @endif
                                        
                                    @else
                                        <span class="text-red-600 font-semibold">0</span>
                                    @endif
                                </td>
                            @endforeach

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
