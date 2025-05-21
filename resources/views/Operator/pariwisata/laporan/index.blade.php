@extends('layouts.app2')

@section('title', 'Laporan Pariwisata')

@section('content')

    <!-- Header Section -->
    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Laporan Pariwisata</h1>

        <a href="{{ route('operator.pariwisata.laporan.create', ['jenis' => $jenis]) }}" class="btn btn-success">
            + Tambah Data
        </a>
    </div>

    <!-- Table Section -->
    <div class="px-6 -mt-24 relative z-10 mx-2">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
            <div class="p-4 border-b border-gray-100">
                <!-- <h2 class="text-lg font-semibold text-gray-800">Daftar Laporan</h2> -->
            </div>

            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Periode</th>
                            <th class="px-6 py-3">Nama Wisata</th>
                            <th class="px-6 py-3">Jumlah Viewer</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($laporanPariwisatas as $index => $laporan)
                            <tr>
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $laporan->tanggal }}</td>
                                <td class="px-6 py-4 capitalize">{{ $laporan->periode }}</td>
                                <td class="px-6 py-4">{{ $laporan->nama_wisata }}</td>
                                <td class="px-6 py-4">{{ number_format($laporan->jumlah_viewer) }}</td>
                                <td class="px-6 py-4 flex gap-2 justify-center">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('operator.pariwisata.laporan.edit', ['jenis' => $jenis, 'laporan' => $laporan->id]) }}"
                                       class="btn btn-sm bg-yellow-500 text-white hover:bg-yellow-600" title="Edit">
                                        <i data-feather="edit" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('operator.pariwisata.laporan.destroy', ['jenis' => $jenis, 'laporan' => $laporan->id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm bg-red-500 text-white hover:bg-red-600" title="Hapus">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data laporan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
