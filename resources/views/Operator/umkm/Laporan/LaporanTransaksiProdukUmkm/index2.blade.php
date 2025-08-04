@extends('layouts.app2')

@section('title', 'Prediksi Pendapatan')

@section('content')

<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Prediksi Pendapatan Tahun {{ $year }}</h1>
</div>

<div class="mx-2 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
        <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between gap-4 items-center">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Prediksi Pendapatan</h2>

                <!-- Pilih Tahun -->
                <form method="GET">
                    <label for="tahun" class="text-sm text-gray-600">Tahun:</label>
                    <select name="tahun" id="tahun"
                        class="border border-gray-300 rounded-md px-2 py-1 text-sm"
                        onchange="this.form.submit()">
                        @for ($i = now()->year; $i >= now()->year - 3; $i--)
                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </form>

                <!-- Input Jumlah Bulan Prediksi -->
                <form method="GET" method="GET" action="{{ route('peramalan.proses') }}" class="flex items-center gap-2">
                    <label for="jumlah_bulan" class="text-sm text-gray-600">Prediksi Bulan Kedepan:</label>
                    <input
                        type="number"
                        name="jumlah_bulan"
                        id="jumlah_bulan"
                        min="1"
                        max="12"
                        class="border border-gray-300 rounded-md px-2 py-1 text-sm w-20"
                        placeholder="cth: 3">
                    <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded-md text-sm hover:bg-indigo-700">
                        Hitung
                    </button>
                </form>
            </div>

            <!-- Pilih Bulan (navigasi) -->
            <div class="flex items-center gap-2">
                <label for="bulan-navigator" class="text-sm text-gray-700">Lihat Detail Bulan:</label>
                <select id="bulan-navigator" class="border border-gray-300 rounded-md px-2 py-1 text-sm"
                    onchange="navigateToBulan(this)">
                    <option value="">-- Pilih Bulan --</option>
                    @foreach($months as $index => $month)
                        <option value="{{ $index }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Chart -->
        <canvas id="pendapatanChart" height="100"></canvas>
        <div class="bg-[#f1f4fa] h-[20px] w-full"></div>

        <!-- Legend -->
        <div class="overflow-x-auto">
            <div class="flex items-center gap-4 px-4 py-2">
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 bg-blue-500 rounded"></span>
                    <span class="text-sm text-gray-700">Aktual</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 bg-yellow-500 rounded border border-dashed border-gray-500"></span>
                    <span class="text-sm text-gray-700">Prediksi</span>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 px-4 py-2 text-sm text-gray-600">
                <div><span class="text-blue-600 font-bold">A</span>: Aktual</div>
                <div><span class="text-yellow-600 font-bold">P</span>: Prediksi</div>
                <div><span class="text-red-600 font-bold">E</span>: Error</div>
            </div>

            <!-- Tabel -->
            <!-- Tabel -->
<table class="table-auto w-full text-sm text-left text-gray-700">
    <thead class="bg-gray-50 border-b border-gray-200 rounded-xl">
        <tr>
            <th class="px-4 py-3 text-center">Bulan</th>
            @foreach($months as $month)
                <th class="px-4 py-3 text-center">{{ $month }}</th>
            @endforeach
            <th class="px-4 py-3 text-center text-red-700">MAPE (%)</th>
            <th class="px-4 py-3 text-center text-green-700">Akurasi (%)</th>
            <th class="px-4 py-3 text-center text-indigo-700">Keterangan</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        <tr>
            <td class="px-4 py-3 font-medium text-gray-800 text-center">Total</td>
            @for ($i = 1; $i <= 12; $i++)
                @php
                    $cell = $bulanData[$i] ?? ['actual' => null, 'prediksi' => null, 'error' => null];
                @endphp
                <td class="px-4 py-3 text-xs text-center leading-tight">
                    @if (!is_null($cell['actual']))
                        <span class="text-blue-600 font-semibold block">
                            {{ number_format($cell['actual'], 0, ',', '.') }}
                        </span>
                    @endif
                    @if (!is_null($cell['prediksi']))
                        <span class="text-yellow-600 font-semibold block">
                            {{ number_format($cell['prediksi'], 0, ',', '.') }}
                        </span>
                    @endif
                    @if (!is_null($cell['error']))
                        <span class="text-red-600 font-semibold block">
                            {{ number_format($cell['error'], 2) }}%
                        </span>
                    @endif
                </td>
            @endfor

            @php
                $akurasi = $mape !== null ? 100 - $mape : null;
                $keterangan = match (true) {
                    $mape === null        => '-',
                    $mape < 10            => 'Sangat Baik',
                    $mape >= 10 && $mape < 20 => 'Baik',
                    $mape >= 20 && $mape < 50 => 'Cukup Baik',
                    $mape >= 50           => 'Buruk',
                };
            @endphp

            <td class="px-4 py-3 text-center font-semibold text-red-700">
                {{ $mape !== null ? number_format($mape, 2) . '%' : '-' }}
            </td>
            <td class="px-4 py-3 text-center font-semibold text-green-600">
                {{ $akurasi !== null ? number_format($akurasi, 2) . '%' : '-' }}
            </td>
            <td class="px-4 py-3 text-center italic text-indigo-700">
                {{ $keterangan }}
            </td>
        </tr>
    </tbody>
</table>

        </div>
        <div class="bg-[#f1f4fa] h-[20px] w-full"></div>
    </div>
</div>

<!-- Chart.js -->
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
                    borderColor: '#ca8a04',
                    backgroundColor: '#ca8a04',
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

    function navigateToBulan(select) {
        const bulan = select.value;
        if (!bulan) return;
        const tahun = {{ $year }};
        const paddedBulan = bulan.toString().padStart(2, '0');
        window.location.href = `/laporan-transaksi-produk-umkm/${tahun}/${paddedBulan}`;
    }
</script>

@endsection
