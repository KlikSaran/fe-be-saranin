@extends('index')

@section('content')
    <x-navbar-public :categories="$categories"></x-navbar-public>

    <div class="checkout-container">
        <h2 class="checkout-title">Checkout</h2>

        <div class="checkout-items">
            @foreach ($items as $item)
                <div class="checkout-item">
                    <div class="checkout-image">
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                            loading="lazy" style="width: 80px; height: 80px;">
                    </div>
                    <div class="checkout-details">
                        <h4>{{ $item->product->name }}</h4>
                        <p>Harga: Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                        <p>Jumlah: {{ $item->quantity }}</p>
                        <p>Subtotal: Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="checkout-summary">
            <h3>Total Pembayaran</h3>
            <p>Rp {{ number_format($total, 0, ',', '.') }}</p>
            <form action="{{ route('checkout.submit') }}" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                <input type="hidden" name="quantity" value="{{ $item->quantity }}">
                <input type="hidden" name="price" value="{{ $item->product->price }}">
                <input type="hidden" name="total_price" value="{{ $item->total_price }}">
                {{-- <input type="text" name="detail_transaction_ids" value="{{ implode(',', $detailIds) }}"> --}}

                <input type="hidden" name="detail_transaction_ids" value="{{ $items->pluck('id')->implode(',') }}">

                <button type="submit" class="btn-submit">Bayar Sekarang</button>
            </form>

        </div>
    </div>
@endsection