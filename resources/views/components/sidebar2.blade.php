@php
    $user = Auth::user();
    $pathRole = $user->jenisOperator->url_parameter ?? 'dashboard';
    $labelRole = $user->jenisOperator->name ?? 'Dashboard';
@endphp


<nav class="navbar-vertical navbar bg-gray-900 text-white w-64 min-h-screen p-4 fixed">
    <div id="myScrollableElement" class="h-screen" data-simplebar>
{{-- <nav class="bg-gray-900 text-white w-64 min-h-screen p-4 fixed"> --}}
    <!-- Scrollable Sidebar -->
    {{-- <div id="myScrollableElement" class="h-full overflow-y-auto"> --}}

        <!-- Brand -->
        <div class="text-2xl font-bold mb-6">
            <a href="{{ url($pathRole . '/dashboard') }}" class="hover:text-gray-300 transition">
                Operator {{ $labelRole }}
            </a>
        </div>

        <!-- Sidebar Navigation -->
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ url($pathRole . '/dashboard') }}"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/dashboard') ? 'bg-gray-800' : '' }}">
                    <i data-feather="home" class="w-4 h-4 mr-3"></i>
                    Dashboard
                </a>
            </li>

            <li class="px-3 pt-4 pb-2 text-sm font-semibold text-gray-400 uppercase tracking-wider">
                Data Master
            </li>

            <!-- UMKM -->
            @if ($user->jenis_operator_id == 1)
                <li>
                    <a href="{{ route('produk_umkm.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/produk_umkm*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="package" class="w-4 h-4 mr-3"></i>
                        Data Produk
                    </a>
                    <a href="{{ route('member_umkm.index') }}"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/member_umkm*') ? 'bg-gray-800' : '' }}">
                    <i data-feather="package" class="w-4 h-4 mr-3"></i>
                    Member UMKM
                </a>

                <button type="button"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-md hover:bg-gray-800 transition focus:outline-none"
                    onclick="document.getElementById('analisisSubmenu').classList.toggle('hidden')">
                    <span class="flex items-center">
                        <i data-feather="bar-chart-2" class="w-4 h-4 mr-3"></i>
                        Laporan Transaksi
                    </span>
                    <i data-feather="chevron-down" class="w-4 h-4"></i>
                </button>
                <ul id="analisisSubmenu" class="pl-10 mt-1 space-y-1 hidden">
                    <li>
                        <a href="{{ route('transaksi-produk-umkm.index') }}"
                            class="block px-3 py-2 rounded-md hover:bg-gray-800 transition text-sm">
                            Data
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('klasterisasi-produk.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/klasterisasi_umkm*') ? 'bg-gray-800' : '' }}">
                        Klaster
                        </a>
                    </li>
                </ul>
                
                </li>
                

            <!-- Pariwisata -->
            @elseif ($user->jenis_operator_id == 2)
                <li>
                    <a href="{{ route('operator.pariwisata.data.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/pariwisata*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="map-pin" class="w-4 h-4 mr-3"></i>
                        Data Pariwisata
                    </a>
                </li>
                <li>
                    <a href="{{ route('operator.pariwisata.laporan.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/laporan*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="file-text" class="w-4 h-4 mr-3"></i>
                        Laporan Pariwisata
                    </a>
                </li>
                <li class="nav-item">
                    <a 
                        href="{{ route('operator.pariwisata.rekomendasi') }}"
                        class="flex items-center pl-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/rekomendasi*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="star" class="w-4 h-4 mr-3"></i>
                        Rekomendasi Wisata
                    </a>
                </li>

            <!-- Investasi -->
            @elseif ($user->jenis_operator_id == 3)
                <li>
                    <a href="{{ route('investasi.index') }}"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/investasi*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="bar-chart" class="w-4 h-4 mr-3"></i>
                        Laporan Investasi
                    </a>
                </li>

            <!-- Event -->
            @elseif ($user->jenis_operator_id == 4)
                <li>
                    <a href="{{ route('event.index') }}"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/event*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="calendar" class="w-4 h-4 mr-3"></i>
                        Data Event
                    </a>
                </li>

            <!-- Entertainment -->
            @elseif ($user->jenis_operator_id == 5)
            <a href="{{ route('entertaiment.index') }}"
            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/entertaiment*') ? 'bg-gray-800' : '' }}">
            <i data-feather="package" class="w-4 h-4 mr-3"></i>
            Data Entertaiment

            <!-- Box Office -->
            @elseif ($user->jenis_operator_id == 6)
                
                <li class="nav-item">
                    <a class="nav-link flex items-center justify-between px-3 py-2 text-white hover:bg-gray-800 transition cursor-pointer"
                    data-bs-toggle="collapse"
                    href="#navIklan"
                    role="button"
                    aria-expanded="false"
                    aria-controls="navIklan">
                        <span class="flex items-center gap-2">
                            <i data-feather="file-text" class="w-4 h-4"></i>
                            Iklan
                        </span>
                        <i data-feather="chevron-down" class="w-4 h-4 transition-transform duration-200"></i>
                    </a>
                    <div class="collapse" id="navIklan" data-bs-parent="#sideNavbar">
                        <ul class="pl-10 py-2 text-sm space-y-1">
                            
                            <li><a href="{{ route('iklan.index') }}" class="block text-gray-300 hover:text-white">Informasi Data Iklan</a></li>
                            <li><a href="{{ route('iklandata.index', ['q' => 'home-1']) }}" class="block text-gray-300 hover:text-white">Halaman Home</a></li>
                            <li><a href="{{ route('iklandata.index', ['q' => 'umkm-1']) }}" class="block text-gray-300 hover:text-white">Halaman UMKM</a></li>
                            <li><a href="{{ route('iklandata.index', ['q' => 'pariwisata-1']) }}" class="block text-gray-300 hover:text-white">Halaman Pariwisata</a></li>
                            <li><a href="{{ route('iklandata.index', ['q' => 'event-1']) }}" class="block text-gray-300 hover:text-white">Halaman Event</a></li>
                            <li><a href="{{ route('iklandata.index', ['q' => 'investasi-1']) }}" class="block text-gray-300 hover:text-white">Halaman Investasi</a></li>
                            <li><a href="{{ route('iklandata.index', ['q' => 'entertaiment-1']) }}" class="block text-gray-300 hover:text-white">Halaman Entertaiment</a></li>

                        </ul>
                    </div>
                </li>


            @endif


        </a>
    </div>
</nav>

<!-- Feather Icons Init -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        feather.replace();
    });
</script>
