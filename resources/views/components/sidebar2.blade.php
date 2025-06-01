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
                    <a href="{{ url($pathRole . '/produk_umkm') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/produk_umkm*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="package" class="w-4 h-4 mr-3"></i>
                        Data Produk
                    </a>
                    <a href="{{ url($pathRole . '/produk_umkm') }}"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole.'/produk_umkm*') ? 'bg-gray-800' : '' }}">
                    <i data-feather="package" class="w-4 h-4 mr-3"></i>
                    D
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
                        <a href="{{ url($pathRole.'/analisis/data') }}"
                            class="block px-2 py-1 rounded-md hover:bg-gray-800 transition text-sm">
                            Data
                        </a>
                    </li>
                    <li>
                        <a href="{{ url($pathRole.'/klasterisasi_umkm') }}"
                            class="block px-2 py-1 rounded-md hover:bg-gray-800 transition text-sm">
                            Klaster
                        </a>
                    </li>
                </ul>
                
                </li>
                

            <!-- Pariwisata -->
            @elseif ($user->jenis_operator_id == 2)
                <li>
                    <a href="{{ route('operator.pariwisata.data.index', ['jenis' => 'pariwisata']) }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition">
                        <i data-feather="map-pin" class="w-4 h-4 mr-3"></i>
                        Data Pariwisata
                    </a>
                </li>
                <li>
                    <a href="{{ route('operator.pariwisata.laporan.index', ['jenis' => 'pariwisata']) }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition">
                        <i data-feather="file-text" class="w-4 h-4 mr-3"></i>
                        Laporan Pariwisata
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('operator.pariwisata.rekomendasi', ['jenis' => 'pariwisata']) }}">
                        <i data-feather="star" class="w-4 h-4 mr-2"></i>
                        Rekomendasi Wisata
                    </a>
                </li>

            <!-- Investasi -->
            @elseif ($user->jenis_operator_id == 3)
                <li>
                    <a href="{{ url($pathRole.'/investasi') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition">
                        <i data-feather="bar-chart" class="w-4 h-4 mr-3"></i>
                        Laporan Investasi
                    </a>
                </li>

            <!-- Event -->
            @elseif ($user->jenis_operator_id == 4)
                <li>
                    <a href="{{ url($pathRole.'/event') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition">
                        <i data-feather="calendar" class="w-4 h-4 mr-3"></i>
                        Data Event
                    </a>
                </li>

            <!-- Entertainment -->
            @elseif ($user->jenis_operator_id == 5)
                <li>
                    <a href="{{ url($pathRole.'/entertaiment') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition">
                        <i data-feather="film" class="w-4 h-4 mr-3"></i>
                        Data Entertainment
                    </a>
                </li>

            <!-- Box Office -->
            @elseif ($user->jenis_operator_id == 6)
                <li>
                    <a href="{{ url('box-office/data') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition">
                        <i data-feather="tv" class="w-4 h-4 mr-3"></i>
                        Data Box Office
                    </a>
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
