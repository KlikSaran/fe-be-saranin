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
                            {{-- <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a> --}}
                        </div>
                        <div class="card-body d-flex flex-column align-items-center">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Kategori</th>
                                        {{-- <th scope="col">Deskripsi</th> --}}
                                        <th scope="col">Harga</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Foto</th>
                                        {{-- <th scope="col">Aksi</th> --}}
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
                                                {{-- <td>{{ $product->description }}</td> --}}
                                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td> {{-- Formatting
                                                harga --}}
                                                <td>
                                                    @if($product->stock == 'True' || $product->stock === true || $product->stock == 1)
                                                        <span class="badge bg-success text-white">Tersedia</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Tidak Tersedia</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}"
                                                            alt="{{ $product->name }}" width="80px">
                                                    @else
                                                        <span>Tidak ada gambar</span>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <button type="button" class="btn btn-sm btn-warning edit-button"
                                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                        data-category="{{ $product->category }}"
                                                        data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"
                                                        data-description="{{ $product->description }}"
                                                        data-image="{{ $product->image }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <form id="deleteForm-{{ $product->id }}"
                                                        action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                        class="ms-2 d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                            data-id="{{ $product->id }}">Hapus</button>
                                                    </form>
                                                </td> --}}
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Produk tidak ditemukan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="pagination-container">
                                    {{ $products->links('components.custom-pagination') }}
                                </div>

                                {{-- <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Produk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form id="editProductForm" action="{{ route('products.update', ':id') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <input type="hidden" id="edit_modal_id" name="product_id">

                                                    <div class="mb-3">
                                                        <label for="edit_name" class="form-label">Nama Produk</label>
                                                        <input type="text" class="form-control" id="edit_name" name="name"
                                                            required value={{ $product->name }}>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_category" class="form-label">Kategori</label>
                                                        <input type="text" class="form-control" id="edit_category"
                                                            name="category" value={{ $product->category }} required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_price" class="form-label">Harga</label>
                                                        <input type="number" class="form-control" id="edit_price"
                                                            name="price" value={{ $product->price }} required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_stock" class="form-label">Status Stok</label>
                                                        <select class="form-select" id="edit_stock" name="stock" value={{
                                                            $product->stock }}>
                                                            <option value="True">Tersedia</option>
                                                            <option value="False">Tidak Tersedia</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_description" class="form-label">Deskripsi</label>
                                                        <textarea class="form-control" id="edit_description"
                                                            name="description"
                                                            rows="3">{{ $product->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="image" class="form-label">Foto Produk</label>
                                                        <img id="preview-image"
                                                            src="{{ asset('storage/' . $product->image) }}"
                                                            alt="Product Image" width="150px" class="d-block mb-2">
                                                        <input type="file" name="image" id="image" accept="image/*"
                                                            class="form-control">
                                                        <small class="text-muted">Unggah gambar baru jika ingin mengubah
                                                            foto produk.</small>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> --}}
                        </div>
                    </div>

                </div>
                <!-- [ link-button ] end -->
            </div>
            <!-- [ Main Content ] end -->

        </div>
    </div>
    <script>
        // document.addEventListener("DOMContentLoaded", function () {
        //     document.querySelectorAll(".edit-button").forEach(button => {
        //         button.addEventListener("click", function () {
        //             let productId = this.getAttribute("data-id");
        //             let name = this.getAttribute("data-name");
        //             let category = this.getAttribute("data-category");
        //             let price = this.getAttribute("data-price");
        //             let stock = this.getAttribute("data-stock");
        //             let description = this.getAttribute("data-description");
        //             let image = this.getAttribute("data-image");

        //             document.getElementById("edit_modal_id").value = productId;
        //             document.getElementById("edit_name").value = name;
        //             document.getElementById("edit_category").value = category;
        //             document.getElementById("edit_price").value = price;
        //             document.getElementById("edit_stock").value = stock;
        //             document.getElementById("edit_description").value = description;

        //             if (image) {
        //                 document.getElementById("preview-image").src = "/storage/" + image;
        //             }

        //             document.getElementById("editProductForm").setAttribute("action", "/products/" + productId);

        //             let editModal = new bootstrap.Modal(document.getElementById("editProductModal"));
        //             editModal.show();
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
        @elseif(session('productDeleteSuccessAlert'))
            Swal.fire({
                title: "Deleted!",
                text: "{{ session('productDeleteSuccessAlert') }}",
                icon: "success",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                timer: 3000
            });
        @endif

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