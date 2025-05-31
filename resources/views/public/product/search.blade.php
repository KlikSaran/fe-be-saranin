@extends('index')
@section('content')
    <x-navbar-public :categories="$categories"></x-navbar-public>
    <div class="search-products-wrapper">
        <div class="search-header">
            <h2 class="search-title">Jelajahi Produk Kami</h2>
        </div>

        <div class="search-container">
            <div class="filters">
                <div class="filter-section">
                    <h3 class="filter-title">Harga</h3>
                    <div class="price-inputs">
                        <input type="number" id="minPrice" placeholder="Harga Minimum" value="">
                        <input type="number" id="maxPrice" placeholder="Harga Maksimum" value="">
                    </div>
                </div>

                <div class="filter-section">
                    <h3 class="filter-title">Kategori</h3>
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
            <div class="card-container">
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
                            <p class="product-description">{{ $product->description ?? '-' }}</p>
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

            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    form.submit();
                });
            });
        });
    </script>


@endsection