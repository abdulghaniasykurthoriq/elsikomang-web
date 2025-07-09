@extends('layouts.app2')

@section('title', 'Step 5: Skor Akhir Wisata')

@section('content')
    @if ($errors->any())
        <div class="mb-4 mx-6 mt-4 p-4 bg-red-100 border border-red-400 rounded text-red-700">
            {{ $errors->first('msg') }}
        </div>
    @endif

    <!-- Header Section -->
    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Step 5: Skor Akhir Wisata</h1>
        <a href="{{ route('operator.pariwisata.rekomendasi.step4') }}"
            class="btn bg-white text-indigo-700 hover:bg-indigo-50 shadow font-semibold">
            &larr; Kembali ke Step 4
        </a>
    </div>

    <!-- Table Section -->
    <div class="px-6 -mt-24 relative z-10 mx-2">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full p-6">
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-left text-gray-700 border">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">Nama Wisata</th>
                            <th class="px-6 py-3">Harga Tiket</th>
                            <th class="px-6 py-3">Fasilitas</th>
                            <th class="px-6 py-3">Rating</th>
                            <th class="px-6 py-3">Waktu Operasional</th>
                            <th class="px-6 py-3">Skor SAW</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach ($skorData as $row)
                            <tr>
                                <td class="px-6 py-4 font-medium">{{ $row['wisata']->nama }}</td>

                                @foreach (['harga_tiket', 'fasilitas', 'rating', 'waktu_operasional'] as $kriteria)
                                    <td class="px-6 py-4">
                                        <div><strong>Normalisasi:</strong>
                                            {{ number_format($row['detail'][$kriteria]['normalisasi'], 4) }}</div>
                                        <div><strong>Bobot:</strong> {{ $row['detail'][$kriteria]['bobot'] }}</div>
                                        <div><strong>Perkalian:</strong> {{ $row['detail'][$kriteria]['perkalian'] }} =
                                            {{ number_format($row['detail'][$kriteria]['hasil'], 4) }}</div>
                                    </td>
                                @endforeach

                                <td class="px-6 py-4 font-semibold text-indigo-700">
                                    {{ number_format($row['skor'], 4) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                    {{ $data->links('components.pagination') }}
                </div>
            </div>

            <div class="pt-6 flex justify-end">
                <a href="{{ route('operator.pariwisata.rekomendasi.step6') }}"
                    class="btn bg-indigo-600 text-white hover:bg-indigo-700">
                    Lanjut ke Step 6 &rarr;
                </a>
            </div>
        </div>
    </div>

@endsection
