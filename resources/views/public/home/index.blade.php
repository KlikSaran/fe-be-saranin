@extends('index')
@section('content')
    <x-navbar-public :categories="$categories"></x-navbar-public>
    <!-- REKOMENDASI -->
    <section class="recommendation-section">
        <h2>Rekomendasi untuk Anda</h2>
        <div class="recommendation-slider-container">
            {{-- <a href="{{ route('products-public.index') }}">Tes Detail</a> --}}
            <a href="{{ route('products-public.create') }}">Tes Cari Produk</a>
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
                        {{-- Jika ada deskripsi, bisa ditambahkan di sini --}}
                        {{-- <p class="text-sm text-gray-600 mb-3 flex-grow">{{ $product->description ?? 'Tidak ada
                            deskripsi.' }}</p> --}}
                        <p class="product-price text-base font-bold text-blue-600 mb-3">Rp
                            {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        {{-- <a href="{{ route('products-public.show', $product->id) }}" class="detail-button">
                            Lihat Detail
                        </a> --}}
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    <div class="pagination-container">
        {{ $products->links('components.custom-pagination') }}
    </div>
    {{--
    <script>
        // Data Dummy yang lebih realistis
        const dataDummy = [
            {
                nama: "Kemeja Flanel",
                deskripsi: "Kemeja pria bahan flanel nyaman",
                harga: 149000,
                img: "https://images.unsplash.com/photo-1598033129183-c4f50c736f10?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=150&q=80"
            },
            {
                nama: "Celana Jeans",
                deskripsi: "Celana jeans pria model slim",
                harga: 249000,
                img: "https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=150&q=80"
            },
            {
                nama: "Sneakers Sport",
                deskripsi: "Sepatu olahraga nyaman",
                harga: 349000,
                img: "https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=150&q=80"
            },
            {
                nama: "Tas Ransel",
                deskripsi: "Tas laptop anti air",
                harga: 199000,
                img: "https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=150&q=80"
            },
            {
                nama: "Jam Digital",
                deskripsi: "Jam dengan banyak fitur",
                harga: 179000,
                img: "https://images.unsplash.com/photo-1524805444758-089113d48a6d?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=150&q=80"
            },
            {
                nama: "Headphone",
                deskripsi: "Headphone nirkabel HD",
                harga: 299000,
                img: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=150&q=80"
            },
            {
                nama: "Kacamata",
                deskripsi: "UV protection stylish",
                harga: 129000,
                img: "https://images.unsplash.com/photo-1511499767150-a48a237f0083?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=150&q=80"
            },
            {
                nama: "Dompet Kulit",
                deskripsi: "Dompet kulit multifungsi",
                harga: 99000,
                img: "https://images.unsplash.com/photo-1590874103328-eac38a683ce7?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=150&q=80"
            },
            {
                nama: "Kaos Polo",
                deskripsi: "Bahan katun adem",
                harga: 89000,
                img: "https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=150&q=80"
            },
            {
                nama: "Jaket Hoodie",
                deskripsi: "Bahan fleece tebal",
                harga: 189000,
                img: "https://images.unsplash.com/photo-1521223890158-f9f7c3d5d504?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=150&q=80"
            }
        ];

        // === Rekomendasi ===
        const maxRekomendasi = 10;
        let currentSlide = 0;
        let sliderWidth = 0;
        let cardWidth = 0;

        function renderRekomendasi() {
            const container = document.getElementById('recommendationSlider');
            container.innerHTML = '';

            const data = dataDummy.slice(0, maxRekomendasi);
            data.forEach(item => {
                const card = document.createElement('div');
                card.className = 'recommendation-card';
                card.innerHTML = `
                                                                  <img src="${item.img}" alt="${item.nama}" loading="lazy">
                                                                  <h4>${item.nama}</h4>
                                                                  <p>${item.deskripsi}</p>
                                                                  <p class="product-price">${formatRupiah(item.harga)}</p>
                                                                `;
                container.appendChild(card);
            });

            // Hitung ulang dimensi slider setelah render
            setTimeout(() => {
                const slider = document.getElementById('recommendationSlider');
                const card = document.querySelector('.recommendation-card');
                if (card) {
                    cardWidth = card.offsetWidth + 15; // termasuk gap
                    sliderWidth = cardWidth * maxRekomendasi;
                    slider.style.width = `${sliderWidth}px`;
                }
                updateSliderPosition();
            }, 100);
        }

        function updateSliderPosition() {
            const slider = document.getElementById('recommendationSlider');
            const container = document.querySelector('.recommendation-slider-container');
            const containerWidth = container.offsetWidth;
            const maxOffset = sliderWidth - containerWidth;
            const offset = Math.min(currentSlide * containerWidth, maxOffset);

            slider.style.transform = `translateX(-${offset}px)`;
        }

        function nextSlide() {
            const container = document.querySelector('.recommendation-slider-container');
            const containerWidth = container.offsetWidth;
            const maxPossibleSlides = Math.ceil((sliderWidth - containerWidth) / containerWidth);

            if (currentSlide < maxPossibleSlides) {
                currentSlide++;
                updateSliderPosition();
            }
        }

        function prevSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                updateSliderPosition();
            }
        }

        // === Semua Produk ===
        function renderAllProducts() {
            const container = document.getElementById('allProducts');
            container.innerHTML = '';
            dataDummy.forEach(item => {
                const card = document.createElement('div');
                card.className = 'product-card';
                card.innerHTML = `
                                                                  <img src="${item.img}" alt="${item.nama}" loading="lazy">
                                                                  <h4>${item.nama}</h4>
                                                                  <p>${item.deskripsi}</p>
                                                                  <p class="product-price">${formatRupiah(item.harga)}</p>
                                                                `;
                container.appendChild(card);
            });
        }

        // Format Rupiah
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Init dan event listener untuk responsive
        window.addEventListener('DOMContentLoaded', () => {
            renderRekomendasi();
            renderAllProducts();
        });

        window.addEventListener('resize', () => {
            renderRekomendasi();
        });
    </script> --}}
@endsection