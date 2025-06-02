@extends('layouts.app2')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Data Iklan {{ $iklan->nama }}</h1>
    <a href="{{ url('box-office/iklandata/create?q=' . $iklan->slug ) }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Data</a>

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Gambar</th>
                <th class="border px-4 py-2">Link</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Expired At</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($iklanData as $data)
                <tr>
                    <td class="border px-4 py-2">{{ $data->id }}</td>
                    <td class="border px-4 py-2"><img src="{{ asset('storage/' . $data->gambar) }}" class="w-16 h-10 object-cover"></td>
                    <td class="border px-4 py-2"><a href="{{ $data->link }}" target="_blank" class="text-blue-600 underline">Link</a></td>
                    <td class="border px-4 py-2">{{ $data->status }}</td>
                    <td class="border px-4 py-2">{{ $data->expired_at }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ url('box-office/iklandata/' . $data->id . '/edit') }}" class="text-yellow-500 hover:underline">Edit</a> |
                        <form action="#" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
