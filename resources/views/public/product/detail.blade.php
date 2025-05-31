@extends('index')
@section('content')
    <x-navbar-public :categories="$categories"></x-navbar-public>
    <div class="product-container">
        <!-- Kolom Gambar Produk -->
        <div class="product-image-container">
            <div class="product-images">
                <img src="{{ asset('storage/' . $productDetail->image) }}" alt="{{ $productDetail->name }}" loading="lazy"
                    id="zoomImage" class="main-image">
            </div>
        </div>

        <!-- Kolom Detail Produk -->
        <div class="product-details" data-id="{{ $productDetail->id }}" data-price="{{ $productDetail->price }}"
            data-stock="{{ $productDetail->stock }}">

            <h1 class="product-title">{{ $productDetail->name }}</h1>
            <div class="product-price">Rp {{ number_format($productDetail->price, 0, ',', '.') }}</div>

            <h3 class="section-title">Deskripsi:</h3>
            <p class="product-description">{{ $productDetail->description }}</p>
        </div>

        <!-- Kolom Pemesanan -->
        <div class="order-card" id="orderCard">
            <h3 class="section-title">Atur Jumlah</h3>

            <form action="{{ route('products-public.store') }}" method="POST">
                @csrf
                {{-- Hanya yang diperlukan --}}
                <input type="hidden" name="product_id" value="{{ $productDetail->id }}">
                <input type="hidden" name="price" value="{{ $productDetail->price }}">
                <input type="hidden" name="total_price" id="totalPriceInput" value="{{ $productDetail->price }}">

                {{-- Kontrol Kuantitas --}}
                <div class="quantity-control">
                    <div class="quantity-btn minus">-</div>
                    <input type="number" name="quantity" class="quantity-input" id="quantityInput" value="1" min="1"
                        data-price="{{ $productDetail->price }}" readonly>
                    <div class="quantity-btn plus">+</div>
                </div>

                {{-- Subtotal Tampilan --}}
                <div class="subtotal">
                    <span class="subtotal-label">SubTotal:</span>
                    <span class="subtotal-price">Rp {{ number_format($productDetail->price, 0, ',', '.') }}</span>
                </div>

                {{-- Tombol Submit --}}
                <div class="action-buttons">
                    <button type="submit" class="btn btn-cart">+ Keranjang</button>
                </div>
            </form>

            <form action="{{ route('checkout.preview') }}" method="get">
                <input type="hidden" name="product_id" id="productIdInput">
                <input type="hidden" name="quantity" id="transQuantity">
                <input type="hidden" name="subtotals" id="transSubtotals">
                <input type="hidden" name="total_price" id="totalPriceInput">
                <button type="submit" class="pay-btn" id="payButton">Beli Langsung</button>
            </form>



        </div>
    </div>

    <!-- Section Rekomendasi Produk Sejenis -->
    <div class="recommendation-section">
        <h2 class="recommendation-title">Produk Serupa Lainnya</h2>
        <div class="recommendation-grid" id="similarProducts">
            @foreach ($productSimilar as $similar)
                <a href="{{ route('products-public.show', $similar->id) }}" class="product-card">
                    <img src="{{ asset('storage/' . $similar->image) }}" alt="{{ $similar->name }}" loading="lazy">
                    <h4>{{ $similar->name }}</h4>
                    <p>{{ $similar->description }}</p>
                    <div class="recommendation-price">Rp{{ number_format($similar->price, 0, ',', '.') }}</div>
                    @if($similar->stock == 'True' || $similar->stock === true || $similar->stock == 1)
                        <span class="badge bg-success text-white">Tersedia</span>
                    @else
                        <span class="badge bg-danger text-white">Tidak Tersedia</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.querySelector(".product-image-container");
            const img = document.getElementById("zoomImage");

            if (!container || !img) {
                console.error("Image container or zoom image not found!");
                return;
            }

            const zoomLevel = 1.8;

            container.addEventListener("mouseenter", function () {
                img.style.transform = `scale(${zoomLevel})`;
            });

            container.addEventListener("mousemove", function (e) {
                const rect = container.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const imgScaledWidth = img.offsetWidth * zoomLevel;
                const imgScaledHeight = img.offsetHeight * zoomLevel;

                const maxPanX = (imgScaledWidth - container.offsetWidth) / 2;
                const maxPanY = (imgScaledHeight - container.offsetHeight) / 2;

                const percentX = x / container.offsetWidth;
                const percentY = y / container.offsetHeight;

                let translateX =
                    -(percentX * (imgScaledWidth - container.offsetWidth)) + maxPanX;
                let translateY =
                    -(percentY * (imgScaledHeight - container.offsetHeight)) + maxPanY;

                img.style.transformOrigin = `${percentX * 100}% ${percentY * 100}%`;
                img.style.transform = `scale(${zoomLevel})`;
                img.style.transformOrigin = `${(x / container.offsetWidth) * 100}% ${(y / container.offsetHeight) * 100
                    }%`;
            });

            container.addEventListener("mouseleave", function () {
                img.style.transform = "scale(1)";
                img.style.transformOrigin = "center center";
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const minusBtn = document.querySelector('.quantity-btn.minus');
            const plusBtn = document.querySelector('.quantity-btn.plus');
            const quantityInput = document.querySelector('.quantity-input');
            const subtotalDisplay = document.querySelector('.subtotal-price');
            const totalPriceInput = document.getElementById('totalPriceInput');

            const basePrice = parseFloat(quantityInput.dataset.price);
            let quantity = parseInt(quantityInput.value);

            function updateSubtotal() {
                const subtotal = basePrice * quantity;
                subtotalDisplay.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                totalPriceInput.value = subtotal;
            }

            function updateButtonState() {
                if (quantity <= 1) {
                    minusBtn.disabled = true;
                    minusBtn.style.cursor = 'not-allowed';
                    minusBtn.style.opacity = '0.5';
                } else {
                    minusBtn.disabled = false;
                    minusBtn.style.cursor = 'pointer';
                    minusBtn.style.opacity = '1';
                }
            }

            plusBtn.addEventListener('click', () => {
                quantity++;
                quantityInput.value = quantity;
                updateSubtotal();
                updateButtonState();
            });

            minusBtn.addEventListener('click', () => {
                if (quantity > 1) {
                    quantity--;
                    quantityInput.value = quantity;
                    updateSubtotal();
                    updateButtonState();
                }
            });

            updateSubtotal();
            updateButtonState();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const payButton = document.getElementById('payButton');
            const quantityInput = document.getElementById('quantityInput');

            payButton.addEventListener('click', (e) => {
                const productDetail = document.querySelector('.product-details');
                const id = productDetail.dataset.id;
                const price = parseInt(productDetail.dataset.price);
                const quantity = parseInt(quantityInput.value);

                const subtotal = price * quantity;

                document.getElementById('productIdInput').value = id;
                document.getElementById('transQuantity').value = quantity;
                document.getElementById('transSubtotals').value = subtotal;
                document.getElementById('totalPriceInput').value = subtotal;
            });
        });

    </script>
@endsection