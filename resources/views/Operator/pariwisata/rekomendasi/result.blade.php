@extends('layouts.app2')

@section('title', 'Hasil Filter Rekomendasi')

@section('content')
<div class="px-6 py-10">
    <h1 class="text-xl font-bold mb-6">Hasil Filter Awal</h1>

    @if($filtered->isEmpty())
        <p>Tidak ada wisata yang cocok dengan preferensi Anda.</p>
    @else
        <table class="table-auto w-full text-left border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Jarak</th>
                    <th class="px-4 py-2">Tiket</th>
                    <th class="px-4 py-2">Rating</th>
                    <th class="px-4 py-2">Fasilitas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filtered as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->nama }}</td>
                        <td class="px-4 py-2">{{ $item->jarak_km }} km</td>
                        <td class="px-4 py-2">Rp{{ number_format($item->harga_tiket) }}</td>
                        <td class="px-4 py-2">{{ $item->rating }}</td>
                        <td class="px-4 py-2">{{ $item->fasilitas->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
