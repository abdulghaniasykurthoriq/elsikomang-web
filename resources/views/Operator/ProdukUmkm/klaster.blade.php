@extends('layouts.app')

@section('content')
    <h4>Hasil Klasterisasi Produk Berdasarkan Harga</h4>
    @foreach($hasilKlaster as $hasil)
        <div>
            <strong>Cluster:</strong> {{ $hasil['cluster'] }} |
            <strong>Produk:</strong> {{ $hasil['produk']['nama_produk'] }} |
            <strong>Varian:</strong> {{ $hasil['produk']['varian'] }} |
            <strong>Harga:</strong> Rp {{ number_format($hasil['produk']['harga'], 0, ',', '.') }}
        </div>
    @endforeach
@endsection
