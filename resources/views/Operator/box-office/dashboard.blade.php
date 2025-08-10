@extends('layouts.app2')

@section('title', 'Dashboard Box Office')

@section('content')
    <div class="container mx-auto p-6">
            <div class="container mx-auto p-6">
                <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-6 rounded-xl shadow mb-8 text-white">
                    <div class="flex items-center gap-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i data-feather="film" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Dashboard Box Office</h1>
                    <p class="text-sm text-white text-opacity-80">Selamat datang, operator Box-Office!</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i data-feather="folder" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Total Iklan</div>
                    <div class="text-2xl font-bold text-yellow-700">{{ $totalIklan }}</div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i data-feather="database" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Total Data Iklan</div>
                    <div class="text-2xl font-bold text-blue-700">{{ $totalDataIklan }}</div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i data-feather="check-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Iklan Aktif</div>
                    <div class="text-2xl font-bold text-green-700">{{ $iklanAktif }}</div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
                <div class="bg-red-100 text-red-600 p-3 rounded-full">
                    <i data-feather="x-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Iklan Expired</div>
                    <div class="text-2xl font-bold text-red-700">{{ $iklanExpired }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
