@extends('layouts.app2')

@section('title', 'Jenis Kriteria')

@section('content')

    <!-- Header Section -->
    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Jenis Kriteria</h1>
        {{-- <a href="{{ route('operator.pariwisata.rekomendasi.step1') }}"
            class="btn bg-white text-indigo-700 hover:bg-indigo-50 shadow font-semibold">
            &larr; Kembali ke Step 1
        </a> --}}
    </div>

    <!-- Table Section -->
    <div class="px-6 -mt-24 relative z-10 mx-2">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
            <div class="px-4 pt-2 pb-4">
                <div class="mb-4 p-4 bg-blue-50 text-sm text-blue-800 rounded-md border border-blue-300">
                    <strong>Catatan:</strong>
                    <span class="text-green-600 font-semibold">Benefit</span> berarti semakin besar nilainya semakin baik.
                    <span class="text-red-600 font-semibold">Cost</span> berarti semakin kecil nilainya semakin baik.
                </div>

                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3">Kriteria</th>
                                <th class="px-6 py-3">Label</th>
                                <th class="px-6 py-3">Tipe</th>
                                <th class="px-6 py-3 text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @foreach ($kriterias as $item)
                                <tr>
                                    <form action="{{ route('operator.pariwisata.rekomendasi.kriteria.update', $item->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <td class="px-6 py-4 font-medium">{{ $item->nama }}</td>

                                        <td class="px-6 py-4">
                                            <input type="text" name="label" value="{{ $item->label }}"
                                                class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                                        </td>

                                        <td class="px-6 py-4">
                                            <select name="tipe"
                                                class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                                                <option value="benefit" {{ $item->tipe == 'benefit' ? 'selected' : '' }}>
                                                    Benefit</option>
                                                <option value="cost" {{ $item->tipe == 'cost' ? 'selected' : '' }}>Cost
                                                </option>
                                            </select>
                                        </td>


                                        <td class="px-6 py-4 text-end">
                                            <button type="submit"
                                                class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                                                Simpan
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                {{-- <div class="pt-6 text-end">
                    <a href="{{ route('operator.pariwisata.rekomendasi.step3') }}"
                        class="btn bg-indigo-600 text-white hover:bg-indigo-700">
                        Lanjut ke Step 3 &rarr;
                    </a>
                </div> --}}
            </div>
        </div>
    </div>

@endsection
