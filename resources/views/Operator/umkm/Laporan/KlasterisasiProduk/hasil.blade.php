@extends('layouts.app2')

@section('title', 'Hasil Klasterisasi Harga Produk')

@section('content')

<!-- Header -->
<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Hasil Klasterisasi Harga Produk </h1>
</div>

<!-- Main Container -->
<div class="mx-2 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">

        <!-- Tabel Klaster Produk -->
        <div class="p-4">
            <h3 class="text-md font-bold text-gray-800 mb-2">Hasil Klasterisasi Produk</h3>
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-gray-700 border border-gray-200 rounded">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Nama Produk</th>
                            <th class="px-4 py-2">Klaster</th>
                            <th class="px-4 py-2">Jarak ke Centroid</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($produkClustered as $produk)
                            <tr>
                                <td class="px-4 py-2">{{ $produk['nama_produk'] }}</td>
                                <td class="px-4 py-2">{{ $produk['cluster'] }}</td>
                                <td class="px-4 py-2">{{ $produk['distance'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Centroid -->
        <div class="p-4">
            <h3 class="text-md font-bold text-gray-800 mb-2">Centroid Tiap Cluster</h3>
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-center text-gray-700 border border-gray-200 rounded">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach ($centroids as $i => $centroid)
                                <th class="px-4 py-2">Centroid {{ $i + 1 }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($centroids as $centroid)
                                <td class="px-4 py-2">{{ round($centroid[0], 2) }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Euclidean Distance -->
        <div class="p-4">
            <h3 class="text-md font-bold text-gray-800 mb-2">Perhitungan Euclidean Distance</h3>
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-center text-gray-700 border border-gray-200 rounded">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Nama Produk</th>
                            <th class="px-4 py-2">Harga</th>
                            @foreach ($centroids as $i => $centroid)
                                <th class="px-4 py-2">Jarak ke C{{ $i + 1 }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($euclideanTable as $item)
                            <tr>
                                <td class="px-4 py-1">{{ $item['nama_produk'] }}</td>
                                <td class="px-4 py-1">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                @foreach ($item['distances'] as $distance)
                                    <td class="px-4 py-1">{{ $distance }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Hasil Akhir -->
        <div class="p-4">
            <h3 class="text-md font-bold text-gray-800 mb-2">Hasil Akhir Klasterisasi</h3>
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-center text-gray-700 border border-gray-200 rounded">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Nama Produk</th>
                            <th class="px-4 py-2">Harga</th>
                            <th class="px-4 py-2">Cluster</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produkClustered as $item)
                            <tr>
                                <td class="px-4 py-1">{{ $item['nama_produk'] }}</td>
                                <td class="px-4 py-1">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                <td class="px-4 py-1 font-semibold text-blue-700">{{ $item['cluster'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

                <!-- Chart -->
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-lg font-semibold text-gray-800">Laporan Klasterisasi Produk - Tahun {{ $year }}</h2>
        
                        <form method="GET" action="{{ route('klasterisasi-produk.process') }}" class="flex items-center space-x-2">
                            <label for="tahun" class="text-sm text-gray-800">Pilih Tahun:</label>
                            <select id="tahun" name="tahun" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-300">
                                @for ($yearOption = 2023; $yearOption <= 2026; $yearOption++)
                                    <option value="{{ $yearOption }}" {{ $selectedYear == $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                                @endfor
                            </select>
                        </form>
                    </div>
        
                    <div class="mb-6">
                        <canvas id="clusterChart" height="100"></canvas>
                    </div>
                </div>
        
        
                <!-- Tabel Jumlah Transaksi -->
                <div class="p-4">
                    <h3 class="text-md font-bold text-gray-800 mb-2">Jumlah Transaksi per Bulan per Klaster</h3>
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full text-sm text-gray-700 border border-gray-200 rounded">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Bulan</th>
                                    @foreach ($labels as $label)
                                        <th class="px-4 py-2 text-left">{{ $label }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($months as $i => $bulan)
                                    <tr>
                                        <td class="px-4 py-2">{{ $bulan }}</td>
                                        @foreach ($labels as $label)
                                            <td class="px-4 py-2">{{ $clusterMonthly[$label][$i] ?? 0 }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        

    </div>
</div>


<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script Chart -->
<script>
    const ctx = document.getElementById('clusterChart').getContext('2d');
    const clusterChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [
                @foreach ($labels as $i => $label)
                {
                    label: '{{ $label }}',
                    data: @json($clusterMonthly[$label]),
                    backgroundColor: '{{ $colors[$i] }}',
                    borderWidth: 1
                },
                @endforeach
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>

@endsection
