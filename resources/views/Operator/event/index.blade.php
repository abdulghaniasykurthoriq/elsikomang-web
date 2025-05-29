@extends('layouts.app2')
@section('title', 'Data Event')
@section('content')

@php
    $jenis = request()->route('jenis');
@endphp

<div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-28 flex justify-between items-center relative z-0">
    <h1 class="text-xl text-white">Data Operator Event</h1>

    <a href="{{ route('event.create', ['jenis' => $jenis]) }}" class="btn btn-success">+ Tambah Event</a>
</div>

<div class="m-2 p-6 -mt-24 relative z-10">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full">
        <div class="p-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Event</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Nama Event</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Foto Event</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($operator_events as $index => $event)
                        <tr>
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $event->nama_event }}</td>
                            <td class="px-6 py-4">{!! Str::limit(strip_tags($event->deskripsi), 100) !!}</td>
                            <td class="px-6 py-4">
                                @if($event->foto_event)
                                    <img src="{{ asset('storage/' . $event->foto_event) }}" alt="Foto event" width="100">
                                @else
                                    Tidak ada foto
                                @endif
                            </td>          
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('event.edit', ['jenis' => $jenis, 'event' => $event->id]) }}" class="btn btn-sm bg-yellow-500 text-white hover:bg-yellow-600">
                                    <i data-feather="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('event.destroy', ['jenis' => $jenis, 'event' => $event->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm bg-red-500 text-white hover:bg-red-600">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($operator_events->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data operator event.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
