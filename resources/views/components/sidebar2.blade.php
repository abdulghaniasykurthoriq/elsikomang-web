@php
    $user = Auth::user();

    $pathRole = $user->jenisOperator->url_parameter ?? 'dashboard'; // e.g. 'umkm', 'pariwisata'
    $labelRole = $user->jenisOperator->name ?? 'Dashboard'; // e.g. 'Umkm', 'Pariwisata'
@endphp


<nav class="navbar-vertical navbar">
    <div id="myScrollableElement" class="h-screen" data-simplebar>

        <!-- Logo -->
        <a class="navbar-brand text-xl font-bold text-white-800" href="{{ url($pathRole . '/dashboard') }}">
            Operator {{ $labelRole }}
        </a>

        <!-- Sidebar Items -->
        <ul class="navbar-nav flex-col" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link" href="{{ url($pathRole . '/dashboard') }}">
                    <i data-feather="home" class="w-4 h-4 mr-2"></i>
                    Dashboard
                </a>
            </li>

            <!-- // sidebar umkm -->
            @if (Auth::user()->jenis_operator_id == 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('umkm/produk') }}">
                        <i data-feather="package" class="w-4 h-4 mr-2"></i>
                        Data Produk
                    </a>
                </li>


            <!-- // sidebar parawisata -->
            @elseif (Auth::user()->jenis_operator_id == 2)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('operator.pariwisata.data.index', ['jenis' => 'pariwisata']) }}">
                        <i data-feather="map-pin" class="w-4 h-4 mr-2"></i>
                        Data Parawisata
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('operator.pariwisata.laporan.index', ['jenis' => 'pariwisata']) }}">
                        <i data-feather="file-text" class="w-4 h-4 mr-2"></i>
                        Laporan Parawisata
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('operator.pariwisata.rekomendasi', ['jenis' => 'pariwisata']) }}">
                        <i data-feather="star" class="w-4 h-4 mr-2"></i>
                        Rekomendasi Wisata
                    </a>
                </li>


            <!-- // sidebar investasi -->
            @elseif (Auth::user()->jenis_operator_id == 3)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('umkm/produk') }}">
                        <i data-feather="file-text" class="w-4 h-4 mr-2"></i>
                        Laporan investasi
                    </a>
                </li>


            <!-- // sidebar event -->
            @elseif (Auth::user()->jenis_operator_id == 4)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('umkm/produk') }}">
                        <i data-feather="file-text" class="w-4 h-4 mr-2"></i>
                        Data Event
                    </a>
                </li>


            <!-- // sidebar entertainment -->
            @elseif (Auth::user()->jenis_operator_id == 5)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('umkm/produk') }}">
                        <i data-feather="file-text" class="w-4 h-4 mr-2"></i>
                        Data Entertainment
                    </a>
                </li>


            <!-- // sidebar box office -->
            @elseif (Auth::user()->jenis_operator_id == 6)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('umkm/produk') }}">
                        <i data-feather="file-text" class="w-4 h-4 mr-2"></i>
                        data box office
                    </a>
                </li>
            @endif

            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="nav-link text-danger" type="submit">
                        <i data-feather="log-out" class="w-4 h-4 mr-2"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
