@extends('index')

@section('content')
    <x-navbar-public :categories="$categories" />

    <div class="container">
        <h1>Daftar Transaksi</h1>

        <div id="transactions-list">
            @forelse($transactions as $detail)
                <div class="transaction-card">
                    <div class="transaction-header">
                        <h3>{{ $detail->product->name ?? 'Produk tidak ditemukan' }}</h3>
                        <span class="status-label {{ $detail->transaction->status ?? 'unknown' }}">
                            {{ ucfirst($detail->transaction->status ?? 'Tidak diketahui') }}
                        </span>
                    </div>
                    <p>Harga Satuan: Rp {{ number_format($detail->product->price ?? 0, 0, ',', '.') }}</p>
                    <p>Jumlah: {{ $detail->quantity }}</p>
                    <p>Total Harga: {{ $detail->total_price }}</p>
                    <hr>
                </div>
            @empty
                <p>Tidak ada transaksi ditemukan.</p>
            @endforelse
        </div>

    </div>

    {{-- Inline Script for Filter --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusButtons = document.querySelectorAll('.status-btn');
            const transactionCards = document.querySelectorAll('.transaction-card');

            statusButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const selectedStatus = this.getAttribute('data-status');

                    statusButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    transactionCards.forEach(card => {
                        const cardStatus = card.getAttribute('data-status');
                        if (selectedStatus === 'all' || cardStatus === selectedStatus) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>

    {{-- Simple Styling --}}
    {{-- <style>
        .transaction-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .transaction-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .transaction-body {
            display: flex;
            gap: 15px;
        }

        .status-buttons {
            margin-bottom: 20px;
        }

        .status-btn {
            margin-right: 10px;
            padding: 6px 12px;
            cursor: pointer;
            background: #eee;
            border: none;
            border-radius: 4px;
        }

        .status-btn.active {
            background-color: #333;
            color: white;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 6px;
            color: white;
        }

        .status-waiting {
            background-color: orange;
        }

        .status-processing {
            background-color: blue;
        }

        .status-shipping {
            background-color: teal;
        }

        .status-success {
            background-color: green;
        }

        .status-failed {
            background-color: red;
        }
    </style> --}}
@endsection