@extends('layouts.app')

@section('title', 'Data Operator')

@section('content')

    <!-- Header Section -->
    <div class="-mx-6 bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
        <h1 class="text-xl text-white">Data Operator</h1>
        <a href="#"
            class="btn bg-white text-gray-800 border-gray-600 hover:bg-gray-100 hover:text-gray-800 hover:border-gray-200 active:bg-gray-100 active:text-gray-800 active:border-gray-200 focus:outline-none focus:ring-4 focus:ring-indigo-300">
            Tambah Operator
        </a>
    </div>

    <!-- Table Section -->
    <div class="-mx-6 px-6 -mt-24 relative z-10">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
            <div class="p-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Operator</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Jenis</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- Dummy data sementara --}}
                        @php
                            $data = [
                                ['nama' => 'Budi', 'email' => 'budi@mail.com', 'jenis' => 'umkm'],
                                ['nama' => 'Sari', 'email' => 'sari@mail.com', 'jenis' => 'pariwisata'],
                            ];
                        @endphp

                        @foreach($data as $index => $item)
                            <tr>
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $item['nama'] }}</td>
                                <td class="px-6 py-4">{{ $item['email'] }}</td>
                                <td class="px-6 py-4 uppercase">{{ $item['jenis'] }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <button class="btn btn-sm bg-yellow-500 text-white hover:bg-yellow-600">
                                        <i data-feather="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button class="btn btn-sm bg-red-500 text-white hover:bg-red-600">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        @if(count($data) == 0)
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
