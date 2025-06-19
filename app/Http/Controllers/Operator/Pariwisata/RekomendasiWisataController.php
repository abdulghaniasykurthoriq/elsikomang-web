<?php

namespace App\Http\Controllers\Operator\Pariwisata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pariwisata;
use Carbon\Carbon;

class RekomendasiWisataController extends Controller
{
    // STEP 1: Menampilkan data wisata (alternatif)
    public function step1Data()
    {
        $data = Pariwisata::with('fasilitas')->get();
        return view('Operator.pariwisata.saw.step1_data', compact('data'));
    }

    // STEP 2: Menampilkan jenis kriteria
    public function step2Kriteria()
    {
        $kriteria = [['nama' => 'harga_tiket', 'label' => 'Harga Tiket', 'tipe' => 'cost'], ['nama' => 'fasilitas', 'label' => 'Fasilitas (Jumlah)', 'tipe' => 'benefit'], ['nama' => 'rating', 'label' => 'Rating', 'tipe' => 'benefit'], ['nama' => 'waktu_operasional', 'label' => 'Jam Operasional (Durasi)', 'tipe' => 'benefit']];

        return view('Operator.pariwisata.saw.step2_kriteria', compact('kriteria'));
    }

    // STEP 3: Normalisasi
    public function step3Normalisasi()
    {
        $data = Pariwisata::with('fasilitas')->get();

        // Ambil nilai minimum dan maksimum untuk normalisasi
        $minHarga = max($data->min('harga_tiket'), 1);
        $maxRating = max($data->max('rating'), 1);
        $maxFasilitas = max(1, $data->map(fn($d) => $d->fasilitas->count())->max());

        $normalisasi = $data->map(function ($item) use ($minHarga, $maxRating, $maxFasilitas) {
            // Hitung durasi operasional
            $durasi = 0;
            if ($item->jam_buka && $item->jam_tutup) {
                $durasi = Carbon::parse($item->jam_tutup)->diffInHours(Carbon::parse($item->jam_buka));
            }

            // Skor waktu berdasarkan range jam buka-tutup
            $skor_waktu = match (true) {
                $durasi >= 24 => 5,
                $durasi >= 15 => 4,
                $durasi >= 10 => 3,
                $durasi >= 9 => 2,
                default => 1,
            };

            $fasilitasCount = $item->fasilitas->count();

            return [
                'wisata' => $item,
                'normalisasi' => [
                    'harga_tiket' => [
                        'rumus' => "{$minHarga} / " . max($item->harga_tiket, 1),
                        'hasil' => round($minHarga / max($item->harga_tiket, 1), 4),
                    ],
                    'fasilitas' => [
                        'rumus' => "{$fasilitasCount} / {$maxFasilitas}",
                        'hasil' => round($fasilitasCount / $maxFasilitas, 4),
                    ],
                    'rating' => [
                        'rumus' => "{$item->rating} / {$maxRating}",
                        'hasil' => round($item->rating / $maxRating, 4),
                    ],
                    'waktu_operasional' => [
                        'rumus' => "{$skor_waktu} / 5",
                        'hasil' => round($skor_waktu / 5, 4),
                    ],
                ],
            ];
        });

        return view('Operator.pariwisata.saw.step3_normalisasi', compact('normalisasi'));
    }

    public function step4Bobot()
    {
        $defaultBobot = [
            'harga_tiket' => 0.25,
            'fasilitas' => 0.25,
            'rating' => 0.25,
            'waktu_operasional' => 0.25,
        ];

        return view('Operator.pariwisata.saw.step4_bobot', compact('defaultBobot'));
    }

    public function saveBobot(Request $request)
    {
        $bobot = $request->only(['harga_tiket', 'fasilitas', 'rating', 'waktu_operasional']);
        $total = array_sum($bobot);

        if (abs($total - 1.0) > 0.001) {
            return back()->withErrors(['msg' => 'Total bobot harus sama dengan 1.0']);
        }

        session(['saw_bobot' => $bobot]);
        return redirect()->route('operator.pariwisata.rekomendasi.step5');
    }

