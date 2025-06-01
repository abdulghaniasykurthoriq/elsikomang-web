@extends('layouts.app2')

@section('title', 'Data Investasi')

@section('content')
<div class="bg-indigo-600 px-8 pt-10 pb-28 flex justify-between items-center">
    <h1 class="text-xl text-white">Data Investasi</h1>
    <a href="{{ route('investasi.create', ['jenis' => $jenis]) }}" class="btn bg-white text-gray-800">+ Tambah</a>
</div>

<div class="m-2 p-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
        <div class="p-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Invvestasi</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Nama investasi</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Foto investasi</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($investasis as $i => $item)
                        <tr 
                        class="border-b">
                            <td class="px-4 py-2">{{ $i + 1 }}</td>
                            
                            <td class="px-4 py-2">{{ $item->nama_investasi }}</td>
                            <td class="px-4 py-2">{{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 100) }}</td>
                            <td class="px-4 py-2">
                                @if($item->foto_investasi)
                                    <img src="{{ asset('storage/' . $item->foto_investasi) }}" alt="Foto investasi" width="100">
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('investasi.edit', ['jenis' => $jenis, 'investasi' => $item->id]) }}" class="btn btn-sm bg-yellow-500 text-white hover:bg-yellow-600">
                                    <i data-feather="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('investasi.destroy', ['jenis' => $jenis, 'investasi' => $item->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus investasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm bg-red-500 text-white hover:bg-red-600">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data investasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
