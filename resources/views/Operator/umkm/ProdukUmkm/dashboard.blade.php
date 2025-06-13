@extends('layouts.app2')

@section('title', 'Dashboard UMKM')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard UMKM</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <p class="card-text h3">{{ $totalProduk }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Member</h5>
                    <p class="card-text h3">{{ $totalMember }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Kategori</h5>
                    <p class="card-text h3">{{ $totalKategori }}</p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-5 mb-3">Produk Terbaru</h3>
    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Member</th>
                        <th>Kategori</th>
                        <th>Tanggal Buat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produkTerbaru as $produk)
                        <tr>
                            <td>{{ $produk->nama_produk }}</td>
                            <td>{{ $produk->member->nama ?? '-' }}</td>
                            <td>{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $produk->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                    @if ($produkTerbaru->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">Belum ada produk</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
