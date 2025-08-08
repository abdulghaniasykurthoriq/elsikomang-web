@extends('layouts.app2')

@section('title', 'Dashboard UMKM')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-6 rounded-xl shadow mb-8 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i data-feather="shopping-bag" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Dashboard UMKM</h1>
                    <p class="text-sm text-white text-opacity-80">Pantau produk, anggota, dan kategori UMKM dengan mudah.</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
                    <i data-feather="package" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Total Produk</div>
                    <div class="text-2xl font-bold text-indigo-700">{{ $totalProduk }}</div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i data-feather="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Total Member</div>
                    <div class="text-2xl font-bold text-green-700">{{ $totalMember }}</div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i data-feather="layers" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Total Kategori</div>
                    <div class="text-2xl font-bold text-yellow-700">{{ $totalKategori }}</div>
                </div>
            </div>
        </div>

@endsection
