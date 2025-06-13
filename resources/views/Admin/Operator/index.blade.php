@extends('layouts.app')

@section('title', 'Data Operator')

@section('content')

    <!-- Header Section -->
    <div class=" bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        </h1>

        <a href="{{ route('operator.create', ['role' => $role]) }}"  class="btn btn-success">+ Tambah Operator</a>
    </div>

    

    <!-- Table Section -->
    <div class="px-6 -mt-24 relative z-10 mx-2">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
            <div class="p-4 border-b border-gray-100">
                <!-- <h2 class="text-lg font-semibold text-gray-800">Daftar Operator</h2> -->
            </div>

            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Role</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($operators as $index => $item)
                            <tr>
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $item->name }}</td>
                                <td class="px-6 py-4">{{ $item->email }}</td>
                                <td class="px-6 py-4 uppercase">{{ $item->role }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('operator.edit', $item->id) }}" class="btn btn-sm bg-yellow-500 text-white hover:bg-yellow-600">
                                        <i data-feather="edit" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('operator.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus operator ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm bg-red-500 text-white hover:bg-red-600">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if($operators->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data operator.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
