@extends('index')
@section('content')
    <x-navbar-public :categories="$categories"></x-navbar-public>
    <!-- REKOMENDASI -->
    <section class="recommendation-section">
        <h2>Rekomendasi untuk Anda</h2>
        <div class="recommendation-slider-container">
            <div class="recommendation-slider" id="recommendationSlider"></div>
        </div>
        <div class="slider-controls">
            <button onclick="prevSlide()">
                < <button onclick="nextSlide()">>
            </button>
        </div>
    </section>

    <!-- SEMUA PRODUK -->
    <section class="all-products-section">
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Semua Produk</h2>
        <div class="all-products">
            @foreach ($products as $product)
                <a href="{{ route('products-public.show', $product->id) }}"
                    class="product-card bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy"
                        class="w-full h-48 object-cover">
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                        <p class="product-price text-base font-bold text-blue-600 mb-3">Rp
                            {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        @if($product->stock == 'True' || $product->stock === true || $product->stock == 1)
                            <span class="badge bg-success text-white">Tersedia</span>
                        @else
                            <span class="badge bg-danger text-white">Tidak Tersedia</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    <div class="pagination-container">
        {{ $products->links('components.custom-pagination') }}
    </div>
@endsection