@extends('layouts.app2')

@section('title', 'Data Member UMKM')

@section('content')
<!-- Header -->
<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-24 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Data Member UMKM</h1>
    <a href="{{ route('member_umkm.create') }}"
        class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100 hover:text-gray-800">
        Tambah Member
    </a>
</div>

<!-- Table -->
<div class="m-2 px-6 -mt-20 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-x-auto w-full p-6">
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-left text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Nama Toko</th>
                    <th class="px-4 py-2">No HP</th>
                    <th class="px-4 py-2">Alamat</th>
                    <th class="px-4 py-2">Wilayah</th>
                    <th class="px-4 py-2">Foto</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($member_umkm as $index => $member)
                    <tr>
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $member->nama_toko }}</td>
                        <td class="px-4 py-2">{{ $member->no_hp }}</td>
                        <td class="px-4 py-2">{{ $member->alamat }}</td>
                        <td class="px-4 py-2">
                            {{ $member->desa->nama ?? '-' }},
                            {{ $member->desa->kecamatan->nama ?? '-' }},
                            {{ $member->desa->kecamatan->kota->nama ?? '-' }},
                            {{ $member->desa->kecamatan->kota->provinsi->nama ?? '-' }}
                        </td>
                        <td class="px-4 py-2">
                            @if ($member->foto_toko)
                                <img src="{{ asset('storage/' . $member->foto_toko) }}" alt="Foto" class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-400 italic">Belum ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center flex justify-center gap-2">
                            <a href="{{ route('member_umkm.edit', $member->id) }}"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                                Edit
                            </a>
                        
                            <form action="{{ route('member_umkm.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">Belum ada data member UMKM.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $member_umkm->links() }}
        </div>
    </div>
</div>
@endsection
