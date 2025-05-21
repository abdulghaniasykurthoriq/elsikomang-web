@extends('layouts.app2')

@section('title', 'Dashboard Pariwisata')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Dashboard Pariwisata</h1>

    {{-- Ringkasan Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-sm text-gray-500">Total Wisata</h2>
            <p class="text-2xl font-bold text-indigo-600">32</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-sm text-gray-500">Pengunjung Bulan Ini</h2>
            <p class="text-2xl font-bold text-green-600">4.120</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-sm text-gray-500">Rating Tertinggi</h2>
            <p class="text-2xl font-bold text-yellow-500">4.8 / 5</p>
        </div>
    </div>

    {{-- Grafik Pengunjung --}}
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <h2 class="text-lg font-semibold mb-2">Grafik Pengunjung (6 Bulan Terakhir)</h2>
        <canvas id="chartVisitors" height="100"></canvas>
    </div>

    {{-- Wisata Terbaru/Populer --}}
    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-2">Wisata Terbaru / Populer</h2>
        <ul class="divide-y divide-gray-200">
            <li class="py-2 flex justify-between">
                <span>Pantai Kasambi Balongan</span>
                <span class="text-sm text-gray-500">1200 pengunjung</span>
            </li>
            <li class="py-2 flex justify-between">
                <span>Pantai Bali 2</span>
                <span class="text-sm text-gray-500">980 pengunjung</span>
            </li>
            <li class="py-2 flex justify-between">
                <span>Pantai Tiris</span>
                <span class="text-sm text-gray-500">875 pengunjung</span>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartVisitors').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Pengunjung',
                data: [500, 800, 1200, 1100, 1500, 1700],
                fill: false,
                borderColor: '#6366F1',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endsection