    public function step5Skor()
    {
        $data = Pariwisata::withCount('fasilitas')->get();

        $bobot = session('saw_bobot', [
            'harga_tiket' => 0.25,
            'fasilitas' => 0.25,
            'rating' => 0.25,
            'waktu_operasional' => 0.25,
        ]);

        $minHarga = max($data->min('harga_tiket'), 1);
        $maxFasilitas = max(array_map('intval', $data->pluck('fasilitas_count')->all()) ?: [1]);
        $maxRating = max($data->max('rating'), 1);

        $skorData = $data->map(function ($item) use ($minHarga, $maxFasilitas, $maxRating, $bobot) {
            $durasi = 0;
            if ($item->jam_buka && $item->jam_tutup) {
                $durasi = Carbon::parse($item->jam_tutup)->diffInHours(Carbon::parse($item->jam_buka));
            }

            $skorWaktu = match (true) {
                $durasi >= 24 => 5,
                $durasi >= 15 => 4,
                $durasi >= 10 => 3,
                $durasi >= 9 => 2,
                default => 1,
            };

            // Hitung nilai normalisasi
            $normalisasi = [
                'harga_tiket' => round($minHarga / max($item->harga_tiket, 1), 4),
                'fasilitas' => round($item->fasilitas_count / max($maxFasilitas, 1), 4),
                'rating' => round($item->rating / max($maxRating, 1), 4),
                'waktu_operasional' => round($skorWaktu / 5, 4),
            ];

            $Vi = 0;
            $detail = [];

            foreach ($normalisasi as $kriteria => $nilai) {
                $bobotK = $bobot[$kriteria] ?? 0;
                $hasil = round($nilai * $bobotK, 4);
                $Vi += $hasil;

                $detail[$kriteria] = [
                    'normalisasi' => $nilai,
                    'bobot' => $bobotK,
                    'perkalian' => "{$nilai} × {$bobotK}",
                    'hasil' => $hasil,
                ];
            }

            return [
                'wisata' => $item,
                'skor' => round($Vi, 4),
                'detail' => $detail,
            ];
        });

        return view('Operator.pariwisata.saw.step5_skor', compact('skorData'));
    }

    public function step6Ranking()
{
    if (!session()->has('saw_bobot')) {
        return redirect()->route('operator.pariwisata.rekomendasi.step4')
            ->withErrors(['msg' => 'Silakan isi bobot terlebih dahulu.']);
    }

    $data = $this->step5Skor()->getData()['skorData'];
    $sorted = collect($data)->sortByDesc('skor')->values();

    return view('Operator.pariwisata.saw.step6_ranking', [
        'ranking' => $sorted,
    ]);
}

    public function inputPreferensi()
    {
        return view('Operator.pariwisata.rekomendasi.input');
    }

    public function hitungRekomendasi(Request $request)
    {
        // validasi inputan
        $validated = $request->validate([
            'max_jarak' => 'nullable|numeric',
            'max_tiket' => 'nullable|numeric',
            'min_fasilitas' => 'nullable|numeric',
            'min_rating' => 'nullable|numeric',
            'kategori' => 'nullable|string',
        ]);

        // filter pariwisata
        $query = Pariwisata::with('fasilitas');

        if ($request->max_jarak) {
            $query->where('jarak_km', '<=', $request->max_jarak);
        }

        if ($request->max_tiket) {
            $query->where('harga_tiket', '<=', $request->max_tiket);
        }

        if ($request->min_rating) {
            $query->where('rating', '>=', $request->min_rating);
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        $filtered = $query->get();

        // selanjutnya: normalisasi dan hitung skor (re-use dari step 3–6)
        return view('Operator.pariwisata.rekomendasi.result', compact('filtered'));
    }
}
