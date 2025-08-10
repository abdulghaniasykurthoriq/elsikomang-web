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
            <a class="hover:text-gray-300 transition">
                Operator {{ $labelRole }}
            </a>
        </div>

        <!-- Sidebar Navigation -->
        <ul class="space-y-2">
            <!-- UMKM -->
            @if ($user->role == 'Operator umkm')
                <li>
                    <a href="{{ route('ProdukUmkm.dashboard') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/dashboard') ? 'bg-gray-800' : '' }}">
                        <i data-feather="home" class="w-4 h-4 mr-3"></i>
                        Dashboard
                    </a>
                </li>
                <li class="px-3 pt-4 pb-2 text-sm font-semibold text-gray-400 uppercase tracking-wider">
                    Data Master
                </li>
                <li>
                    <a href="{{ route('produk_umkm.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/produk_umkm*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="package" class="w-4 h-4 mr-3"></i>
                        Data Produk
                    </a>
                    <a href="{{ route('member_umkm.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/member_umkm*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="package" class="w-4 h-4 mr-3"></i>
                        Member UMKM
                    </a>
                    <a href="{{ route('voucher.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/member_umkm*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="package" class="w-4 h-4 mr-3"></i>
                        Voucher
                    </a>
                    <a href="{{ route('transaksi.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/member_umkm*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="package" class="w-4 h-4 mr-3"></i>
                        Transaksi
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
                                class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/klasterisasi_umkm*') ? 'bg-gray-800' : '' }}">
                                Klaster
                            </a>
                        </li>
                    </ul>

                </li>
                <li class="px-3 pt-4 pb-2 text-sm font-semibold text-gray-400 uppercase tracking-wider">
                    OPTIMALISASI PENCARIAN
                </li>
                <li>
                    <a href="{{ route('pencarian.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/pencarian*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="search" class="w-4 h-4 mr-3"></i>
                        Pencarian Produk
                    </a>
                </li>

                <li>
                    <a href="{{ route('pencarian.perbandingan') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/perbandingan*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="bar-chart-2" class="w-4 h-4 mr-3"></i>
                        Perbandingan TF-IDF
                    </a>
                </li>


                <!-- Pariwisata -->
            @elseif ($user->role == 'Operator pariwisata')
                <li>
                    <a href="{{ route('pariwisata.dashboard') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/dashboard') ? 'bg-gray-800' : '' }}">
                        <i data-feather="home" class="w-4 h-4 mr-3"></i>
                        Dashboard
                    </a>
                </li>

                <li class="px-3 pt-4 pb-2 text-sm font-semibold text-gray-400 uppercase tracking-wider">
                    Data Master
                </li>
                <li>
                    <a href="{{ route('operator.pariwisata.data.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/pariwisata*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="map-pin" class="w-4 h-4 mr-3"></i>
                        Data Pariwisata
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('operator.pariwisata.laporan.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/laporan*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="file-text" class="w-4 h-4 mr-3"></i>
                        Pariwisata
                    </a>
                </li> --}}

                <li class="px-3 pt-4 pb-2 text-sm font-semibold text-gray-400 uppercase tracking-wider">
                    Rekomendasi DSS
                </li>

                {{-- Input Preferensi --}}
                <li>
                    <a href="{{ route('operator.pariwisata.rekomendasi.input') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/rekomendasi/input') ? 'bg-gray-800' : '' }}">
                        <i data-feather="search" class="w-4 h-4 mr-3"></i>
                        Input Rekomendasi
                    </a>
                </li>

                <!-- SAW Proses Dropdown -->
                <li>
                    <a class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/rekomendasi/step*') ? 'bg-gray-800' : 'collapsed' }}"
                        href="#!" data-bs-toggle="collapse" data-bs-target="#navSawProses"
                        aria-expanded="{{ request()->is($pathRole . '/rekomendasi/step*') ? 'true' : 'false' }}"
                        aria-controls="navSawProses">
                        <i data-feather="sliders" class="w-4 h-4 mr-3"></i>
                        <span class="flex-1">SAW Proses</span>
                        <i data-feather="chevron-down" class="w-4 h-4"></i>
                    </a>
                </li>

                <div id="navSawProses"
                    class="collapse {{ request()->is($pathRole . '/rekomendasi/step*') ? 'show' : '' }}"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-col pl-12 py-1 text-sm">
                        <li>
                            <a class="block px-3 py-1 rounded hover:bg-gray-800 {{ request()->is($pathRole . '/rekomendasi') ? 'bg-gray-800' : '' }}"
                                href="{{ route('operator.pariwisata.rekomendasi.step1') }}">
                                Step 1: Data Alternatif
                            </a>
                        </li>
                        <li>
                            <a class="block px-3 py-1 rounded hover:bg-gray-800 {{ request()->is($pathRole . '/rekomendasi/step2') ? 'bg-gray-800' : '' }}"
                                href="{{ route('operator.pariwisata.rekomendasi.step2') }}">
                                Step 2: Kriteria
                            </a>
                        </li>
                        <li>
                            <a class="block px-3 py-1 rounded hover:bg-gray-800 {{ request()->is($pathRole . '/rekomendasi/step3') ? 'bg-gray-800' : '' }}"
                                href="{{ route('operator.pariwisata.rekomendasi.step3') }}">
                                Step 3: Normalisasi
                            </a>
                        </li>
                        <li>
                            <a class="block px-3 py-1 rounded hover:bg-gray-800 {{ request()->is($pathRole . '/rekomendasi/step4') ? 'bg-gray-800' : '' }}"
                                href="{{ route('operator.pariwisata.rekomendasi.step4') }}">
                                Step 4: Bobot
                            </a>
                        </li>
                        <li>
                            <a class="block px-3 py-1 rounded hover:bg-gray-800 {{ request()->is($pathRole . '/rekomendasi/step5') ? 'bg-gray-800' : '' }}"
                                href="{{ route('operator.pariwisata.rekomendasi.step5') }}">
                                Step 5: Skor Akhir
                            </a>
                        </li>
                        <li>
                            <a class="block px-3 py-1 rounded hover:bg-gray-800 {{ request()->is($pathRole . '/rekomendasi/step6') ? 'bg-gray-800' : '' }}"
                                href="{{ route('operator.pariwisata.rekomendasi.step6') }}">
                                Step 6: Ranking
                            </a>
                        </li>
                    </ul>
                </div>



                <!-- Investasi -->
            @elseif ($user->role == 'Operator investasi')
                <a href="{{ route('investasi.dashboard') }}"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/dashboard') ? 'bg-gray-800' : '' }}">
                    <i data-feather="home" class="w-4 h-4 mr-3"></i>
                    Dashboard
                </a>
                <li class="px-3 pt-4 pb-2 text-sm font-semibold text-gray-400 uppercase tracking-wider">
                    Data Master
                </li>
                <li>
                    <a href="{{ route('investasi.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/investasi*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="bar-chart" class="w-4 h-4 mr-3"></i>
                        Investasi
                    </a>
                </li>

                <!-- Event -->
            @elseif ($user->role == 'Operator event')
                <a href="{{ route('event.dashboard') }}"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/dashboard') ? 'bg-gray-800' : '' }}">
                    <i data-feather="home" class="w-4 h-4 mr-3"></i>
                    Dashboard
                </a>
                <li class="px-3 pt-4 pb-2 text-sm font-semibold text-gray-400 uppercase tracking-wider">
                    Data Master
                </li>
                <li>
                    <a href="{{ route('event.index') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/event*') ? 'bg-gray-800' : '' }}">
                        <i data-feather="calendar" class="w-4 h-4 mr-3"></i>
                        Data Event
                    </a>
                </li>

                <!-- Entertaiment -->
            @elseif ($user->role == 'Operator entertainment')
                <a href="{{ route('entertaiment.dashboard') }}"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/dashboard') ? 'bg-gray-800' : '' }}">
                    <i data-feather="home" class="w-4 h-4 mr-3"></i>
                    Dashboard
                </a>
                <li class="px-3 pt-4 pb-2 text-sm font-semibold text-gray-400 uppercase tracking-wider">
                    Data Master
                </li>
                <a href="{{ route('entertaiment.index') }}"
                    class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/entertaiment*') ? 'bg-gray-800' : '' }}">
                    <i data-feather="package" class="w-4 h-4 mr-3"></i>
                    Data Entertainment

                    <!-- Box Office -->
                @elseif ($user->role == 'Operator box office')
                    <a href="{{ route('box-office.dashboard') }}"
                        class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition {{ request()->is($pathRole . '/dashboard') ? 'bg-gray-800' : '' }}">
                        <i data-feather="home" class="w-4 h-4 mr-3"></i>
                        Dashboard
                    </a>
                    <li class="px-3 pt-4 pb-2 text-sm font-semibold text-gray-400 uppercase tracking-wider">
                        Data Master
                    </li>

                    <li class="nav-item">
                        <a class="nav-link flex items-center justify-between px-3 py-2 text-white hover:bg-gray-800 transition cursor-pointer"
                            data-bs-toggle="collapse" href="#navIklan" role="button" aria-expanded="false"
                            aria-controls="navIklan">
                            <span class="flex items-center gap-2">
                                <i data-feather="file-text" class="w-4 h-4"></i>
                                Iklan
                            </span>
                            <i data-feather="chevron-down" class="w-4 h-4 transition-transform duration-200"></i>
                        </a>
                        <div class="collapse" id="navIklan" data-bs-parent="#sideNavbar">
                            <ul class="pl-10 py-2 text-sm space-y-1">

                                <li><a href="{{ route('iklan.index') }}"
                                        class="block text-gray-300 hover:text-white">Informasi Data Iklan</a></li>
                                <li><a href="{{ route('iklandata.index', ['q' => 'home-1']) }}"
                                        class="block text-gray-300 hover:text-white">Halaman Home</a></li>
                                <li><a href="{{ route('iklandata.index', ['q' => 'umkm-1']) }}"
                                        class="block text-gray-300 hover:text-white">Halaman UMKM</a></li>
                                <li><a href="{{ route('iklandata.index', ['q' => 'pariwisata-1']) }}"
                                        class="block text-gray-300 hover:text-white">Halaman Pariwisata</a></li>
                                <li><a href="{{ route('iklandata.index', ['q' => 'event-1']) }}"
                                        class="block text-gray-300 hover:text-white">Halaman Event</a></li>
                                <li><a href="{{ route('iklandata.index', ['q' => 'investasi-1']) }}"
                                        class="block text-gray-300 hover:text-white">Halaman Investasi</a></li>
                                <li><a href="{{ route('iklandata.index', ['q' => 'entertaiment-1']) }}"
                                        class="block text-gray-300 hover:text-white">Halaman Entertainment</a></li>

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
