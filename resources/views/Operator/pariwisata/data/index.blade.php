@extends('layouts.app2')

@section('title', 'Data Pariwisata')

@section('content')

    <!-- Header Section -->
    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Data Pariwisata</h1>
        <a href="{{ route('operator.pariwisata.data.create', ['jenis' => request()->route('jenis')]) }}"
            class="btn bg-white text-indigo-700 hover:bg-indigo-50 shadow font-semibold">
            + Tambah Data
        </a>
    </div>

    <!-- Table Section -->
    <div class="px-6 -mt-24 relative z-10 mx-2">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
            <div class="p-4 border-b border-gray-100 font-semibold">
                Total: {{ $data->count() }} wisata
            </div>

            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Deskripsi</th>
                            <th class="px-6 py-3">Gambar</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Harga Tiket</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($data as $item)
                            <tr>
                                <td class="px-6 py-4 font-semibold">{{ $item->nama }}</td>
                                <td class="px-6 py-4">{{ \Illuminate\Support\Str::limit($item->deskripsi, 60) }}</td>
                                <td class="px-6 py-4">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}"
                                        class="h-16 w-24 object-cover rounded shadow">
                                </td>
                                <td class="px-6 py-4 capitalize">{{ $item->kategori }}</td>
                                <td class="px-6 py-4">Rp{{ number_format($item->harga_tiket) }}</td>
                                <td class="px-6 py-4 flex gap-2 justify-center">
                                    <a href="{{ route('operator.pariwisata.data.edit', ['jenis' => request()->route('jenis'), 'id' => $item->id]) }}"
                                        class="btn btn-sm bg-yellow-500 text-white hover:bg-yellow-600" title="Edit">
                                        <i data-feather="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form
                                        action="{{ route('operator.pariwisata.data.destroy', ['jenis' => request()->route('jenis'), 'id' => $item->id]) }}"
                                        method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm bg-red-500 text-white hover:bg-red-600"
                                            title="Hapus">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data pariwisata.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
