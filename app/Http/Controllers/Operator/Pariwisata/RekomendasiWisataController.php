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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function step3Normalisasi(Request $request)
    {
        $allData = Pariwisata::with('fasilitas')->get();
        $dataPage = Pariwisata::with('fasilitas')->paginate(10)->withQueryString();

        $normalisasiMap = [];

        foreach ($allData as $item) {
            $durasi = 0;
            if ($item->jam_buka && $item->jam_tutup) {
                $durasi = Carbon::parse($item->jam_tutup)->diffInHours(Carbon::parse($item->jam_buka));
            }

            $fasilitasCount = $item->fasilitas->count();

            // Ambil skor diskrit (1–5)
            $skor = [
                'harga_tiket' => $this->getSkorDiskrit('harga_tiket', $item->harga_tiket),
                'fasilitas' => $this->getSkorDiskrit('fasilitas', $fasilitasCount),
                'rating' => $this->getSkorDiskrit('rating', $item->rating),
                'waktu_operasional' => $this->getSkorDiskrit('waktu_operasional', $durasi),
            ];

            $hasil = [];

            foreach ($skor as $kriteria => $nilaiDiskrit) {
                $normalisasi = round($nilaiDiskrit / 5, 4); // 1–5 jadi 0.2–1.0
                $hasil[$kriteria] = [
                    'nilai' => $normalisasi,
                    'rumus' => "$nilaiDiskrit / 5 = $normalisasi",
                ];

                SawNormalisasi::updateOrCreate(
                    ['pariwisata_id' => $item->id, 'kriteria' => $kriteria],
                    [
                        'nilai_normalisasi' => $normalisasi,
                        'rumus' => "$nilaiDiskrit / 5 = $normalisasi",
                    ],
                );
            }

            $normalisasiMap[$item->id] = $hasil;
        }

        return view('Operator.pariwisata.saw.step3_normalisasi', [
            'data' => $dataPage,
            'normalisasi' => collect($dataPage->items())->map(
                fn($w) => [
                    'wisata' => $w,
                    'normalisasi' => $normalisasiMap[$w->id] ?? [],
                ],
            ),
        ]);
    }

    private function getSkorDiskrit(string $kriteria, $value): int
    {
        return match ($kriteria) {
            'harga_tiket' => match (true) {
                $value <= 10000 => 5,
                $value <= 20000 => 4,
                $value <= 30000 => 3,
                $value <= 40000 => 2,
                default => 1,
            },
            'fasilitas' => match (true) {
                $value >= 5 => 5,
                $value === 4 => 4,
                $value === 3 => 3,
                $value === 2 => 2,
                default => 1,
            },
            'rating' => match (true) {
                $value >= 4.8 => 5,
                $value >= 4.0 => 4,
                $value >= 3.2 => 3,
                $value >= 2.5 => 2,
                default => 1,
            },

            'waktu_operasional' => match (true) {
                $value >= 24 => 5,
                $value >= 15 => 4,
                $value >= 10 => 3,
                $value >= 9 => 2,
                default => 1,
            },
            default => 1,
        };
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
            return back()->withErrors([
                'msg' => 'Total bobot harus sama dengan 1.0',
            ]);
        }

        foreach ($inputBobot as $kriteria => $nilai) {
            SawBobot::updateOrCreate(['kriteria' => $kriteria], ['bobot' => $nilai]);
        }

        return $request->has('simpan') ? back()->with('success', 'Bobot berhasil disimpan.') : redirect()->route('operator.pariwisata.rekomendasi.step5')->with('success', 'Bobot berhasil disimpan dan lanjut ke Step 5.');
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

        $allData = Pariwisata::with('fasilitas')->get();
        $skorMap = [];

        foreach ($allData as $item) {
            $durasi = 0;
            if ($item->jam_buka && $item->jam_tutup) {
                $durasi = Carbon::parse($item->jam_tutup)->diffInHours(Carbon::parse($item->jam_buka));
            }

            $fasilitasCount = $item->fasilitas->count();

            // Ambil skor diskrit dari helper
            $skorHarga = $this->getSkorDiskrit('harga_tiket', $item->harga_tiket);
            $skorFasilitas = $this->getSkorDiskrit('fasilitas', $fasilitasCount);
            $skorRating = $this->getSkorDiskrit('rating', $item->rating);
            $skorWaktu = $this->getSkorDiskrit('waktu_operasional', $durasi);

            $skorDiskrit = [
                'harga_tiket' => $skorHarga,
                'fasilitas' => $skorFasilitas,
                'rating' => $skorRating,
                'waktu_operasional' => $skorWaktu,
            ];

            $Vi = 0;
            $detail = [];

            foreach ($skorDiskrit as $kriteria => $skor) {
                $w = $bobot[$kriteria] ?? 0;
                $normalisasi = round($skor / 5, 4);
                $hasil = round($normalisasi * $w, 4);
                $Vi += $hasil;

                $detail[$kriteria] = [
                    'skor_diskrit' => $skor,
                    'normalisasi' => $normalisasi,
                    'bobot' => $w,
                    'perkalian' => "{$normalisasi} × {$w}",
                    'hasil' => $hasil,
                ];
            }

            SawSkor::updateOrCreate(
                ['pariwisata_id' => $item->id],
                [
                    'skor_total' => round($Vi, 4),
                ],
            );

            $skorMap[$item->id] = [
                'skor' => round($Vi, 4),
                'detail' => $detail,
            ];
        }

        $dataPage = Pariwisata::with('fasilitas')->paginate(10)->withQueryString();

        $skorData = collect($dataPage->items())->map(
            fn($item) => [
                'wisata' => $item,
                'skor' => $skorMap[$item->id]['skor'] ?? 0,
                'detail' => $skorMap[$item->id]['detail'] ?? [],
            ],
        );

        return view('Operator.pariwisata.saw.step5_skor', [
            'skorData' => $skorData,
            'data' => $dataPage,
        ]);
    }

    // STEP 6: Ranking
    public function step6Ranking()
    {
        if (SawBobot::count() < 4) {
            return redirect()
                ->route('operator.pariwisata.rekomendasi.step4')
                ->withErrors(['msg' => 'Silakan isi semua bobot kriteria terlebih dahulu di Step 4.']);
        }

        $skorList = SawSkor::with('pariwisata')->orderByDesc('skor_total')->get();

        DB::transaction(function () use ($skorList) {
            foreach ($skorList as $index => $skor) {
                SawRanking::updateOrCreate(
                    ['pariwisata_id' => $skor->pariwisata_id],
                    [
                        'peringkat' => $index + 1,
                        'skor_total' => $skor->skor_total,
                    ],
                );
            }

            $aktifIds = $skorList->pluck('pariwisata_id');
            SawRanking::whereNotIn('pariwisata_id', $aktifIds)->delete();
        });

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

        // Ambil data hasil filter preferensi user
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

        // Ambil bobot
        $bobot = SawBobot::pluck('bobot', 'kriteria')->toArray();

        if (count($bobot) < SawKriteria::count()) {
            return redirect()
                ->route('operator.pariwisata.rekomendasi.step4')
                ->withErrors(['msg' => 'Bobot belum lengkap. Silakan isi di Step 4.']);
        }

        // Ambil nilai acuan dari SELURUH data dalam kategori
        $kategori = $request->kategori;

        // Perhatikan: get() untuk bisa menghitung fasilitas_count
        $kategoriData = Pariwisata::withCount('fasilitas')->when($kategori, fn($q) => $q->where('kategori', $kategori))->get();

        $minHarga = max([$kategoriData->min('harga_tiket') ?? 1, 1]);
        $maxRating = max([$kategoriData->max('rating') ?? 1, 1]);
        $maxFasilitas = max([$kategoriData->max('fasilitas_count') ?? 1, 1]);
        $maxSkorWaktu = 5;

        // Proses perhitungan SAW
        $result = $data
            ->map(function ($item) use ($minHarga, $maxRating, $maxFasilitas, $bobot, $maxSkorWaktu) {
                $durasi = 0;
                if ($item->jam_buka && $item->jam_tutup) {
                    $durasi = Carbon::parse($item->jam_buka)->diffInHours(Carbon::parse($item->jam_tutup));
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
                    'rating' => round($item->rating / max($maxRating, 1), 4),
                    'fasilitas' => round($item->fasilitas_count / max($maxFasilitas, 1), 4),
                    'waktu_operasional' => round($skorWaktu / $maxSkorWaktu, 4),
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

        return view('Operator.pariwisata.rekomendasi.result', compact('result', 'minHarga', 'maxRating', 'maxFasilitas', 'maxSkorWaktu', 'kategori'));
    }
}
