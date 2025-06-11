<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header d-flex justify-content-center">
            <a href="{{ route('dashboards.index') }}" class="b-brand text-black">saranin.id</a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{ route('dashboards.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-home"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Pages</label>
                    <i class="ti ti-news"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('products.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-package"></i></span>
                        <span class="pc-mtext">Data Produk</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('transactions.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-receipt"></i></span>
                        <span class="pc-mtext">Data Transaksi</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('consumers.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Data Pelanggan</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Logout</label>
                    <i class="ti ti-brand-chrome"></i>
                </li>
                <li class="pc-item">
                    <form method="POST" action="{{ route('logout') }}">
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