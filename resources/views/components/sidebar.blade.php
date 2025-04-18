<nav class="navbar-vertical navbar">
    <div id="myScrollableElement" class="h-screen" data-simplebar>
        <!-- brand logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="./assets/images/brand/logo/logo.svg" alt="" />
        </a>

        <!-- navbar nav -->
        <ul class="navbar-nav flex-col" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link  active " href="{{ route('dashboard') }}">
                    <i data-feather="home" class="w-4 h-4 mr-2"></i>
                    Dashboard
                </a>
            </li>
            <!-- nav item -->
            <li class="nav-item">
                <div class="navbar-heading">Data Master</div>
            </li>
            <!-- nav item -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#!" data-bs-toggle="collapse" data-bs-target="#navPages"
                    aria-expanded="false" aria-controls="navPages">
                    <i data-feather="database" class="w-4 h-4 mr-2"></i>
                    Data Operator
                </a>

                <div id="navPages" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-col">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator', ['jenis' => 'umkm']) }}">OP UMKM</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator', ['jenis' => 'pariwisata']) }}">OP Pariwisata</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator', ['jenis' => 'investasi']) }}">OP Investasi</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator', ['jenis' => 'event']) }}">OP Event</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator', ['jenis' => 'entertainment']) }}">OP Entertainment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operator', ['jenis' => 'boxoffice']) }}">OP Box Office</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- nav item -->
            <li class="nav-item">
                <a class="nav-link " href="#">
                    <i data-feather="user" class="w-4 h-4 mr-2"></i>
                    Data User
                </a>
            </li>

            <!-- nav item -->
            <li class="nav-item">
                <a class="nav-link " href="#">
                    <i data-feather="cast" class="w-4 h-4 mr-2"></i>
                    Data Iklan
                </a>
            </li>

            <!-- nav heading -->
            <li class="nav-item">
                <div class="navbar-heading">Laporan</div>
            </li>
            <!-- nav item -->
            <li class="nav-item">
                <a class="nav-link  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navComponents"
                    aria-expanded="false" aria-controls="navComponents">
                    <i data-feather="file-text" class="w-4 h-4 mr-2"></i>
                    Laporan Bulanan
                </a>
                <div id="navComponents" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-col">
                        <li class="nav-item">
                            <a class="nav-link " href="#">Laporan UMKM</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " href="#">Laporan Pariwisata</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " href="#">Laporan Investas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#">Laporan Event</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#">Laporan Entertainment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#">Laporan Box Office</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
