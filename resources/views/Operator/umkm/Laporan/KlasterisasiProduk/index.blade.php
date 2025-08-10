@extends('layouts.app2')

@section('title', 'Klasterisasi Harga Produk')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    div.dataTables_wrapper .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }
            .dataTables_length select {
            padding-right: 1rem;        
            background-position: right 0rem center; 
            background-repeat: no-repeat;
            background-size: 1rem;
            appearance: auto;          
        }
</style>
@endpush

@section('content')

<!-- Header -->
<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Klasterisasi Harga Produk UMKM</h1>
</div>

<!-- Konten Utama -->
<div class="mx-2 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">

        <!-- Header -->
        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Parameter Klasterisasi & Data Produk</h2>
        </div>
        

        <div class="p-4">
            {{-- Tampilkan Error Validasi --}}
            @if ($errors->any())
                <div class="mb-4">
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            {{-- Form Parameter Klasterisasi --}}
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Parameter Klasterisasi</h3>
            <form action="{{ route('klasterisasi-produk.process') }}" method="POST" class="mb-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Jumlah Cluster -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Jumlah Cluster:</label>
                        <input type="number" name="cluster" min="2" value="{{ old('cluster', 3) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('cluster')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Maksimal Iterasi -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Maksimal Iterasi:</label>
                        <input type="number" name="max_iterasi" min="1" value="{{ old('max_iterasi', 10) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('max_iterasi')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pilih Tahun -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Pilih Tahun:</label>
                        <select name="tahun"
                            class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ old('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-md text-sm font-medium shadow">
                        Proses Klasterisasi
                    </button>
                </div>
            </form>

            {{-- Tabel Produk --}}
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Data Produk</h3>
            @if (count($data) > 0)
                <div class="overflow-x-auto">
                    <table id="produk-t-table" class="display nowrap w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3">Produk</th>
                                <th class="px-4 py-3">Varian</th>
                                <th class="px-4 py-3">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($data as $item)
                                @php $variantCount = $item->produk_variant->count(); @endphp
                                @if ($variantCount === 0)
                                    <tr>
                                        <td class="px-4 py-2">{{ $item->nama_produk }}</td>
                                        <td class="px-4 py-2 text-gray-400 italic">-</td>
                                        <td class="px-4 py-2 text-gray-400 italic">Tidak ada varian</td>
                                    </tr>
                                @else
                                    @foreach ($item->produk_variant as $index => $variant)
                                        <tr>
                                            @if ($index === 0)
                                                <td class="px-4 py-2" rowspan="{{ $variantCount }}">
                                                    {{ $item->nama_produk }}
                                                </td>
                                            @endif
                                            <td class="px-4 py-2">{{ $variant->varian ?? '-' }}</td>
                                            <td class="px-4 py-2">Rp {{ number_format($variant->harga ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-gray-500">Tidak ada data produk yang tersedia.</p>
            @endif

        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#produk-t-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 10,
            dom: '<"top"f<"spacer">l>rt<"bottom"ip><"clear">'
        });
        feather.replace();
    });
</script>



@endpush
