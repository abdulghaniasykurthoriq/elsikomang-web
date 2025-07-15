<?php

namespace App\Http\Controllers\Operator\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProdukUmkm;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        // Ambil daftar produk_umkm_id dan cluster-nya
        $produkClusterMap = collect($produkClustered)->groupBy('cluster')->map(function ($items) {
            return $items->map(function ($i) {
                // Pisahkan nama_produk dari nama dan varian
                $namaProduk = explode(' - ', $i['nama_produk'])[0];
                return $namaProduk;
            })->unique()->values();
        });

        // Ambil produk_umkm_id berdasarkan nama
        $produkIdMap = [];
        foreach ($produkClusterMap as $cluster => $namaProduks) {
            $ids = ProdukUmkm::whereIn('nama_produk', $namaProduks)->pluck('id')->all();
            $produkIdMap[$cluster] = $ids;
        }

        // Siapkan data kosong
        $clusterMonthly = [];
        foreach ($labels as $label) {
            $clusterMonthly[$label] = array_fill(0, 12, 0);
        }

        // Hitung transaksi tiap bulan berdasarkan klaster
        foreach ($produkIdMap as $cluster => $produkIds) {
            $transaksi = DB::table('transaksi_details as td')
                ->join('produk_variants as pv', 'td.produk_variant_id', '=', 'pv.id')
                ->join('transaksis as t', 'td.transaksi_id', '=', 't.id')
                ->whereIn('pv.produk_umkm_id', $produkIds)
                ->whereYear('t.created_at', $selectedYear)
                ->select(
                    DB::raw('MONTH(t.created_at) as bulan'),
                    DB::raw('COUNT(DISTINCT t.id) as total')
                )
                ->groupBy('bulan')
                ->get();

            foreach ($transaksi as $item) {
                $clusterMonthly[$cluster][$item->bulan - 1] = $item->total;
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
