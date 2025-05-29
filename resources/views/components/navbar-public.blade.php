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

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background-color: #f5f5f5;
        padding: 0;
        margin: 0;
    }

    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 5%;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    nav h2 {
        color: #333;
        font-weight: 700;
        font-size: 20px;
    }

    .kategori-btn {
        background-color: transparent;
        border: 2px solid #3734a9;
        border-radius: 20px;
        font-weight: 500;
        cursor: pointer;
        padding: 8px 16px;
        transition: all 0.3s;
        color: #555;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .kategori-btn:hover {
        background: #3734a9;
        color: white;
    }

    .kategori-btn.active {
        background: #3734a9;
        color: white;
        font-weight: 600;
    }

    .kategori-dropdown {
        position: absolute;
        top: 100%;
        left: 5%;
        width: 90%;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: none;
        z-index: 100;
    }

    .kategori-dropdown.show {
        display: block;
    }

    .kategori-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }

    .kategori-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px;
        border-radius: 8px;
        transition: all 0.3s;
        cursor: pointer;
        text-decoration: none;
        color: #333;
        border: 1px solid #eee;
    }

    .kategori-card:hover {
        background-color: #f5f5f5;
        transform: translateY(-3px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .kategori-card img {
        width: 50px;
        height: 50px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .kategori-card span {
        font-size: 14px;
        text-align: center;
        font-weight: 500;
    }

    .container-search {
        display: flex;
        align-items: center;
        width: 40%;
    }

    #input-search {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 20px 0 0 20px;
        outline: none;
        font-size: 14px;
    }

    #btn-search {
        background-color: #f0f0f0;
        border: 1px solid #ddd;
        border-left: none;
        border-radius: 0 20px 20px 0;
        padding: 10px 15px;
        cursor: pointer;
        transition: all 0.3s;
        color: #555;
    }

    #btn-search:hover {
        background-color: #e0e0e0;
    }

    .nav-icons {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .nav-icon {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: #555;
        font-size: 12px;
        transition: all 0.3s;
        font-weight: 500;
    }

    .nav-icon i {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .nav-icon:hover {
        color: #3734a9;
    }

    .profile-container {
        position: relative;
    }

    .profile-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 10px 0;
        width: 180px;
        display: none;
        z-index: 100;
    }

    .profile-container:hover .profile-dropdown {
        display: block;
    }

    .profile-dropdown a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        text-decoration: none;
        color: #555;
        transition: all 0.3s;
        font-size: 14px;
    }

    .profile-dropdown a:hover {
        background-color: #f5f5f5;
        color: #3734a9;
    }

    .divider {
        height: 1px;
        background-color: #eee;
        margin: 5px 0;
    }

    #navbarInputSearch {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        outline: none;
        font-size: 14px;
    }

    #navbarBtnSearch {
        background-color: #f0f0f0;
        border: 1px solid #ddd;
        border-left: none;
        border-radius: 0 20px 20px 0;
        padding: 10px 15px;
        cursor: pointer;
        transition: all 0.3s;
        color: #555;
    }

    .nav-brand {
        text-decoration: none;
        color: inherit;
    }

    #logoutBtn {
        display: flex;
        background: none;
        border: none;
        color: #555;
        font-size: 14px;
        cursor: pointer;
        padding: 10px 20px;
        width: 100%;
        gap: 10px;
        align-items: center;
    }

    @media (max-width: 768px) {
        .container-search {
            display: none;
        }

        .nav-icons {
            gap: 15px;
        }
    }
</style>

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
                        <a href="{{-- {{ route('category.show', ['slug' => $category['slug'] ?? Str::slug($category['name'])]) }} --}}#"
                            class="kategori-card" data-category="{{ $category['name'] }}">
                            <img src="{{ $category['icon'] }}" alt="{{ $category['name'] }}"
                                onerror="this.src='https://placehold.co/50x50/EFEFEF/A9A9A9?text=Icon'; this.onerror=null;">
                            <span>{{ $category['name'] }}</span>
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
                        <a href="{{-- {{ route('profile.edit') }} --}}#"><i class="fas fa-user-cog"></i> Setting Profil</a>
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

{{-- It's better to include JS at the end of your body in the main layout file --}}
{{--
<script src="{{ asset('js/navbar.js') }}"></script> --}}