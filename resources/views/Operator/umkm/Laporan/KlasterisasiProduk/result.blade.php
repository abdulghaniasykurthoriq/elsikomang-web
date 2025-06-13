@extends('layouts.app2')
@section('title', 'Hasil Klasterisasi')
@section('content')

<div class="max-w-5xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Hasil Klasterisasi</h2>

    <table class="table-auto w-full mb-6 border">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Cluster</th>
            </tr>
        </thead>
        <tbody>
            @foreach($history as $row)
                <tr class="border-t">
                    <td>{{ $row['nama_produk'] }}</td>
                    <td>Rp{{ number_format($row['harga'], 0, ',', '.') }}</td>
                    <td>{{ $labels[$row['cluster']] ?? 'Cluster '.$row['cluster'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <canvas id="chart" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const data = {
        labels: @json(array_column($history, 'nama_produk')),
        datasets: [{
            label: 'Harga Produk per Cluster',
            data: @json(array_column($history, 'harga')),
            backgroundColor: @json(array_map(fn($c) => ['#f87171', '#facc15', '#4ade80'][$c], array_column($history, 'cluster')))
        }]
    };

    new Chart(document.getElementById('chart'), {
        type: 'bar',
        data: data
    });
</script>
@endsection
