@extends('admin.index')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <x-admin-content-header></x-admin-content-header>
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Pelanggan</h6>
                            <h4 class="mb-3">{{ $users }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Produk</h6>
                            <h4 class="mb-3">{{ $products }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Transaksi</h6>
                            <h4 class="mb-3">{{ $transactions }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Produk Terjual</h6>
                            <h4 class="mb-3">{{ $sellout }}</h4>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <h5 class="mb-3">Riwayat Penambahan Produk</h5>
                    <div class="card tbl-card">
                        <div class="card-body">
                            <div class="table-responsive d-flex flex-column align-items-center">
                                <table class="table table-hover table-borderless mb-5">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($productContent as $content)
                                            <tr>
                                                <th scope="row">{{ ($productContent->currentPage() - 1) * $productContent->perPage() + $loop->iteration }}</th>
                                                <td>{{ $content->name }}</td>
                                                <td>{{ $content->category }}</td>
                                                <td>Rp {{ number_format($content->price, 0, ',', '.') }}</td>
                                                <td>
                                                    <span class="d-flex align-items-center gap-2">
                                                        <i class="fas fa-circle text-primary f-10 m-r-5"></i>
                                                       {{ $content->stock ? 'Tersedia' : 'Tidak Tersedia' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <form id="deleteForm-{{ $content->id }}"
                                                        action="{{ route('products.destroy', $content->id) }}" method="POST"
                                                        class="ms-2 d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                            data-id="{{ $content->id }}">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Content not available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="pagination-container">
                                    {{ $productContent->links('components.custom-pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
         // Konfirmasi penghapusan produk
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.dataset.id;
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data tidak dapat dikembalikan setelah dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`deleteForm-${productId}`).submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection