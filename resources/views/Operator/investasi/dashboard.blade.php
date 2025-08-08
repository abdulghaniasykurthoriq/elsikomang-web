@extends('layouts.app2')

@section('title', 'Dashboard Investasi')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-6 rounded-xl shadow mb-8 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i data-feather="trending-up" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Dashboard Investasi</h1>
                    <p class="text-sm text-white text-opacity-80">Pantau jumlah investasi dan data terbaru dengan mudah.</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
                    <i data-feather="dollar-sign" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Total Investasi</div>
                    <div class="text-2xl font-bold text-indigo-700">{{ $totalInvestasi }}</div>
                </div>
            </div>
        </div>

@endsection
