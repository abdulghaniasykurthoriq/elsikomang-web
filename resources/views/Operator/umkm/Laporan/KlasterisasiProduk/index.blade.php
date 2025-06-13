@extends('layouts.app2')

@section('title', 'Klasterisasi Harga Produk')

@section('content')

<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Klasterisasi Harga Produk UMKM</h1>
</div>

<div class="mx-2 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Data Produk & Parameter Klasterisasi</h2>
        </div>

        <div class="p-4">
            <!-- Tabel Produk -->
            <div class="overflow-x-auto mb-6">
                <table class="table-auto w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3">Varian</th>
                            <th class="px-4 py-3">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($data as $item)
                            @foreach ($item->produk_variant as $index => $variant)
                                <tr>
                                    @if ($index === 0)
                                        <td class="px-4 py-2" rowspan="{{ $item->produk_variant->count() }}">
                                            {{ $item->nama_produk }}
                                        </td>
                                    @endif
                                    <td class="px-4 py-2">{{ $variant->varian ?? '-' }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($variant->harga ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Form Parameter -->
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Parameter Klasterisasi</h3>
            <form action="{{ route('klasterisasi-produk.process') }}" method="POST" class="mb-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Jumlah Cluster:</label>
                        <input type="number" name="cluster" min="2" value="3"
                            class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Maksimal Iterasi:</label>
                        <input type="number" name="max_iterasi" min="1" value="10"
                            class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-md text-sm font-medium shadow">
                        Proses Klasterisasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
