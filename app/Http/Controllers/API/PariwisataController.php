<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pariwisata;
use App\Models\PariwisataRating;
use App\Models\SawBobot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PariwisataController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->query('search');
        $perPage = (int) $request->query('per_page', 10);

        $query = Pariwisata::with('fasilitas');

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        return response()->json($query->paginate($perPage));
    }

    // public function rekomendasi(Request $request)
    // {
    //     $inputHarga = $request->input('harga');
    //     $inputRating = $request->input('rating');
    //     $inputFasilitas = $request->input('fasilitas', []);
    //     $inputKategori = $request->input('kategori');



    //     $wisatas = Pariwisata::with('fasilitas')->get();

    //     // Cari nilai max/min untuk normalisasi
    //     $maxRating = $wisatas->max('rating') ?: 1; // Benefit
    //     $minHarga = $wisatas->min('harga_tiket') ?: 1; // Cost

    //     // Bobot
    //     $bobotHarga = $inputHarga ? 0.3 : 0;
    //     $bobotRating = $inputRating ? 0.3 : 0;
    //     $bobotKategori = $inputKategori ? 0.2 : 0;
    //     $bobotFasilitas = !empty($inputFasilitas) ? 0.2 : 0;

    //     $dataSaw = $wisatas->map(function ($wisata) use (
    //         $inputHarga, $inputRating, $inputFasilitas, $inputKategori,
    //         $minHarga, $maxRating,
    //         $bobotHarga, $bobotRating, $bobotKategori, $bobotFasilitas
    //     ) {
    //         $Vi = 0;

    //         // 1. Harga (COST) — Semakin kecil semakin baik
    //         if ($bobotHarga > 0) {
    //             $r_harga = $minHarga / max($wisata->harga_tiket, 1); // Hindari pembagian 0
    //             $Vi += $r_harga * $bobotHarga;
    //         }

    //         // 2. Rating (BENEFIT) — Semakin besar semakin baik
    //         if ($bobotRating > 0) {
    //             $r_rating = $wisata->rating / $maxRating;
    //             $Vi += $r_rating * $bobotRating;
    //         }

    //         // 3. Kategori (KESAMAAN) — Sama dengan pilihan user
    //         if ($bobotKategori > 0) {
    //             $r_kategori = $wisata->kategori == $inputKategori ? 1 : 0;
    //             $Vi += $r_kategori * $bobotKategori;
    //         }

    //         // 4. Fasilitas (KESAMAAN) — Persentase fasilitas yang cocok
    //         if ($bobotFasilitas > 0) {
    //             $fasilitasWisata = $wisata->fasilitas->pluck('id')->toArray();
    //             $intersect = array_intersect($inputFasilitas, $fasilitasWisata);
    //             $r_fasilitas = count($intersect) / count($inputFasilitas);
    //             $Vi += $r_fasilitas * $bobotFasilitas;
    //         }

    //         return [
    //             'wisata' => $wisata,
    //             'skor' => round($Vi, 4)
    //         ];
    //     });

    //     $sorted = $dataSaw->sortByDesc('skor')->values()->take(6);
    //     return response()->json([
    //         'message' => 'Rekomendasi wisata berhasil diambil',
    //         'data' =>  $sorted
    //     ]);
    // }
    public function rekomendasi(Request $request)
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
        return response()->json([
            'status' => 'warning',
            'message' => 'Tidak ditemukan wisata dengan kriteria tersebut.',
        ], 404);
    }

    $bobot = SawBobot::pluck('bobot', 'kriteria')->toArray();

    if (count($bobot) < 4) {
        return response()->json([
            'status' => 'error',
            'message' => 'Bobot belum lengkap. Silakan isi di Step 4.',
        ], 422);
    }

    $minHarga = max([$data->min('harga_tiket') ?? 1, 1]);
    $maxRating = max([$data->max('rating') ?? 1, 1]);
    $maxFasilitas = max([$data->max('fasilitas_count') ?? 1, 1]);

    $result = $data->map(function ($item) use ($minHarga, $maxRating, $maxFasilitas, $bobot) {
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
    })->sortByDesc('skor')->values();

    return response()->json([
        'status' => 'success',
        'message' => 'Berhasil menghitung rekomendasi',
        'data' => $result,
    ]);
}


    public function show($id)
    {
        $pariwisata = Pariwisata::with('fasilitas')->findOrFail($id);
        return response()->json([
                'message' => 'Detail data pariwisata',
                'data' => $pariwisata
                ]); 
    }

    public function rate(Request $request)
{
    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'message' => 'User belum login atau token tidak valid.'
        ], 401);
    }

    $validated = $request->validate([
        'pariwisata_id' => 'required|exists:pariwisatas,id',
        'rating' => 'required|numeric|min:1|max:5',
    ]);

    try {
        // Cek apakah user sudah memberikan rating sebelumnya
        $existingRating = PariwisataRating::where('user_id', $user->id)
                            ->where('pariwisata_id', $validated['pariwisata_id'])
                            ->first();

        if ($existingRating) {
            $existingRating->update([
                'rating' => $validated['rating']
            ]);

            return response()->json([
                'message' => 'Rating berhasil diperbarui.',
                'data' => $existingRating
            ], 200);
        }

        // Tambahkan user_id ke data yang divalidasi
        $validated['user_id'] = $user->id;

        $rating = PariwisataRating::create($validated);

        return response()->json([
            'message' => 'Rating berhasil ditambahkan.',
            'data' => $rating
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat menyimpan rating.',
            'error' => $e->getMessage()
        ], 500);
    }
}



}
