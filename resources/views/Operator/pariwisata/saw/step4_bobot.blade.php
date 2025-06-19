@extends('layouts.app2')

@section('title', 'Step 4: Input Bobot Kriteria')

@section('content')

    <!-- Header Section -->
    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Step 4: Input Bobot Kriteria</h1>
        <a href="{{ route('operator.pariwisata.rekomendasi.step3') }}"
            class="btn bg-white text-indigo-700 hover:bg-indigo-50 shadow font-semibold">
            &larr; Kembali ke Step 3
        </a>
    </div>

    <!-- Form Section -->
    <div class="px-6 -mt-24 relative z-10 mx-2">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full p-6">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 rounded text-red-700">
                    {{ $errors->first('msg') }}
                </div>
            @endif

            <form action="{{ route('operator.pariwisata.rekomendasi.saveBobot') }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-sm text-left text-gray-700 border">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3">Kriteria</th>
                                <th class="px-6 py-3">Bobot (0.0 – 1.0)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($defaultBobot as $key => $value)
                                <tr>
                                    <td class="px-6 py-4 font-medium">
                                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="number" step="0.01" min="0" max="1"
                                            name="{{ $key }}" value="{{ $value }}" required
                                            class="form-input block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pt-6 flex justify-end">
                    <button type="submit" class="btn bg-indigo-600 text-white hover:bg-indigo-700">
                        Lanjut ke Step 5 &rarr;
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection
