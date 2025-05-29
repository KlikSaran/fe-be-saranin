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
                <input type="hidden" name="detail_transaction_ids" value="{{ $items->pluck('id')->implode(',') }}">
                <button type="submit" class="btn-submit">Bayar Sekarang</button>
            </form>

        </div>
    </div>
    <script>
        @if(session('checkoutSuccessAlert'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('checkoutSuccessAlert') }}",
                icon: "success",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                timer: 3000
            });
        @endif
    </script>
@endsection