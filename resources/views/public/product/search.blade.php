@extends('index')
@section('content')
    <x-navbar-public :categories="$categories"></x-navbar-public>
    <div class="search-products-wrapper">
        <div class="search-header">
            <h2 class="search-title">Filter</h2>
        </div>

        <div class="search-container">
            <div class="filters">
                <div class="filter-section open" id="hargaFilter">
                    <h3 class="filter-title">
                        Harga
                        <span class="dropdown-arrow">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </span>
                    </h3>
                    <div class="filter-content">
                        <form id="priceFilterForm" action="{{ route('search.consumer.product') }}" method="GET">
                            <div class="price-inputs">
                                <input type="number" id="minPrice" name="minimum_price"
                                    value="{{ old('minimum_price', $minimum_price ?? '') }}" placeholder="Harga Minimum"
                                    min="0" required>

                                <input type="number" id="maxPrice" name="maksimum_price"
                                    value="{{ old('maksimum_price', $maksimum_price ?? '') }}" placeholder="Harga Maksimum"
                                    min="0" required>

                                <button type="submit" class="pay-btn">Filter</button>
                            </div>
                        </form>

                    </div>
                </div>

                <hr>

                <div class="filter-section" id="kategoriFilter">
                    <h3 class="filter-title">
                        Kategori
                        <span class="dropdown-arrow">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </span>
                    </h3>
                    <div class="filter-content">
                        <form id="categoryFilterForm" action="{{ route('search.consumer.product') }}" method="GET">
                            @php
                                $isAllChecked = empty($currentCategoryName) || $currentCategoryName === 'Semua Kategori';
                            @endphp
                            <div class="filter-option">
                                <input type="radio" id="all" name="category" value="" {{ $isAllChecked ? 'checked' : '' }}>
                                <label for="all">Semua Kategori</label>
                            </div>

                            @foreach ($categories as $index => $category)
                                @php
                                    $categoryValue = $category['category'];
                                    $isChecked = ($currentCategoryName ?? 'Semua Kategori') === $categoryValue;
                                @endphp
                                <div class="filter-option">
                                    <input type="radio" id="cat{{ $index }}" name="category" value="{{ $categoryValue }}" {{ $isChecked ? 'checked' : '' }}>
                                    <label for="cat{{ $index }}">{{ $categoryValue }}</label>
                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-container">
                @if($products->isEmpty())
                    <div class="no-products">
                        <h3>Produk tidak ditemukan</h3>
                        <p>Silakan cari produk lainnya.</p>
                    </div>
                @endif
                @foreach ($products as $product)
                    <a href="{{ route('products-public.show', $product->id) }}" class="product-card"
                        data-category="{{ strtolower($product->category ?? '') }}" data-price="{{ $product->price ?? 0 }}"
                        data-name="{{ strtolower($product->name ?? '') }}">
                        <div class="product-image-wrapper">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy"
                                    class="product-image">
                            @else
                                <div class="product-image-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="product-content-wrapper">
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            @if($product->stock == 'True' || $product->stock === true || $product->stock == 1)
                                <span class="badge bg-success text-white">Tersedia</span>
                            @else
                                <span class="badge bg-danger text-white">Tidak Tersedia</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="pagination-container">
        {{ $products->links('components.custom-pagination') }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll('input[name="category"]');
            const form = document.getElementById('categoryFilterForm');

            // Kembalikan state open dari localStorage
            const openSectionId = localStorage.getItem('openFilterSection');
            if (openSectionId) {
                const openSection = document.getElementById(openSectionId);
                if (openSection) openSection.classList.add('open');
            }

            // Ketika radio diklik
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    // Simpan section filter yang terbuka sebelum reload
                    const section = radio.closest('.filter-section');
                    if (section && section.id) {
                        localStorage.setItem('openFilterSection', section.id);
                    }
                    form.submit();
                });
            });

            // Toggle buka/tutup manual
            document.querySelectorAll('.filter-title').forEach(title => {
                title.addEventListener('click', () => {
                    const section = title.parentElement;
                    section.classList.toggle('open');

                    // Simpan atau hapus state terbuka
                    if (section.classList.contains('open') && section.id) {
                        localStorage.setItem('openFilterSection', section.id);
                    } else if (section.id) {
                        localStorage.removeItem('openFilterSection');
                    }
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('priceFilterForm');

            ['minPrice', 'maxPrice'].forEach(id => {
                const input = document.getElementById(id);
                input.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function toggleRpLabel(wrapperId, inputId) {
                const wrapper = document.getElementById(wrapperId);
                const input = document.getElementById(inputId);

                const updateVisibility = () => {
                    if (input.value.trim() !== '') {
                        wrapper.classList.add('show');
                    } else {
                        wrapper.classList.remove('show');
                    }
                };

                input.addEventListener('input', updateVisibility);
                updateVisibility();
            }

            toggleRpLabel('minPriceWrapper', 'minPrice');
            toggleRpLabel('maxPriceWrapper', 'maxPrice');
        });
    </script>

@endsection