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
                        'produk_umkm_id' => $item->id,
                        'nama_produk' => $item->nama_produk . ' - ' . $variant->varian,
                        'harga' => $harga,
                        'created_at' => $created,
                    ];
            dd($produkMapping );

                }
            }
        }

        if (count($dataset) < $cluster) {
            return back()->with('error', 'Jumlah data harga untuk tahun ' . $selectedYear . ' harus lebih banyak dari jumlah cluster.');
        }

        // K-Means
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
        foreach ($produkMapping as $i => $produk) {
            $distances = array_map(fn($centroid) => round(abs($produk['harga'] - $centroid[0]), 4), $centroids);
            $minIndex = array_keys($distances, min($distances))[0];
            $produkClustered[] = [
                'produk_umkm_id' => $produk['produk_umkm_id'],
                'nama_produk' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'cluster' => 'Cluster ' . ($minIndex + 1),
                'cluster_index' => $minIndex,
                'distance' => $distances[$minIndex],
                'distances' => $distances,
            ];
        }

        // Perhitungan Silhouette Score
        $clusters = collect($produkClustered)->groupBy('cluster_index')->toArray();
        $silhouetteDetails = [];
        $silhouetteScores = [];

        foreach ($produkClustered as $item) {
            $ownCluster = $item['cluster_index'];
            $ownHarga = $item['harga'];
            $namaProduk = $item['nama_produk'];

            // a(i): rata-rata jarak ke klaster sendiri
            $intraDistances = [];
            foreach ($clusters[$ownCluster] as $other) {
                if ($other['nama_produk'] !== $namaProduk) {
                    $intraDistances[] = abs($ownHarga - $other['harga']);
                }
            }
            $a = count($intraDistances) ? round(array_sum($intraDistances) / count($intraDistances), 4) : 0;

            // b(i): jarak minimum ke klaster lain
            $bValues = [];
            foreach ($clusters as $clusterIndex => $points) {
                if ($clusterIndex == $ownCluster) continue;
                $distances = array_map(fn($p) => abs($ownHarga - $p['harga']), $points);
                if (count($distances)) {
                    $bValues[] = array_sum($distances) / count($distances);
                }
            }
            $b = count($bValues) ? round(min($bValues), 4) : 0;

            $s = ($a == 0 && $b == 0) ? 0 : round(($b - $a) / max($a, $b), 4);
            $silhouetteScores[] = $s;

            $silhouetteDetails[] = [
                'nama_produk' => $namaProduk,
                'cluster' => $ownCluster + 1,
                'a' => $a,
                'b' => $b,
                's' => $s
            ];
        }

        $avgSilhouette = count($silhouetteScores) ? round(array_sum($silhouetteScores) / count($silhouetteScores), 4) : 0;

        $labels = [];
        for ($i = 1; $i <= $cluster; $i++) {
            $labels[] = 'Cluster ' . $i;
        }

        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Mapping produk_umkm_id ke cluster
        $produkClusterMap = [];
        foreach ($produkClustered as $item) {
            $produkClusterMap[$item['produk_umkm_id']] = 'Cluster ' . ($item['cluster_index'] + 1);
        }

        // Ambil semua transaksi dan hitung klaster dominan
        $transaksiProduk = DB::table('transaksi_details as td')
            ->join('produk_variants as pv', 'td.produk_variant_id', '=', 'pv.id')
            ->join('transaksis as t', 'td.transaksi_id', '=', 't.id')
            ->whereYear('t.created_at', $selectedYear)
            ->select('t.id as transaksi_id', 'pv.produk_umkm_id', 't.created_at')
            ->get();

        $transaksiKlasterMap = [];

        foreach ($transaksiProduk->groupBy('transaksi_id') as $transaksi_id => $items) {
            $klasterHitung = [];
            $createdAt = $items[0]->created_at;

            foreach ($items as $item) {
                $produkId = $item->produk_umkm_id;
                if (isset($produkClusterMap[$produkId])) {
                    $klaster = $produkClusterMap[$produkId];
                    $klasterHitung[$klaster] = ($klasterHitung[$klaster] ?? 0) + 1;
                }
            }

            if (count($klasterHitung)) {
                arsort($klasterHitung);
                $dominantCluster = array_key_first($klasterHitung);
                $bulanIndex = Carbon::parse($createdAt)->format('n') - 1;
                $transaksiKlasterMap[] = [
                    'bulan' => $bulanIndex,
                    'cluster' => $dominantCluster
                ];
            }
        }

        $clusterMonthly = [];
        foreach ($labels as $label) {
            $clusterMonthly[$label] = array_fill(0, 12, 0);
        }

        foreach ($transaksiKlasterMap as $entry) {
            $clusterMonthly[$entry['cluster']][$entry['bulan']]++;
        }

        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#8BC34A', '#00ACC1', '#F44336', '#9E9D24'
        ];

        return view('Operator.umkm.Laporan.KlasterisasiProduk.hasil', [
            'centroids' => $centroids,
            'euclideanTable' => $produkClustered,
            'produkClustered' => $produkClustered,
            'labels' => $labels,
            'months' => $months,
            'colors' => $colors,
            'clusterMonthly' => $clusterMonthly,
            'year' => now()->year,
            'selectedYear' => $selectedYear,
            'maxIterasi' => $maxIterasi,
            'realIterasi' => $iterasiAktual,
            'logIterasi' => $logIterasi,
            'avgSilhouette' => $avgSilhouette,
            'silhouetteDetails' => $silhouetteDetails,
        ]);
    }
}
