@extends('index')
@section('content')
    <x-navbar-public :categories="$categories"></x-navbar-public>

    @auth
        <section class="recommendation-section" id="recommendation-section">

            <div class="recommendation-container">
                <h1 id="recommendationTitle">
                    Rekomendasi Produk untuk {{ Auth::user()->fullname }}
                </h1>
                <button id="prevBtn" class="slider-button">‹</button>

                <div id="recommendationSlider"></div>

                <button id="nextBtn" class="slider-button">›</button>
            </div>

            @if (Auth::user()->role !== 'admin')
                <div class="recommendation-cb-container" id="recommendation-cb-container">
                    <h1 id="recommendationTitle">
                        Rekomendasi Produk Sesuai Preferensi {{ Auth::user()->fullname }}
                    </h1>
                    <button id="prevCbBtn" class="slider-cb-button">‹</button>

                    <div id="cbRecommendation"></div>

                    <button id="nextCbBtn" class="slider-cb-button">›</button>
                </div>
            @endif
        </section>
    @endauth

    <!-- SEMUA PRODUK -->
    <section class="all-products-section">
        <h1>Semua Produk</h1>
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
        const hasTransactionHistory = {{ $hasTransactionHistory ? 'true' : 'false' }};
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @auth
                                                const loggedInUserId = {{ Auth::user()->id }};
                console.log("ID User Login:", loggedInUserId);

                fetchRecommendations(loggedInUserId);

                if (hasTransactionHistory) {
                    fetchCBRecommendations(loggedInUserId);
                } else {
                    const cbContainer = document.getElementById('recommendation-cb-container');
                    if (cbContainer) {
                        cbContainer.style.display = "none";
                    }
                }
            @else
                                                const recommendationSection = document.getElementById('recommendation-section');
                if (recommendationSection) {
                    recommendationSection.style.display = 'none';
                }
            @endauth

                function fetchRecommendations(userId) {
                    fetch("https://gibbon-direct-neatly.ngrok-free.app/predict", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id_user: userId, count_items: 20 })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("User ID:", data.user_id);
                        console.log("Message:", data.message);
                        console.log("Recommendations:", data.recommendations);

                        const slider = document.getElementById('recommendationSlider');
                        if (!slider) {
                            console.warn("Element recommendationSlider tidak ditemukan di DOM.");
                            return;
                        }

                        slider.innerHTML = '';

                        if (data.recommendations && data.recommendations.length > 0) {
                            renderRecommendations(data.recommendations, slider);
                        } else {
                            slider.innerHTML = "<p>Tidak ada rekomendasi untuk user ini.</p>";
                        }
                    })
                    .catch(error => {
                        console.error("Error /predict:", error);
                        const slider = document.getElementById('recommendationSlider');
                        if (slider) {
                            slider.innerHTML = "<p>Gagal mengambil rekomendasi utama.</p>";
                        }
                    });
                }

            function fetchCBRecommendations(userId) {
                fetch("https://gibbon-direct-neatly.ngrok-free.app/predictcb", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id_user: userId, count_items: 20 })
                })
                    .then(res => res.json())
                    .then(data => {
                        const cbContainer = document.getElementById('cbRecommendation');
                        if (!cbContainer) {
                            console.error("Element with id 'cbRecommendation' not found.");
                            return;
                        }

                        if (data.recommendations && data.recommendations.length > 0) {
                            renderCBRecommendations(data.recommendations, cbContainer);
                        } else {
                            cbContainer.innerHTML = "<p>Tidak ada rekomendasi berbasis preferensi.</p>";
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching CB recommendations:", error);
                    });
            }

            function renderRecommendations(recommendations, container) {
                container.innerHTML = '';
                recommendations.forEach(product => {
                    const item = document.createElement('div');
                    item.className = 'recommendation-item';
                    item.innerHTML = `
                                                <a href="/detail-product-public/${encodeURIComponent(product.name)}" class="recommendation-card-link">
                                                    <div class="product-card">
                                                        <img src="${getProductImage(product)}" alt="${product.name}" loading="lazy" />
                                                        <h3>${product.name}</h3>
                                                        <p>Rp ${parseInt(product.harga).toLocaleString('id-ID')}</p>
                                                        <p>${product.category}</p>
                                                    </div>
                                                </a>
                                            `;
                    container.appendChild(item);
                });
            }

            function renderCBRecommendations(recommendations, container) {
                container.innerHTML = '';
                recommendations.forEach(product => {
                    const item = document.createElement('div');
                    item.className = 'recommendation-item';
                    item.innerHTML = `
                                                <a href="/detail-product-public/${encodeURIComponent(product.name)}" class="recommendation-card-link">
                                                    <div class="product-card">
                                                        <img src="${getProductImage(product)}" alt="${product.name}" loading="lazy" />
                                                        <h3>${product.name}</h3>
                                                        <p>Rp ${parseInt(product.harga).toLocaleString('id-ID')}</p>
                                                        <p>${product.category}</p>
                                                    </div>
                                                </a>
                                            `;
                    container.appendChild(item);
                });
            }

            function getProductImage(product) {
                // Jika `product.image` sudah berupa path seperti 'images/xxx.jpg', cukup return saja
                // Kalau kamu simpan path dari backend beda, sesuaikan di sini
                // Contoh backend mengirim image seperti 'product_name.jpg' maka prefix storage misal:
                return `/storage/${product.image}`;
            }
        });

        document.getElementById('prevBtn').addEventListener('click', () => {
            document.getElementById('recommendationSlider').scrollBy({ left: -250, behavior: 'smooth' });
        });
        document.getElementById('nextBtn').addEventListener('click', () => {
            document.getElementById('recommendationSlider').scrollBy({ left: 250, behavior: 'smooth' });
        });

        document.getElementById('prevCbBtn').addEventListener('click', () => {
            document.getElementById('cbRecommendation').scrollBy({ left: -250, behavior: 'smooth' });
        });
        document.getElementById('nextCbBtn').addEventListener('click', () => {
            document.getElementById('cbRecommendation').scrollBy({ left: 250, behavior: 'smooth' });
        });
    </script>



@endsection