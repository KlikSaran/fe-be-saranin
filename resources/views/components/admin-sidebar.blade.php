<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header d-flex justify-content-center">
            {{-- <a href="{{ route('client_admin.index') }}" class="b-brand text-primary"></a> --}}
            <img src="{{ asset('assets_admin/images/favicon.svg') }}" alt="saranin.id logo" class="img-fluid"
                width="50%">
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{ route('dashboards.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-plant-2"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Pages</label>
                    <i class="ti ti-news"></i>
                </li>
                {{-- <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-menu"></i></span><span
                            class="pc-mtext">Beranda</span><span class="pc-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="">
                                <span class="pc-micon"><i class="ti ti-user"></i></span>
                                <span class="pc-mtext">Tambah Klien</span>
                            </a>
                        </li>
                        <li class="pc-item"><a class="pc-link" href="">
                                <span class="pc-micon"><i class="ti ti-users"></i></span>
                                <span class="pc-mtext">Tambah Tim</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class="pc-item">
                    <a href="{{ route('products.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-plant-2"></i></span>
                        <span class="pc-mtext">Data Produk</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('transactions.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-lock"></i></span>
                        <span class="pc-mtext">Data Transaksi</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('consumers.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                        <span class="pc-mtext">Data Pelanggan</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                        <span class="pc-mtext">Hubungi Kami</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Logout</label>
                    <i class="ti ti-brand-chrome"></i>
                </li>
                <li class="pc-item">
                    <form method="POST" action="#">
                        @csrf
                        <button type="submit" class="pc-link" style="border: none; background: none; cursor: pointer;">
                            <div class="logout-menu" id="logout-menu">
                                <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                                <span class="pc-mtext">Logout</span>
                            </div>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>