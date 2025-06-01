@extends('index')
@section('content')
    <x-navbar-public :categories="$categories"></x-navbar-public>
    <!-- REKOMENDASI -->
    <section class="recommendation-section" id="recommendation-section">
        @auth
            <h2>
                Rekomendasi Produk buat {{ Auth::user()->fullname }}
            </h2>
        @endauth

        <div class="recommendation-container">
            <button id="prevBtn" class="slider-button">‹</button>

            <div id="recommendationSlider">
                <!-- Kartu rekomendasi akan di-render di sini -->
            </div>

            <button id="nextBtn" class="slider-button">›</button>
        </div>

    </section>

    <!-- SEMUA PRODUK -->
    <section class="all-products-section">
        <h2>Semua Produk</h2>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @auth
                fetchRecommendations({{ Auth::user()->id }});
            @else
                                                                                                                                                                                                                                            const recommendationSection = document.getElementById('recommendation-section');
                if (recommendationSection) {
                    recommendationSection.style.display = 'none'; // Sembunyikan jika tidak login
                }
            @endauth
                                                                                                                });

        function fetchRecommendations(userId) {
            fetch("http://127.0.0.1:5000/predict", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id_user: userId,
                    count_items: 20
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.recommendations && data.recommendations.length > 0) {
                        const slider = document.getElementById('recommendationSlider');
                        slider.innerHTML = '';

                        data.recommendations.forEach(product => {
                            const item = document.createElement('div');
                            item.className = 'recommendation-item';
                            item.innerHTML = `
                                                                                    <a href="/products/${product.name}" class="recommendation-card-link">
                                                                                        <div class="recommendation-card">
                                                                                            <h3>${product.name}</h3>
                                                                                            <p>${product.category}</p>
                                                                                            <small>✨ ${product.trusted_score.toFixed(2)}</small>
                                                                                        </div>
                                                                                    </a>
                                                                                `;
                            slider.appendChild(item);
                        });
                    } else {
                        document.getElementById('recommendationSlider').innerHTML = "<p>Tidak ada rekomendasi tersedia.</p>";
                    }
                })
                .catch(error => {
                    console.error("Error fetching recommendations:", error);
                });
        }
    </script>

    <script>
        document.getElementById('prevBtn').addEventListener('click', function () {
            document.getElementById('recommendationSlider').scrollBy({
                left: -250,
                behavior: 'smooth'
            });
        });

        document.getElementById('nextBtn').addEventListener('click', function () {
            document.getElementById('recommendationSlider').scrollBy({
                left: 250,
                behavior: 'smooth'
            });
        });
    </script>


@endsection