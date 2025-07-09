@extends('layouts.app2')

@section('title', 'Step 1: Data Alternatif Wisata')

@section('content')

    <!-- Header Section -->
    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Step 1: Data Alternatif Wisata</h1>
        <a href="{{ route('operator.pariwisata.rekomendasi.step2') }}"
            class="btn bg-white text-indigo-700 hover:bg-indigo-50 shadow font-semibold">
            Lanjut ke Step 2
        </a>
    </div>

    <!-- Table Section -->
    <div class="px-6 -mt-24 relative z-10 mx-2">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
            <div class="p-4 border-b border-gray-100 font-semibold">
                <div class="flex justify-between items-center">
                    <span>Total: {{ $data->total() }} alternatif wisata</span>
                    <span>Halaman: {{ $data->currentPage() }} dari {{ $data->lastPage() }}</span>
                </div>

            </div>

            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Harga Tiket</th>
                            <th class="px-6 py-3">Rating</th>
                            <th class="px-6 py-3">Jam Operasional</th>
                            <th class="px-6 py-3">Fasilitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($data as $wisata)
                            <tr>
                                <td class="px-6 py-4 font-semibold">{{ $wisata->nama }}</td>
                                <td class="px-6 py-4 capitalize">{{ $wisata->kategori }}</td>
                                <td class="px-6 py-4">Rp{{ number_format($wisata->harga_tiket) }}</td>
                                <td class="px-6 py-4">{{ $wisata->rating ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    {{ $wisata->jam_buka ? \Carbon\Carbon::parse($wisata->jam_buka)->format('H:i') : '-' }}
                                    -
                                    {{ $wisata->jam_tutup ? \Carbon\Carbon::parse($wisata->jam_tutup)->format('H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($wisata->fasilitas->isNotEmpty())
                                        <ul class="list-disc ml-5">
                                            @foreach ($wisata->fasilitas as $f)
                                                <li>{{ $f->nama }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-400 italic">Tidak ada</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada data alternatif wisata.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                    {{ $data->links('components.pagination') }}
                </div>
                
            </div>
        </div>
    </div>

@endsection
