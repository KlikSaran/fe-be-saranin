{{-- resources/views/components/navbar.blade.php --}}
{{--
This Blade component assumes you pass a $categories array from your controller.
Example in controller:
$categories = [
[
'name' => 'Komputer & Aksesoris',
'icon' => 'https://cdn-icons-png.flaticon.com/512/2203/2203270.png',
'slug' => 'komputer-aksesoris' // Optional: for cleaner URLs
],
// ... other categories
];
return view('your-page', compact('categories'));

Then in your main Blade file, you can include it like:
<x-navbar :categories="$categories" />
or
@include('components.navbar', ['categories' => $categories])
--}}

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
            <i class="fas fa-bars"></i> <span>Kategori</span>
        </button>

        <div class="kategori-dropdown" id="navbarKategoriDropdown">
            <div class="kategori-grid">
                @if(!empty($categories))
                    @foreach ($categories as $category)
                        {{-- <input type="hidden" name="selected_categories" id="selectedCategoriesInput"> --}}
                        <a href="#" class="kategori-card" data-category="{{ $category['category'] }}">
                            <img src="{{ $category['icon'] }}" alt="{{ $category['category'] }}"
                                onerror="this.src='https://placehold.co/50x50/EFEFEF/A9A9A9?text=Icon'; this.onerror=null;">
                            <span>{{ $category['category'] }}</span>
                        </a>
                    @endforeach
                @else
                    <p>Tidak ada kategori tersedia.</p>
                @endif
            </div>
        </div>

        <div class="container-search">
            <input type="text" id="navbarInputSearch" placeholder="Cari produk...">
            <button id="navbarBtnSearch"><i class="fas fa-search"></i></button>
        </div>

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

