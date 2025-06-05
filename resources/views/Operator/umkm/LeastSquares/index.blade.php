@extends('layouts.app2')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white shadow-md rounded-xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">🔢 Simulasi Least Square</h2>

        <form method="POST" action="{{ route('simulasi.ls.proses') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @for ($i = 1; $i <= 5; $i++)
                    <div>
                        <label for="bulan{{ $i }}" class="block text-sm font-medium text-gray-700">Bulan {{ $i }}</label>
                        <input type="number" name="bulan[]" id="bulan{{ $i }}" required
                            value="{{ old('bulan.' . ($i - 1)) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                @endfor
            </div>
            <div class="text-right pt-4">
                <button type="submit"
                    class="inline-flex items-center px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-blue-700">
                    🔍 Proses Prediksi
                </button>
            </div>
        </form>
    </div>

    @isset($prediksi)
        <div class="bg-white shadow-md rounded-xl mt-8 p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">📈 Hasil Prediksi</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-4 py-2">Bulan</th>
                            <th class="px-4 py-2">Prediksi</th>
                            @isset($input)
                                <th class="px-4 py-2">Aktual</th>
                            @endisset
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($prediksi as $bulan => $nilai)
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-600">Bulan {{ $bulan }}</td>
                                <td class="px-4 py-2 text-blue-600 font-semibold">{{ number_format($nilai, 2) }}</td>
                                @isset($input)
                                    <td class="px-4 py-2">
                                        {{ isset($input[$bulan - 1]) ? number_format($input[$bulan - 1], 2) : '-' }}
                                    </td>
                                @endisset
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endisset
</div>
@endsection
