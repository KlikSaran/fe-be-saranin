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
            <a href="{{ route('baskets-public.index') }}" class="nav-icon" id="navbarKeranjangBtn">
                <i class="fas fa-shopping-cart"></i>
                <span>Keranjang</span>
                {{-- <span class="badge">3</span> --}} {{-- Example for cart count --}}
            </a>

            <a href="{{ route('transactions-public.index') }}" class="nav-icon" id="navbarTransaksiBtn">
                <i class="fas fa-file-invoice"></i>
                <span>Transaksi</span>
            </a>

            @guest {{-- Check if user is a guest (not logged in) --}}
                <a href="{{ route('login') }}" class="nav-icon" id="navbarLoginBtn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
            @else {{-- User is authenticated --}}
                <div class="profile-container">
                    <a href="#" class="nav-icon" id="navbarProfileBtn" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil</span>
                    </a>
                    <div class="profile-dropdown" id="navbarProfileDropdown" aria-labelledby="navbarProfileBtn">
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('dashboards.index') }}"><i class="fas fa-home"></i> Dashboard</a>
                        @endif
                        <div class="divider"></div>
                        <a href="{{ route('profiles-public.index') }}"><i class="fas fa-user-cog"></i> Setting Profil</a>
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

</script>