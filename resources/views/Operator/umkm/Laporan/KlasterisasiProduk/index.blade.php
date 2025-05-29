@extends('layouts.app2')
@section('title', 'Laporan Transaksi Produk Per Klaster')
@section('content')

<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Laporan Jumlah Transaksi per Klaster - Tahun {{ $year }}</h1>
    {{-- <a href="{{ route('Klasterisasi-umkm.index', ['jenis' => request()->route('jenis')]) }}"class="btn btn-success"></a> --}}
    <a href="{{ route('klasterisasi-produk.index', ['jenis' => request()->route('jenis')]) }}" class="btn btn-success"></a>

</div>

<div class="mx-2 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Rekap Pendapatan Bulanan Berdasarkan Klaster</h2>
                <p class="text-sm text-gray-600 mt-2">
                    <strong>Rentang Harga:</strong>
                    Klaster Murah: Rp0 – Rp50.000 |
                    Klaster Sedang: Rp50.001 – Rp200.000 |
                    Klaster Mahal: Rp200.001 ke atas
                </p>
            </div>
            
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
            <!-- Grafik -->
            <canvas id="transaksiChart" height="120"></canvas>

            <!-- Tabel Transaksi -->
            <table class="table-auto w-full text-sm text-left text-gray-700 mt-6">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-center">Bulan</th>
                        @foreach($labels as $label)
                            <th class="px-4 py-3 text-center">Klaster {{ ucfirst($label) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($months as $i => $namaBulan)
                        <tr>
                            <td class="px-4 py-3 text-center font-semibold">{{ $namaBulan }}</td>
                            @foreach($labels as $label)
                                <td class="px-4 py-3 text-center text-sm">
                                    {{ number_format($clusterMonthly[$label][$i+1] ?? 0, 0, ',', '.') }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
const labels = {!! json_encode($months) !!};
const datasets = [
    @foreach ($labels as $i => $label)
        {
            label: 'Klaster {{ ucfirst($label) }}',
            data: {!! json_encode(array_values($clusterMonthly[$label] ?? [])) !!},
            borderColor: '{{ $colors[$i] }}',
            backgroundColor: '{{ $colors[$i] }}',
            borderWidth: 2,
            fill: false,
            tension: 0.3,
            pointRadius: 3
        },
    @endforeach
];

const ctx = document.getElementById('transaksiChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: datasets
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false
        },
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: ctx => ctx.dataset.label + ': ' + ctx.parsed.y.toLocaleString('id-ID') + ' transaksi'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Transaksi',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                },
                ticks: {
                    callback: val => val.toLocaleString('id-ID')
                }
            }
        }
    }
});
</script>
@endsection
