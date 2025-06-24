@extends('layouts.app2')

@section('title', 'Prediksi Bulan ' . \Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F Y'))

@section('content')
<div class="bg-indigo-700 text-white px-6 py-6">
    <h1 class="text-xl font-bold">
        Prediksi Bulan {{ \Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F Y') }}
    </h1>
</div>

<div class="p-6">
  <div class="bg-white rounded shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-center">
    <div>
      <div class="text-gray-500 mb-1">Pendapatan Aktual</div>
      <div class="text-2xl font-bold text-blue-600">
        Rp{{ number_format($totalAktual, 0, ',', '.') }}
      </div>
    </div>

    <div>
      <div class="text-gray-500 mb-1">Estimasi Prediksi Bulan</div>
      <div class="text-2xl font-bold text-red-600">
        Rp{{ number_format($totalPrediksiAll, 0, ',', '.') }}
      </div>
    </div>
  </div>

  <div class="bg-white rounded shadow p-4">
    <h2 class="text-lg font-semibold mb-4">
      Grafik Harian - {{ \Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F Y') }}
    </h2>

    @if($totalAktual == 0)
      <div class="text-center py-10 text-gray-500">
        <p class="mb-4">Belum ada data transaksi di bulan ini.</p>
        <canvas id="chartHarian" class="opacity-50"></canvas>
        <p class="text-xs mt-4 text-gray-400">
          Grafik hanya menampilkan estimasi prediksi harian (warna merah) karena belum ada data aktual.
        </p>
      </div>
    @else
      <canvas id="chartHarian"></canvas>
      <p class="text-xs text-gray-500 italic mt-2">
        *Grafik ini bersifat ilustratif — prediksi (merah) vs data aktual (biru). Evaluasi akurasi di tingkat tahunan.
      </p>
    @endif

  </div>

  <div class="mt-6">
    <a href="{{ route('transaksi-produk-umkm.index') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      ← Kembali ke Ringkasan Tahunan
    </a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
const ctx = document.getElementById('chartHarian').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($labels) !!},
        datasets: [
            {
                label: 'Aktual',
                data: {!! json_encode($actualData) !!},
                backgroundColor: '#3b82f6'
            },
            {
                label: 'Prediksi',
                data: {!! json_encode($predictData) !!},
                backgroundColor: '#ef4444'
            }
        ]
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Pendapatan (Rp)', font: { weight: 'bold' } },
                ticks: { callback: v => 'Rp' + Number(v).toLocaleString('id-ID') }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: ctx => `${ctx.dataset.label}: Rp${ctx.parsed.y.toLocaleString('id-ID')}`
                }
            }
        }
    }
});
</script>
@endsection
