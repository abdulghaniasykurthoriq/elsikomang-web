@extends('layouts.app2')

@section('title', 'Rekomendasi Wisata')

@section('content')
    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Rekomendasi Wisata</h1>
    </div>

    <div class="px-6 -mt-24 relative z-10 mx-2">
        <div class="bg-white rounded-xl shadow-xl p-6">

            <!-- Form Preferensi -->
            <form action="{{ route('operator.pariwisata.rekomendasi', ['jenis' => request()->route('jenis')]) }}"
                method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Harga Tiket</label>
                    <select name="harga" class="form-select mt-1 w-full">
                        <option value="">Semua</option>
                        <option value="murah" {{ request('harga') == 'murah' ? 'selected' : '' }}>Murah</option>
                        <option value="sedang" {{ request('harga') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="mahal" {{ request('harga') == 'mahal' ? 'selected' : '' }}>Mahal</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Minimal Rating</label>
                    <select name="rating" class="form-select mt-1 w-full">
                        <option value="">Semua</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                {{ $i }}+</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kategori / Minat Wisata</label>
                    <select name="kategori" class="form-select mt-1 w-full">
                        <option value="">Semua</option>
                        @foreach (['pantai', 'hutan', 'religi', 'budaya', 'kuliner', 'edukasi'] as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                {{ ucfirst($kategori) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fasilitas</label>
                    <div class="grid grid-cols-2 gap-1">
                        @foreach (\App\Models\Fasilitas::all() as $fasilitas)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="fasilitas[]" value="{{ $fasilitas->id }}"
                                    {{ is_array(request('fasilitas')) && in_array($fasilitas->id, request('fasilitas')) ? 'checked' : '' }}
                                    class="form-checkbox text-indigo-600">
                                <span class="ml-2 text-sm">{{ ucfirst($fasilitas->nama) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="md:col-span-2 flex justify-end pt-2">
                    <button type="submit" class="btn bg-indigo-600 text-white hover:bg-indigo-700">Cari
                        Rekomendasi</button>
                </div>
            </form>

            <!-- Hasil Rekomendasi -->
            <h2 class="text-lg font-semibold mb-4">Hasil Rekomendasi</h2>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($data as $item)
                    <div class="border rounded-lg p-4 shadow hover:shadow-md transition">
                        <h3 class="text-md font-bold mb-1">{{ $item['wisata']->nama }}</h3>
                        <p class="text-sm text-gray-500 mb-1">
                            Kategori: <strong>{{ ucfirst($item['wisata']->kategori) }}</strong> |
                            Rating: {{ $item['wisata']->rating }} |
                            Harga: Rp{{ number_format($item['wisata']->harga_tiket) }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Fasilitas Tersedia:
                            <span class="text-gray-700">
                                {{ implode(', ', $item['wisata']->fasilitas->pluck('nama')->toArray()) }}
                            </span>
                        </p>

                        <div class="mt-2 text-sm text-gray-600">
                            <p><strong>Nilai SAW:</strong></p>
                            <ul class="ml-4 list-disc text-xs">
                                @if (request('harga'))
                                    <li>Harga Tiket: Bobot 0.3</li>
                                @endif
                                @if (request('rating'))
                                    <li>Rating: Bobot 0.3</li>
                                @endif
                                @if (request('kategori'))
                                    <li>Kategori: Bobot 0.2</li>
                                @endif
                                @if (!empty(request('fasilitas')))
                                    <li>Fasilitas: Bobot 0.2</li>
                                @endif
                            </ul>
                        </div>

                        <p class="text-sm mt-2 text-indigo-600">
                            Skor Rekomendasi (Vi): <strong>{{ $item['skor'] }}</strong>
                        </p>
                        
                    </div>

                @empty
                    <p class="text-gray-500">Tidak ada rekomendasi ditemukan berdasarkan preferensi Anda.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
