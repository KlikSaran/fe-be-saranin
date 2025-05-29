@extends('admin.index')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <x-admin-content-header></x-admin-content-header>

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ link-button ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <form action="{{ route('search.product') }}" method="GET" class="col-lg-4" id="searchForm">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" name="query" id="searchInput" class="form-control rounded"
                                        placeholder="Cari Produk..." aria-label="Search" aria-describedby="search-addon"
                                        value="{{ request('query') ?? '' }}" onkeyup="handleSearchInput()" autofocus />
                                    <button type="submit" class="input-group-text border-0" id="search-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
                        </div>
                        <div class="card-body d-flex flex-column align-items-center">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Foto</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                {{-- Asumsikan ini berada di dalam tag <table> dan <thead> sudah didefinisikan --}}
                                    <tbody>
                                        @forelse ($products as $product)
                                            <tr>
                                                <th scope="row">
                                                    {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                                                </th>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category }}</td>
                                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td> {{-- Formatting
                                                harga --}}
                                                <td>
                                                    @if($product->stock == 'True' || $product->stock === true || $product->stock == 1)
                                                        {{-- Perbaikan kondisi stok --}}
                                                        <span class="badge bg-success text-white">Tersedia</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Tidak Tersedia</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}"
                                                            alt="{{ $product->name }}" width="80px" style="border-radius: 4px;">
                                                    @else
                                                        <span>Tidak ada gambar</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- Tombol Edit --}}
                                                    <button type="button" class="btn btn-sm btn-warning edit-button"
                                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                        data-category="{{ $product->category }}"
                                                        data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"
                                                        data-description="{{ $product->description }}"
                                                        data-image="{{ $product->image }}" {{-- Tambahkan data lain yang
                                                        dibutuhkan untuk form edit --}} data-bs-toggle="modal"
                                                        data-bs-target="#editProductModal">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <form id="deleteForm" action="{{ route('products.destroy', $product->id) }}"
                                                        method="POST" class="ms-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" id="delete-btn"
                                                            data-id="{{ $product->id }}">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada data produk.</td> {{-- Sesuaikan
                                                colspan dengan jumlah kolom Anda --}}
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="pagination-container">
                                    {{ $products->links('components.custom-pagination') }}
                                </div>

                                <div class="modal fade" id="editProductModal" tabindex="-1"
                                    aria-labelledby="editProductModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editProductModalLabel">Edit Produk: <span
                                                        id="editProductName"></span></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form id="editProductForm" method="POST" action=""> {{-- Action akan diisi oleh
                                                JS --}}
                                                @csrf
                                                @method('PUT') {{-- Atau PATCH --}}
                                                <div class="modal-body">
                                                    <input type="hidden" id="editProductId" name="product_id">

                                                    <div class="mb-3">
                                                        <label for="edit_name" class="form-label">Nama Produk</label>
                                                        <input type="text" class="form-control" id="edit_name" name="name"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_category" class="form-label">Kategori</label>
                                                        <input type="text" class="form-control" id="edit_category"
                                                            name="category" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_price" class="form-label">Harga</label>
                                                        <input type="number" class="form-control" id="edit_price"
                                                            name="price" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_stock" class="form-label">Status Stok</label>
                                                        <select class="form-select" id="edit_stock" name="stock">
                                                            <option value="True">Tersedia</option>
                                                            <option value="False">Tidak Tersedia</option>
                                                        </select>
                                                    </div>
                                                    {{-- Tambahkan field lain sesuai kebutuhan --}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                </div>
                <!-- [ link-button ] end -->
            </div>
            <!-- [ Main Content ] end -->

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Untuk Modal Edit Produk ---
            var editProductModal = document.getElementById('editProductModal');
            if (editProductModal) {
                editProductModal.addEventListener('show.bs.modal', function (event) {
                    // Tombol yang memicu modal
                    var button = event.relatedTarget;

                    // Ekstrak info dari atribut data-*
                    var productId = button.getAttribute('data-id');
                    var productName = button.getAttribute('data-name');
                    var productCategory = button.getAttribute('data-category'); // Pastikan ada data-category di tombol
                    var productPrice = button.getAttribute('data-price');       // Pastikan ada data-price di tombol
                    var productStock = button.getAttribute('data-stock');       // Pastikan ada data-stock di tombol
                    var productDescription = button.getAttribute('data-description');       // Pastikan ada data-stock di tombol

                    // Update konten modal
                    var modalTitle = editProductModal.querySelector('.modal-title #editProductName');
                    var modalForm = editProductModal.querySelector('#editProductForm');
                    var inputId = editProductModal.querySelector('#editProductId');
                    var inputName = editProductModal.querySelector('#edit_name');
                    var inputCategory = editProductModal.querySelector('#edit_category');
                    var inputPrice = editProductModal.querySelector('#edit_price');
                    var inputStock = editProductModal.querySelector('#edit_stock');
                    var inputDescription = editProductModal.querySelector('#edit_description');

                    if (modalTitle) modalTitle.textContent = productName;
                    if (modalForm) modalForm.action = 'products/' + productId 
                    if (inputId) inputId.value = productId;
                    if (inputName) inputName.value = productName;
                    if (inputCategory) inputCategory.value = productCategory;
                    if (inputPrice) inputPrice.value = productPrice;
                    if (inputDescription) inputDescription.value = productDescription;

                    if (inputStock) {
                        var stockStatus = button.getAttribute('data-stock');
                        inputStock.value = (stockStatus === 'True' || stockStatus === true || stockStatus === '1') ? 'True' : 'False';
                    }
                });
            }

        });

        // Confirmation delete message
        // document.addEventListener("DOMContentLoaded", function () {
        //     document.querySelectorAll("#delete-btn").forEach(button => {
        //         button.addEventListener("click", function () {
        //             let studyId = this.getAttribute("data-id");
        //             let form = this.closest("form");

        //             Swal.fire({
        //                 title: "Apakah kamu yakin?",
        //                 text: "Bidang Studi ini akan dihapus secara permanen!",
        //                 icon: "warning",
        //                 showCancelButton: true,
        //                 confirmButtonColor: "#d33",
        //                 cancelButtonColor: "#3085d6",
        //                 confirmButtonText: "Ya, hapus!",
        //                 cancelButtonText: "Batal"
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     form.submit();
        //                 }
        //             });
        //         });
        //     });
        // });

        let searchTimeout;
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');

        function handleSearchInput() {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                if (searchInput.value === '') {
                    searchForm.submit();
                }
            }, 500);
        }
        @if(session('productSuccessAlert'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('productSuccessAlert') }}",
                icon: "success",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                timer: 3000
            });
        @elseif(session('productUpdateSuccessAlert'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('productUpdateSuccessAlert') }}",
                icon: "success",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                timer: 3000
            });
        @endif
    </script>
@endsection