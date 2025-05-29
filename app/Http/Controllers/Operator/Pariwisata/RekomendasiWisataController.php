<?php

namespace App\Http\Controllers\Operator\Pariwisata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pariwisata;

class RekomendasiWisataController extends Controller
{
    public function index(Request $request)
    {
        $inputHarga = $request->input('harga');
        $inputRating = $request->input('rating');
        $inputFasilitas = $request->input('fasilitas', []);
        $inputKategori = $request->input('kategori');

        $wisatas = Pariwisata::with('fasilitas')->get();

        // Cari nilai max/min untuk normalisasi
        $maxRating = $wisatas->max('rating') ?: 1; // Benefit
        $minHarga = $wisatas->min('harga_tiket') ?: 1; // Cost

        // Bobot
        $bobotHarga = $inputHarga ? 0.3 : 0;
        $bobotRating = $inputRating ? 0.3 : 0;
        $bobotKategori = $inputKategori ? 0.2 : 0;
        $bobotFasilitas = !empty($inputFasilitas) ? 0.2 : 0;

        $dataSaw = $wisatas->map(function ($wisata) use (
            $inputHarga, $inputRating, $inputFasilitas, $inputKategori,
            $minHarga, $maxRating,
            $bobotHarga, $bobotRating, $bobotKategori, $bobotFasilitas
        ) {
            $Vi = 0;

            // 1. Harga (COST) — Semakin kecil semakin baik
            if ($bobotHarga > 0) {
                $r_harga = $minHarga / max($wisata->harga_tiket, 1); // Hindari pembagian 0
                $Vi += $r_harga * $bobotHarga;
            }

            // 2. Rating (BENEFIT) — Semakin besar semakin baik
            if ($bobotRating > 0) {
                $r_rating = $wisata->rating / $maxRating;
                $Vi += $r_rating * $bobotRating;
            }

            // 3. Kategori (KESAMAAN) — Sama dengan pilihan user
            if ($bobotKategori > 0) {
                $r_kategori = $wisata->kategori == $inputKategori ? 1 : 0;
                $Vi += $r_kategori * $bobotKategori;
            }

            // 4. Fasilitas (KESAMAAN) — Persentase fasilitas yang cocok
            if ($bobotFasilitas > 0) {
                $fasilitasWisata = $wisata->fasilitas->pluck('id')->toArray();
                $intersect = array_intersect($inputFasilitas, $fasilitasWisata);
                $r_fasilitas = count($intersect) / count($inputFasilitas);
                $Vi += $r_fasilitas * $bobotFasilitas;
            }

            return [
                'wisata' => $wisata,
                'skor' => round($Vi, 4)
            ];
        });

        $sorted = $dataSaw->sortByDesc('skor')->values();

        return view('Operator.pariwisata.rekomendasi.index', [
            'data' => $sorted,
        ]);
    }
}
