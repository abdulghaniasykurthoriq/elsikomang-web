@extends('layouts.app2')

@section('title', 'Dashboard Entertaiment')

@section('content')
    <div class="container mx-auto p-6">
        <div class="container mx-auto p-6">
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-6 rounded-xl shadow mb-8 text-white">
                <div class="flex items-center gap-4">
                    <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i data-feather="film" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Dashboard Entertaiment</h1>
                    <p class="text-sm text-white text-opacity-80">Kelola data hiburan dan event dengan mudah.</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                <div class="bg-pink-100 text-pink-600 p-3 rounded-full">
                    <i data-feather="music" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Total Entertaiment</div>
                    <div class="text-2xl font-bold text-pink-700">{{ $totalEntertaiment }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
