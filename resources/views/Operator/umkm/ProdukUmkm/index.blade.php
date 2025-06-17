@extends('layouts.app2')

@section('title', 'Data Produk UMKM')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    div.dataTables_wrapper .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }
            /* Atur dropdown agar tidak rusak */
            .dataTables_length select {
            padding-right: 1rem;        /* beri ruang untuk arrow */
            background-position: right 0rem center; /* panah ke kanan */
            background-repeat: no-repeat;
            background-size: 1rem;
            appearance: auto;           /* penting untuk tampilan default */
        }
</style>
@endpush

@section('content')
<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white font-semibold">Data Produk UMKM</h1>
    <a href="{{ route('produk_umkm.create') }}" class="bg-white hover:bg-gray-100 text-gray-800 font-medium py-2 px-4 rounded shadow">
        + Tambah Produk UMKM
    </a>
</div>

<div class="mx-4 sm:mx-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Produk UMKM</h2>
        </div>

        <div class="overflow-x-auto p-4">
            <table id="produk-umkm-table" class="w-full text-sm text-left text-gray-700 border-collapse">
                <thead class="bg-gray-100 border-b border-gray-300">
                    <tr>
                        <th class="px-4 py-3 font-semibold">#</th>
                        <th class="px-4 py-3 font-semibold">Nama Toko</th>
                        <th class="px-4 py-3 font-semibold">Nama Produk</th>
                        <th class="px-4 py-3 font-semibold">Kategori</th>
                        <th class="px-4 py-3 font-semibold">Deskripsi</th>
                        <th class="px-4 py-3 font-semibold">Varian, Berat, Harga & Stok</th>
                        <th class="px-4 py-3 font-semibold">Foto Produk</th>
                        <th class="px-4 py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($produk_umkm as $index => $item)
                        <tr>
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $item->member->nama_toko ?? 'Toko tidak ditemukan' }}</td>
                            <td class="px-4 py-3">{{ $item->nama_produk }}</td>
                            <td class="px-4 py-3">{{ $item->kategori->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item->deskripsi }}</td>
                            <td class="px-4 py-3">
                                @forelse($item->produk_variant as $variant)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mb-1 mr-1">
                                        {{ $variant->varian }} - {{ number_format($variant->berat) }}gram - Rp{{ number_format($variant->harga, 0, ',', '.') }} - {{ number_format($variant->stok)  }}
                                    </span>
                                @empty
                                    <span class="text-gray-400">-</span>
                                @endforelse
                            </td>
                            <td class="px-4 py-3 flex flex-wrap gap-2">
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
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('produk_umkm.edit', ['produk_umkm' => $item->id]) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 text-white bg-yellow-500 hover:bg-yellow-600 rounded shadow">
                                        <i data-feather="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('produk_umkm.destroy', ['produk_umkm' => $item->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center w-8 h-8 text-white bg-red-500 hover:bg-red-600 rounded shadow">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#produk-umkm-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 10,
            dom: '<"top"f<"spacer">l>rt<"bottom"ip><"clear">'
        });
        feather.replace();
    });
</script>
@endpush
