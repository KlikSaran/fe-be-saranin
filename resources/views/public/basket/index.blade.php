@extends('index')

@section('content')
    <x-navbar-public :categories="$categories"></x-navbar-public>

    <div class="main-container">
        <div class="cart-list">
            <header class="cart-header">
                <h2>Keranjang</h2>
                <label class="select-all">
                    <input type="checkbox" id="selectAllCheckbox">
                    Pilih Semua (<span id="selectedCountSpan">0</span>)
                </label>
            </header>

            <div id="cart-items-container">
                @if($getBasket)
                    @foreach($getBasket as $item)
                        @if($item->product)
                            <a href="{{ route('products-public.show', $item->product->id) }}" class="cart-item-link">
                                <div class="cart-item" data-id="{{ $item->id }}" data-product-id="{{ $item->product->id }}"
                                    data-price="{{ $item->product->price }}" data-stock="{{ $item->product->stock }}">

                                    <input type="checkbox" class="item-check" data-id="{{ $item->id }}">

                                    <div class="item-image">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                                            loading="lazy" id="zoomImage" style="width: 80px; height: 80px;">
                                    </div>
                                    <div class="item-info">
                                        <h3 class="item-name">{{ $item->product->name }}</h3>
                                        <div class="item-price">Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
                                    </div>

                                    <div class="item-actions">
                                        <div class="item-stock">
                                            <div class="quantity-btn minus">-</div>
                                            <input type="number" name="quantity" class="quantity-input" value="{{ $item->quantity }}"
                                                min="1" data-id="{{ $item->id }}" readonly>
                                            <div class="quantity-btn plus">+</div>
                                        </div>
                                        <button class="delete-btn" data-id="{{ $item->id }}" aria-label="Hapus item">🗑️</button>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                @else
                    <p style="text-align:center; padding: 20px; color: #777;">Keranjang Anda kosong.</p>
                @endif

            </div>
        </div>

        <div class="summary-card">
            <h3 class="summary-title">Ringkasan Belanja</h3>
            <form action="{{ route('checkout.preview') }}" method="get">
                @csrf
                <input type="hidden" name="detail_transaction_id" id="transId" value="">
                <input type="hidden" name="quantity" id="transQuantity" value="">
                <input type="hidden" name="subtotals" id="transSubtotals">
                <input type="hidden" name="total_price" id="totalPriceInput">
                <div class="total-section">
                    <span class="total-label">Total</span>
                    <span class="total-price" id="totalPriceSpan">Rp 0</span>
                </div>
                <button class="pay-btn" id="payButton">
                    Beli (<span id="totalSelectedItemsCountSpan">0</span>)
                </button>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const selectedCountSpan = document.getElementById('selectedCountSpan');
            const totalItemsCountSpan = document.getElementById('totalSelectedItemsCountSpan');
            const totalPriceSpan = document.getElementById('totalPriceSpan');
            const payButton = document.getElementById('payButton');
            const cartItems = Array.from(document.querySelectorAll('.cart-item'));
            const transQuantityInput = document.getElementById('transQuantity');

            if (cartItems.length > 0) {
                const firstCheckbox = cartItems[0].querySelector('.item-check');
                if (firstCheckbox) firstCheckbox.checked = true;
            }
            function getSelectedItems() {
                return cartItems.filter(item => {
                    const checkbox = item.querySelector('.item-check');
                    return checkbox && checkbox.checked;
                });
            }

            function updateSummary() {
                const selectedItems = getSelectedItems();
                const totalSelected = selectedItems.length;

                let totalPrice = 0;
                let totalQuantity = 0;

                let selectedIds = [];
                let quantities = [];
                let subtotals = [];

                selectedItems.forEach(item => {
                    const price = parseInt(item.dataset.price);
                    const quantityInput = item.querySelector('.quantity-input');
                    const quantity = parseInt(quantityInput.value);
                    const id = item.dataset.id;

                    const subtotal = price * quantity;

                    totalPrice += subtotal;
                    totalQuantity += quantity;

                    selectedIds.push(id);
                    quantities.push(quantity);
                    subtotals.push(subtotal);
                });

                // Update elemen DOM
                selectedCountSpan.textContent = totalSelected;
                totalItemsCountSpan.textContent = totalQuantity;
                totalPriceSpan.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');

                document.getElementById('totalPriceInput').value = totalPrice;
                document.getElementById('transQuantity').value = quantities.join(',');
                document.getElementById('transId').value = selectedIds.join(',');

                const transSubtotalsInput = document.getElementById('transSubtotals');
                if (transSubtotalsInput) {
                    transSubtotalsInput.value = subtotals.join(',');
                }

                // Enable/disable tombol bayar
                payButton.disabled = totalSelected === 0;

                // Update checkbox "Pilih Semua"
                selectAllCheckbox.checked = totalSelected === cartItems.length;
                selectAllCheckbox.indeterminate = totalSelected > 0 && totalSelected < cartItems.length;
            }

            function handleQuantityChange(item, delta) {
                const quantityInput = item.querySelector('.quantity-input');
                const current = parseInt(quantityInput.value);
                const stock = parseInt(item.dataset.stock);
                let newQuantity = current + delta;

                if (newQuantity < 1) newQuantity = 1;
                if (newQuantity > stock) newQuantity = stock;

                quantityInput.value = newQuantity;
                updateSummary();
            }

            selectAllCheckbox.addEventListener('change', () => {
                const checked = selectAllCheckbox.checked;
                cartItems.forEach(item => {
                    const checkbox = item.querySelector('.item-check');
                    if (checkbox) checkbox.checked = checked;
                });
                updateSummary();
            });

            cartItems.forEach(item => {
                const checkbox = item.querySelector('.item-check');
                const minusBtn = item.querySelector('.quantity-btn.minus');
                const plusBtn = item.querySelector('.quantity-btn.plus');
                const quantityInput = item.querySelector('.quantity-input');
                const deleteBtn = item.querySelector('.delete-btn');

                if (checkbox) {
                    checkbox.addEventListener('change', updateSummary);
                }

                if (minusBtn) {
                    minusBtn.addEventListener('click', () => handleQuantityChange(item, -1));
                }

                if (plusBtn) {
                    plusBtn.addEventListener('click', () => handleQuantityChange(item, 1));
                }

                if (quantityInput) {
                    quantityInput.addEventListener('change', () => {
                        const val = parseInt(quantityInput.value);
                        quantityInput.value = isNaN(val) || val < 1 ? 1 : val;
                        updateSummary();
                    });
                }

                if (deleteBtn) {
                    deleteBtn.addEventListener('click', () => {
                        const id = item.dataset.id;
                        if (confirm('Hapus item dari keranjang?')) {
                            axios.delete(`/baskets-public/${id}`)
                                .then(response => {
                                    console.log(response.data.message);
                                    item.remove();
                                    updateSummary();
                                })
                                .catch(error => {
                                    console.error('Gagal menghapus item:', error.response?.data?.message || error.message);
                                });
                        }
                    });
                }
            });

            updateSummary();
        });

        @if(session('productSuccessAlert'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('productSuccessAlert') }}",
                icon: "success",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                timer: 3000
            });
        @endif
    </script>

@endsection