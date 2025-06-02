@extends('layouts.app2')

@section('title', 'Data Member UMKM')

@section('content')

<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Data Member UMKM</h1>

    <a href="{{ route('member_umkm.create') }}" class="btn bg-white text-gray-800"> + Tambah Member UMKM</a>
</div>

<div class="m-2 p-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
        <div class="p-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Member UMKM</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Nama Toko</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3">No HP</th>
                        <th class="px-6 py-3">Foto Toko</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($member_umkm as $index => $item)
                        <tr>
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $item->nama_toko }}</td>
                            <td class="px-6 py-4">{{ $item->alamat }}</td>
                            <td class="px-6 py-4">{{ $item->no_hp }}</td>
                            <td class="px-6 py-4">
                                @if($item->foto_toko)
                                    <img src="{{ asset('storage/' . $item->foto_toko) }}" alt="Foto Toko" width="100">
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('member_umkm.edit', [ 'member_umkm' => $item->id]) }}" class="btn btn-sm bg-yellow-500 text-white hover:bg-yellow-600">
                                    <i data-feather="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('member_umkm.destroy', [ 'member_umkm' => $item->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus member ini?')">
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
                            <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data member UMKM.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
