<?php

namespace App\Http\Controllers\Operator\Umkm;


use App\Http\Controllers\Controller;
use App\Models\ProdukUmkm;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Phpml\Clustering\KMeans;

class LaporanKlasterProdukController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('tahun', now()->year);
        $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                   7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];

        $produkList = ProdukUmkm::all();
        $produkTransaksi = [];
        $produkNama = [];

        // Ambil jumlah transaksi per bulan
        foreach ($produkList as $produk) {
            $query = DB::table('transaksi_details')
                ->selectRaw('MONTH(created_at) as bulan, SUM(qty) as total_qty')
                ->where('produk_id', $produk->id)
                ->whereYear('created_at', $year)
                ->groupByRaw('MONTH(created_at)')
                ->get();

            $transaksi = array_fill(1, 12, 0);
            foreach ($query as $row) {
                $transaksi[$row->bulan] = (int) $row->total_qty;
            }

            $produkTransaksi[$produk->id] = array_values($transaksi);
            $produkNama[$produk->id] = $produk->nama_produk;
        }

        // Klasterisasi
        $samples = array_values($produkTransaksi);
        $kmeans = new KMeans(3);
        $clusters = $kmeans->cluster($samples);

        $labels = ['Murah', 'Sedang', 'Mahal'];
        $colors = ['#3b82f6', '#ef4444', '#22c55e'];

        $clusterMonthly = [];
        foreach ($labels as $label) {
            for ($i = 1; $i <= 12; $i++) {
                $clusterMonthly[$label][$i] = 0;
            }
        }

        foreach ($clusters as $index => $produkCluster) {
            $label = $labels[$index];
            foreach ($produkCluster as $produkData) {
                foreach ($produkTransaksi as $id => $data) {
                    if ($data === $produkData) {
                        for ($i = 1; $i <= 12; $i++) {
                            $clusterMonthly[$label][$i] += $data[$i - 1];
                        }
                        break;
                    }
                }
            }
        }

        return view('Operator.umkm.Laporan.KlasterisasiProduk.index', [
            'year' => $year,
            'months' => array_values($months),
            'clusterMonthly' => $clusterMonthly,
            'labels' => $labels,
            'colors' => $colors,
        ]);
    }
}
