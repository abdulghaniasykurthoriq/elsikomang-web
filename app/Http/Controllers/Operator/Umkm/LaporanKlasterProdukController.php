<?php

namespace App\Http\Controllers\Operator\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProdukUmkm;
use Carbon\Carbon;

class LaporanKlasterProdukController extends Controller
{
    public function index()
    {
        $data = ProdukUmkm::with('produk_variant')->get();

        $tahunList = [];

        foreach ($data as $item) {
            foreach ($item->produk_variant as $variant) {
                $createdAt = $variant->created_at ?? $item->created_at;
                $year = Carbon::parse($createdAt)->format('Y');
                $tahunList[] = $year;
            }
        }

        $tahunList = collect($tahunList)->unique()->sortDesc()->values()->all();

        return view('Operator.umkm.Laporan.KlasterisasiProduk.index', compact('data', 'tahunList'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'cluster' => 'required|integer|min:2',
            'max_iterasi' => 'required|integer|min:1',
            'tahun' => 'nullable|integer|min:2000|max:' . date('Y'),
        ]);

        $cluster = (int) $request->input('cluster');
        $maxIterasi = (int) $request->input('max_iterasi');
        $selectedYear = (int) $request->input('tahun', date('Y'));

        $produk = ProdukUmkm::with('produk_variant')->get();
        $dataset = [];
        $produkMapping = [];

        foreach ($produk as $item) {
            foreach ($item->produk_variant as $variant) {
                $harga = (int) round($variant->harga);
                $created = $variant->created_at ?? $item->created_at;

                if (!is_null($harga) && $created && Carbon::parse($created)->year == $selectedYear) {
                    $dataset[] = [$harga];
                    $produkMapping[] = [
                        'nama_produk' => $item->nama_produk . ' - ' . $variant->varian,
                        'harga' => $harga,
                        'created_at' => $created,
                    ];
                }
            }
        }

        if (count($dataset) < $cluster) {
            return back()->with('error', 'Jumlah data harga untuk tahun ' . $selectedYear . ' harus lebih banyak dari jumlah cluster.');
        }

        // -----------------------------
        // K-Means Clustering Manual
        // -----------------------------
        shuffle($dataset);
        $centroids = array_slice($dataset, 0, $cluster);
        $logIterasi = [];
        $iterasiAktual = 0;

        for ($iterasi = 1; $iterasi <= $maxIterasi; $iterasi++) {
            $clusters = array_fill(0, $cluster, []);
            $assignments = [];
            $jarakTiapData = [];

            foreach ($dataset as $i => $data) {
                $distances = array_map(fn($centroid) => abs($data[0] - $centroid[0]), $centroids);
                $minIndex = array_keys($distances, min($distances))[0];
                $clusters[$minIndex][] = $data;
                $assignments[] = $minIndex;

                $jarakTiapData[] = [
                    'nama_produk' => $produkMapping[$i]['nama_produk'],
                    'harga' => $data[0],
                    'distances' => $distances,
                    'cluster' => 'Cluster ' . ($minIndex + 1),
                ];
            }

            $logIterasi[] = [
                'iterasi' => $iterasi,
                'centroids' => $centroids,
                'assignments' => $assignments,
                'jarak_data' => $jarakTiapData
            ];

            $newCentroids = [];
            foreach ($clusters as $clusterPoints) {
                if (count($clusterPoints) === 0) {
                    $newCentroids[] = [$i];
                } else {
                    $sum = array_sum(array_column($clusterPoints, 0));
                    $newCentroids[] = [round($sum / count($clusterPoints), 4)];
                }
            }

            if ($newCentroids == $centroids) {
                $iterasiAktual = $iterasi;
                break;
            }

            $centroids = $newCentroids;
            $iterasiAktual = $iterasi;
        }

        $produkClustered = [];
        $euclideanTable = [];

        foreach ($produkMapping as $produk) {
            $distances = array_map(fn($centroid) => round(abs($produk['harga'] - $centroid[0]), 4), $centroids);
            $minIndex = array_keys($distances, min($distances))[0];

            $euclideanTable[] = [
                'nama_produk' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'distances' => $distances,
            ];

            $produkClustered[] = [
                'nama_produk' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'cluster' => 'Cluster ' . ($minIndex + 1),
                'distance' => $distances[$minIndex],
                'bulan' => Carbon::parse($produk['created_at'])->translatedFormat('F'),
                'bulan_index' => Carbon::parse($produk['created_at'])->format('n') - 1,
            ];
        }

        $labels = [];
        for ($i = 1; $i <= $cluster; $i++) {
            $labels[] = 'Cluster ' . $i;
        }

        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $clusterMonthly = [];
        foreach ($labels as $label) {
            $clusterMonthly[$label] = array_fill(0, 12, 0);
        }

        foreach ($produkClustered as $produk) {
            if (isset($clusterMonthly[$produk['cluster']])) {
                $clusterMonthly[$produk['cluster']][$produk['bulan_index']]++;
            }
        }

        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#8BC34A', '#00ACC1', '#F44336', '#9E9D24'
        ];

        return view('Operator.umkm.Laporan.KlasterisasiProduk.hasil', [
            'centroids' => $centroids,
            'euclideanTable' => $euclideanTable,
            'produkClustered' => $produkClustered,
            'labels' => $labels,
            'months' => $months,
            'colors' => $colors,
            'clusterMonthly' => $clusterMonthly,
            'year' => now()->year,
            'selectedYear' => $selectedYear,
            'maxIterasi' => $maxIterasi,
            'realIterasi' => $iterasiAktual,
            'logIterasi' => $logIterasi
        ]);
    }
}
