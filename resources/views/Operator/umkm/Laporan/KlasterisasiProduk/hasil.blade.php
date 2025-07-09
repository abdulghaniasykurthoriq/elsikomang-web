@extends('layouts.app2')

@section('title', 'Hasil Klasterisasi Harga Produk')

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
    <h1 class="text-xl text-white">Hasil Klasterisasi Harga Produk - Tahun {{ $selectedYear }}</h1>
</div>

<div class="mx-2 px-6 -mt-24 relative z-10" x-data="{ tab: 'centroid' }">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">

        <!-- Tab Navigation -->
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex space-x-4 overflow-x-auto">
            <button @click="tab = 'centroid'" class="px-4 py-2 rounded font-semibold"
                :class="tab === 'centroid' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 border'">
                Centroid
            </button>
            <button @click="tab = 'iterasi'" class="px-4 py-2 rounded font-semibold"
            :class="tab === 'iterasi' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 border'">
            Proses Iterasi
            </button>
            <button @click="tab = 'klaster'" class="px-4 py-2 rounded font-semibold"
                :class="tab === 'klaster' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 border'">
                Hasil Klaster
            </button>
            <button @click="tab = 'euclidean'" class="px-4 py-2 rounded font-semibold"
                :class="tab === 'euclidean' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 border'">
                Euclidean Distance
            </button>
            <button @click="tab = 'grafik'" class="px-4 py-2 rounded font-semibold"
                :class="tab === 'grafik' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 border'">
                Grafik
            </button>

        </div>

        <!-- CENTROID -->
        <div class="p-4" x-show="tab === 'centroid'">
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
                                <td>{{ is_null($centroid[0]) ? 'Kosong' : number_format($centroid[0], 2) }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- HASIL KLASTERISASI -->
        <div class="p-4" x-show="tab === 'klaster'">
            <h3 class="text-md font-bold text-gray-800 mb-2">Hasil Klasterisasi Produk</h3>
            <div class="overflow-x-auto">
                <table id="hasil-klaster-table" class="table-auto w-full text-sm text-gray-700 border border-gray-200 rounded">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Nama Produk</th>
                            <th class="px-4 py-2">Harga</th>
                            <th class="px-4 py-2">Klaster</th>
                            <th class="px-4 py-2">Jarak ke Centroid</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($produkClustered as $produk)
                            <tr>
                                <td class="px-4 py-2">{{ $produk['nama_produk'] }}</td>
                                <td class="px-4 py-1">Rp {{ number_format($produk['harga'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ $produk['cluster'] }}</td>
                                <td class="px-4 py-2">{{ $produk['distance'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- EUCLIDEAN DISTANCE -->
        <div class="p-4" x-show="tab === 'euclidean'">
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

        <!-- ITERASI -->
        <div class="p-4" x-show="tab === 'iterasi'">
            <h3 class="text-md font-bold text-gray-800 mb-2">Proses Iterasi Klasterisasi</h3>
            @foreach ($logIterasi as $iterasi)
                <div class="mt-4 mb-6 p-4 border rounded shadow">
                    <h4 class="font-semibold">Iterasi ke-{{ $iterasi['iterasi'] }}</h4>
                    <ul class="list-disc ml-5">
                        @foreach ($iterasi['centroids'] as $i => $c)
                            <li>Centroid C{{ $i + 1 }} = {{ number_format($c[0], 2) }}</li>
                        @endforeach
                    </ul>

                    <div class="mt-3 overflow-x-auto">
                        <table class="table-auto w-full text-sm text-gray-700 border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2">Nama Produk</th>
                                    <th class="px-4 py-2">Harga</th>
                                    @foreach ($iterasi['centroids'] as $i => $c)
                                        <th class="px-4 py-2">Jarak ke C{{ $i + 1 }}</th>
                                    @endforeach
                                    <th class="px-4 py-2">Cluster</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($iterasi['jarak_data'] as $row)
                                    <tr>
                                <td class="px-4 py-2">{{ $row['nama_produk'] }}</td>
                                        <td class="px-4 py-1">Rp {{ number_format($row['harga'], 0, ',', '.') }}</td>
                                        @foreach ($row['distances'] as $d)
                                            <td class="px-4 py-1">{{ number_format($d, 2) }}</td>
                                        @endforeach
                                        <td class="px-4 py-1">{{ $row['cluster'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

                <!-- INFO CLUSTER -->
                <div class="p-4" x-show="tab === 'grafik'">
                    <h3 class="text-md font-bold text-gray-800 mb-2">Informasi Detail Tiap Cluster</h3>
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full text-sm text-left text-gray-700 border border-gray-200 rounded">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2">Cluster</th>
                                    <th class="px-4 py-2">Rentang Harga (Rp)</th>
                                    <th class="px-4 py-2">Rata-rata Harga</th>
                                    <th class="px-4 py-2">Jumlah Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $clusterInfo = [];
                                    foreach ($produkClustered as $item) {
                                        $cluster = $item['cluster'];
                                        $clusterInfo[$cluster][] = $item;
                                    }
                                @endphp
                                @foreach ($clusterInfo as $clusterName => $items)
                                    @php
                                        $hargas = array_column($items, 'harga');
                                        $min = min($hargas);
                                        $max = max($hargas);
                                        $avg = round(array_sum($hargas) / count($hargas), 2);
                                        $jumlah = count($hargas);
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-2 font-semibold">{{ $clusterName }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($min, 0, ',', '.') }} - Rp {{ number_format($max, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($avg, 2, ',', '.') }}</td>
                                        <td class="px-4 py-2">{{ $jumlah }} produk</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

        <!-- INFO CLUSTER & GRAFIK -->
        <div class="p-4 border-b border-gray-100" x-show="tab === 'grafik'">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Grafik Jumlah Produk per Bulan per Klaster</h2>
            <canvas id="clusterChart" height="100"></canvas>
        </div>

        <div class="p-4" x-show="tab === 'grafik'">
            <h3 class="text-md font-bold text-gray-800 mb-2">Jumlah Produk per Bulan per Klaster</h3>
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#hasil-klaster-table').DataTable({
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
