@props(['categories' => []])

<head>
    {{-- It's better to include Font Awesome in your main layout file (e.g., app.blade.php) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Link to your compiled CSS if you move styles to a separate file --}}
    {{--
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>



<div class="navbar-component-wrapper">
    <nav>
        <a href="{{ url('/') }}" class="nav-brand">Saranin.Id</a>

        <button class="kategori-btn" id="navbarKategoriBtn">
            <i class="fas fa-bars"></i><span>Kategori</span>
        </button>

        <div class="kategori-dropdown" id="navbarKategoriDropdown">
            <div class="kategori-grid">
                @if(!empty($categories))
                    @foreach ($categories as $category)
                        {{-- <input type="hidden" name="selected_categories" id="selectedCategoriesInput"> --}}
                        <a href="#" class="kategori-card" data-category="{{ $category['category'] }}">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->category }}">
                            <span>{{ $category['category'] }}</span>
                        </a>
                    @endforeach
                @else
                    <p>Tidak ada kategori tersedia.</p>
                @endif
            </div>
        </div>

        <form action="{{ route('search.consumer.product') }}" method="get" class="container-search" id="searchForm">
            {{-- @csrf tidak diperlukan untuk method="get" --}}
            <input type="text" id="navbarInputSearch" placeholder="Cari nama produk..." name="query" aria-label="Search"
                aria-describedby="search-addon" value="{{ request('query') ?? '' }}" onkeyup="handleSearchInput()"
                autofocus>
            <button type="submit" id="navbarBtnSearch"><i class="fas fa-search"></i></button>
        </form>

        <div class="nav-icons">
            <a href="{{ route('index') }}" class="nav-icon {{ request()->routeIs('index') ? 'active' : '' }}"
                id="navbarBerandaBtn">
                <i class="fas fa-home"></i>
                <span>Beranda</span>
            </a>

            <a href="{{ route('baskets-public.index') }}"
                class="nav-icon {{ request()->routeIs('baskets-public.index') ? 'active' : '' }}"
                id="navbarKeranjangBtn" style="position: relative;">
                <i class="fas fa-shopping-cart"></i>
                <span>Keranjang</span>

                @if(isset($cartCount) && $cartCount > 0)
                    <span class="badge-cart">{{ $cartCount }}</span>
                @endif
            </a>

            <a href="{{ route('transactions-public.index') }}"
                class="nav-icon {{ request()->routeIs('transactions-public.index') ? 'active' : '' }}"
                id="navbarTransaksiBtn">
                <i class="fas fa-file-invoice"></i>
                <span>Transaksi</span>
            </a>

            @guest
                <a href="{{ route('login') }}" class="nav-icon {{ request()->routeIs('login') ? 'active' : '' }}"
                    id="navbarLoginBtn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
                <a href="{{ route('register.form') }}"
                    class="nav-icon {{ request()->routeIs('register.form') ? 'active' : '' }}" id="navbarLoginBtn">
                    <i class="fas fa-user-plus"></i>
                    <span>Register</span>
                </a>
            @else
                <div class="profile-container">
                    <a href="#" class="nav-icon" id="navbarProfileBtn" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil</span>
                    </a>
                    <div class="profile-dropdown" id="navbarProfileDropdown" aria-labelledby="navbarProfileBtn">
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('dashboards.index') }}"
                                class="{{ request()->routeIs('dashboards.index') ? 'active' : '' }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        @endif
                        <div class="divider"></div>
                        <a href="{{ route('profiles-public.index') }}"
                            class="{{ request()->routeIs('profiles-public.index') ? 'active' : '' }}">
                            <i class="fas fa-user-cog"></i> Edit Profil
                        </a>
                        <div class="divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" id="logoutBtn">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>

        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="nav-mobile-menu" id="mobileMenu">
            <form action="{{ route('search.consumer.product') }}" method="get" class="mobile-search">
                <input type="text" name="query" placeholder="Cari produk..." value="{{ request('query') ?? '' }}">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>

            <a href="{{ route('index') }}">Beranda</a>

            <div class="mobile-kategori-wrapper">
                <button class="kategori-btn" id="mobileKategoriBtn">
                    <i class="fas fa-bars"></i><span>Kategori</span>
                </button>
                <div class="kategori-dropdown" id="mobileKategoriDropdown">
                    <div class="kategori-grid">
                        @foreach ($categories ?? [] as $category)
                            <a href="#" class="kategori-card" data-category="{{ $category['category'] }}">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->category }}">
                                <span>{{ $category['category'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <a href="{{ route('baskets-public.index') }}">Keranjang</a>
            <a href="{{ route('transactions-public.index') }}">Transaksi</a>

            @guest
                <a href="{{ route('login') }}">Login</a>
            @else
                <a href="{{ route('profiles-public.index') }}">Edit Profil</a>
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('dashboards.index') }}">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-mobile-btn">Logout</button>
                </form>
            @endguest
        </div>
    </nav>
</div>

<script>
    let searchTimeout;
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('navbarInputSearch');

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('navbarInputSearch');
        const searchForm = document.getElementById('searchForm');

        if (searchInput && searchForm) {
            searchInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.keyCode === 13) {
                    event.preventDefault();

                    searchForm.submit();
                }
            });
        }
    });

    function handleSearchInput() {
        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(() => {
            if (searchInput.value === '') {
                searchForm.submit();
            }
        }, 500);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const kategoriCards = document.querySelectorAll('.kategori-card');

        kategoriCards.forEach(function (card) {
            card.addEventListener('click', function (e) {
                e.preventDefault();

                const category = this.getAttribute('data-category');

                const searchUrl = `{{ route('search.consumer.product') }}?category=${encodeURIComponent(category)}`;
                window.location.href = searchUrl;
            });
        });
    });

    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileKategoriBtn = document.getElementById('mobileKategoriBtn');
    const mobileKategoriDropdown = document.getElementById('mobileKategoriDropdown');

    hamburger.addEventListener('click', () => {
        mobileMenu.classList.toggle('show');
    });

    if (mobileKategoriBtn && mobileKategoriDropdown) {
        mobileKategoriBtn.addEventListener('click', (e) => {
            e.preventDefault();
            mobileKategoriDropdown.classList.toggle('show');
        });
    }
</script>