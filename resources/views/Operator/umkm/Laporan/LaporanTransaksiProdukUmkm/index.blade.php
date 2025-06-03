@extends('layouts.app2')

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
            <!-- Grafik -->
            <canvas id="pendapatanChart" height="100"></canvas>

            <!-- Legend chart -->
            <div class="flex items-center gap-4 px-4 py-2">
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 bg-blue-500 rounded"></span>
                    <span class="text-sm text-gray-700">Aktual</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 bg-red-500 rounded border border-dashed border-gray-500"></span>
                    <span class="text-sm text-gray-700">Prediksi</span>
                </div>
            </div>

            <div class="bg-[#f1f4fa] h-[20px] w-full"></div>
            <div class="flex items-center justify-end gap-4 px-4 py-2 text-sm text-gray-600">
                <div><span class="text-blue-600 font-bold">A</span>: Aktual</div>
                <div><span class="text-red-600 font-bold">P</span>: Prediksi</div>
                <div><span class="text-yellow-600 font-bold">E</span>: Error</div>
            </div>

            <table class="table-auto w-full text-sm text-left text-gray-700 ">
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
                            @for ($i = 1; $i <= 12; $i++)
                                @php
                                    $data = $bulanData[$i] ?? ['actual' => null, 'prediksi' => null, 'error' => null];
                                @endphp
                                <td class="px-4 py-3 text-xs text-center leading-tight">
                                    @if (!is_null($data['actual']))
                                        <span class="text-blue-600 font-semibold block">
                                            A: {{ number_format($data['actual'], 0, ',', '.') }}
                                        </span>
                                    @endif
                                    @if (!is_null($data['prediksi']))
                                        <span class="text-red-600 font-semibold block">
                                            P: {{ number_format($data['prediksi'], 0, ',', '.') }}
                                        </span>
                                    @endif
                                    @if (!is_null($data['error']))
                                        <span class="text-yellow-600 font-semibold block">
                                            E: {{ number_format($data['error'], 4) }}
                                        </span>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- CDN Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

<script>
const labels     = {!! json_encode($labels ?? []) !!};
const dataActual = {!! json_encode($actual ?? []) !!};
const dataPred   = {!! json_encode($prediction ?? []) !!};

const ctx = document.getElementById('pendapatanChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels,
        datasets: [
            {
                label: 'Aktual',
                data: dataActual,
                borderWidth: 2,
                tension: .3,
                pointRadius: 4,
                borderColor: '#3b82f6',
                backgroundColor: '#3b82f6',
            },
            {
                label: 'Prediksi',
                data: dataPred,
                borderWidth: 2,
                tension: .3,
                pointRadius: 4,
                borderColor: '#ef4444',
                backgroundColor: '#ef4444',
                borderDash: [6, 3],
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Transaksi',
                    color: '#374151',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                },
                ticks: {
                    stepSize: 10,
                    callback: function(value) {
                        return typeof value === 'number'
                            ? value.toLocaleString('id-ID')
                            : value;
                    }
                }
            }
        }
    }
});
</script>


@endsection
