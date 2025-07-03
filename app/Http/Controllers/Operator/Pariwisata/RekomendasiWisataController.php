<?php

namespace App\Http\Controllers\Operator\Pariwisata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pariwisata;
use App\Models\SawKriteria;
use App\Models\SawNormalisasi;
use App\Models\SawBobot;
use App\Models\SawSkor;
use App\Models\SawRanking;
use Carbon\Carbon;

class RekomendasiWisataController extends Controller
{
    // STEP 1: Menampilkan data wisata (alternatif)
    public function step1Data()
    {
        $data = Pariwisata::with('fasilitas')->paginate(10);
        return view('Operator.pariwisata.saw.step1_data', compact('data'));
    }

    // STEP 2: Menampilkan jenis kriteria
    public function step2Kriteria()
    {
        $kriterias = SawKriteria::all();
        return view('Operator.pariwisata.saw.step2_kriteria', compact('kriterias'));
    }

    public function updateKriteria(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'tipe' => 'required|in:cost,benefit',
        ]);

        $kriteria = SawKriteria::findOrFail($id);
        $kriteria->update([
            'label' => $request->label,
            'tipe' => $request->tipe,
        ]);

        return redirect()->back()->with('success', 'Kriteria berhasil diperbarui.');
    }

    // STEP 3: Normalisasi
    public function step3Normalisasi()
    {
        $data = Pariwisata::with('fasilitas')->paginate(10);

        $minHarga = max($data->min('harga_tiket'), 1);
        $maxRating = max($data->max('rating'), 1);
        $maxFasilitas = max(1, $data->map(fn($d) => $d->fasilitas->count())->max());

        $normalisasi = [];

        foreach ($data as $item) {
            $durasi = 0;
            if ($item->jam_buka && $item->jam_tutup) {
                $durasi = Carbon::parse($item->jam_tutup)->diffInHours(Carbon::parse($item->jam_buka));
            }

            $skor_waktu = match (true) {
                $durasi >= 24 => 5,
                $durasi >= 15 => 4,
                $durasi >= 10 => 3,
                $durasi >= 9 => 2,
                default => 1,
            };

            $fasilitasCount = $item->fasilitas->count();

            $hasil = [
                'harga_tiket' => [
                    'nilai' => round($minHarga / max($item->harga_tiket, 1), 4),
                    'rumus' => "{$minHarga} / " . max($item->harga_tiket, 1),
                ],
                'fasilitas' => [
                    'nilai' => round($fasilitasCount / $maxFasilitas, 4),
                    'rumus' => "{$fasilitasCount} / {$maxFasilitas}",
                ],
                'rating' => [
                    'nilai' => round($item->rating / $maxRating, 4),
                    'rumus' => "{$item->rating} / {$maxRating}",
                ],
                'waktu_operasional' => [
                    'nilai' => round($skor_waktu / 5, 4),
                    'rumus' => "{$skor_waktu} / 5",
                ],
            ];

            foreach ($hasil as $kriteria => $dataHasil) {
                SawNormalisasi::updateOrCreate(
                    [
                        'pariwisata_id' => $item->id,
                        'kriteria' => $kriteria,
                    ],
                    [
                        'nilai_normalisasi' => $dataHasil['nilai'],
                        'rumus' => $dataHasil['rumus'],
                    ],
                );
            }

            $normalisasi[] = [
                'wisata' => $item,
                'normalisasi' => $hasil,
            ];
        }

        return view('Operator.pariwisata.saw.step3_normalisasi', [
            'data' => $data,
            'normalisasi' => $normalisasi,
        ]);
    }

    // STEP 4: Bobot
    public function step4Bobot()
    {
        $kriterias = SawKriteria::all();

        $bobots = SawBobot::pluck('bobot', 'kriteria')->toArray();

        return view('Operator.pariwisata.saw.step4_bobot', compact('kriterias', 'bobots'));
    }

    public function saveBobot(Request $request)
    {
        $inputBobot = $request->only(['harga_tiket', 'fasilitas', 'rating', 'waktu_operasional']);
        $total = array_sum($inputBobot);

        if (abs($total - 1.0) > 0.001) {
            return back()->withErrors(['msg' => 'Total bobot harus sama dengan 1.0']);
        }

        foreach ($inputBobot as $kriteria => $nilaiBobot) {
            SawBobot::create([
                'kriteria' => $kriteria,
                'bobot' => $nilaiBobot,
            ]);
        }

        if ($request->has('simpan')) {
            return back()->with('success', 'Bobot berhasil disimpan.');
        }

        return redirect()->route('operator.pariwisata.rekomendasi.step5')->with('success', 'Bobot berhasil disimpan dan lanjut ke Step 5.');
    }

    // STEP 5: Skor
    public function step5Skor()
    {
        $bobot = SawBobot::pluck('bobot', 'kriteria')->toArray();

        if (count($bobot) < 4) {
            return redirect()
                ->route('operator.pariwisata.rekomendasi.step4')
                ->withErrors(['msg' => 'Silakan isi semua bobot kriteria terlebih dahulu di Step 4.']);
        }

        $data = Pariwisata::withCount('fasilitas')->paginate(10);

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

            SawSkor::updateOrCreate(['pariwisata_id' => $item->id], ['skor_total' => round($Vi, 4)]);

            return [
                'wisata' => $item,
                'skor' => round($Vi, 4),
                'detail' => $detail,
            ];
        });

        return view('Operator.pariwisata.saw.step5_skor', [
            'skorData' => $skorData,
            'data' => $data->withQueryString(),
        ]);
    }

    // STEP 6: Ranking
    public function step6Ranking()
    {
        if (SawBobot::count() < 4) {
            return redirect()
                ->route('operator.pariwisata.rekomendasi.step4')
                ->withErrors(['msg' => 'Silakan isi semua bobot kriteria terlebih dahulu di Step 4.']);
        }

        $skorList = SawSkor::with('pariwisata')->orderByDesc('skor_total')->get();

        SawRanking::truncate();

        foreach ($skorList as $index => $skor) {
            SawRanking::create([
                'pariwisata_id' => $skor->pariwisata_id,
                'peringkat' => $index + 1,
                'skor_total' => $skor->skor_total,
            ]);
        }

        $ranking = SawRanking::with('pariwisata')->orderBy('peringkat')->paginate(10)->withQueryString();

        return view('Operator.pariwisata.saw.step6_ranking', compact('ranking'));
    }

    public function inputPreferensi()
    {
        return view('Operator.pariwisata.rekomendasi.input');
    }

    public function hitungRekomendasi(Request $request)
    {
        $validated = $request->validate([
            'max_tiket' => 'nullable|numeric',
            'min_fasilitas' => 'nullable|numeric',
            'min_rating' => 'nullable|numeric',
            'kategori' => 'nullable|string',
        ]);

        $query = Pariwisata::withCount('fasilitas');

        if ($request->max_tiket) {
            $query->where('harga_tiket', '<=', $request->max_tiket);
        }

        if ($request->min_rating) {
            $query->where('rating', '>=', $request->min_rating);
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return back()->withInput()->with('warning', 'Tidak ditemukan wisata dengan kriteria tersebut.');
        }

        // Ambil bobot dari Step 4 (TABEL)
        $bobot = SawBobot::pluck('bobot', 'kriteria')->toArray();

        if (count($bobot) < 4) {
            return redirect()
                ->route('operator.pariwisata.rekomendasi.step4')
                ->withErrors(['msg' => 'Bobot belum lengkap. Silakan isi di Step 4.']);
        }

        // Cari nilai normalisasi max/min
        $minHarga = max([$data->min('harga_tiket') ?? 1, 1]);
        $maxRating = max([$data->max('rating') ?? 1, 1]);
        $maxFasilitas = max([$data->max('fasilitas_count') ?? 1, 1]);

        // Hitung normalisasi dan skor per item
        $result = $data
            ->map(function ($item) use ($minHarga, $maxRating, $maxFasilitas, $bobot) {
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

                $normalisasi = [
                    'harga_tiket' => round($minHarga / max($item->harga_tiket, 1), 4),
                    'fasilitas' => round($item->fasilitas_count / max($maxFasilitas, 1), 4),
                    'rating' => round($item->rating / max($maxRating, 1), 4),
                    'waktu_operasional' => round($skorWaktu / 5, 4),
                ];

                $detail = [];
                $Vi = 0;

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
            })
            ->sortByDesc('skor')
            ->values();

        return view('Operator.pariwisata.rekomendasi.result', compact('result'));
    }
}
