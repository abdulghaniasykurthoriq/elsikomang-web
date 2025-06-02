@extends('layouts.app2')
@section('title', 'Data Produk UMKM')
@section('content')

<div class=" bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Data Produk UMKM</h1>

    {{-- ✅ Tambahkan parameter "jenis" agar route tidak error --}}
    <a href="{{ route('produk_umkm.create') }}" class="btn bg-white text-gray-800">Tambah Produk UMKM</a>
</div>

<div class="mx-2 px-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
        <div class="p-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Produk UMKM</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Nama Toko</th>
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Varian, Harga & Stok</th>
                        <th class="px-6 py-3">Foto Produk</th>
                        <th colspan="2" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($produk_umkm as $index => $item)
                        <tr>
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $item->member->nama_toko ?? 'Toko tidak ditemukan' }}</td>
                            <td class="px-6 py-4">{{ $item->nama_produk }}</td>
                            <td class="px-6 py-4">{{ $item->kategori->name ?? '' }}</td>
                            <td class="px-6 py-4">{{ $item->deskripsi }}</td>
                            <td class="px-6 py-4">
                                @forelse($item->produk_variant as $variant)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mb-1 mr-1">
                                        {{ $variant->varian }} - Rp{{ number_format($variant->harga, 0, ',', '.') }} - {{ number_format($variant->stok) }}
                                    </span>
                                @empty
                                    <span class="text-gray-400">-</span>
                                @endforelse
                            </td>

                            {{-- Galeri --}}
                            <td class="px-6 py-4 flex flex-wrap gap-2">
                                @foreach($item->images as $media)
                                    @if($media->type == 'image')
                                        <img src="{{ asset('storage/' . $media->file_path) }}" alt="Gambar Produk" width="60" class="rounded">
                                    @elseif($media->type == 'video')
                                        <video src="{{ asset('storage/' . $media->file_path) }}" width="80" controls class="rounded"></video>
                                    @endif
                                @endforeach
                                @if($item->images->isEmpty())
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ "" }}</td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('produk_umkm.edit', ['produk_umkm' => $item->id]) }}" class="btn btn-sm bg-yellow-500 text-white hover:bg-yellow-600">
                                    <i data-feather="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('produk_umkm.destroy', ['produk_umkm' => $item->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm bg-red-500 text-white hover:bg-red-600">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($produk_umkm->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">Tidak ada data produk UMKM.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
