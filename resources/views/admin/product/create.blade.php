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
                        <div class="card-header">
                            <h5>Tambah Produk</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="hidden" name="stock" value="True">
                                    <label for="name" class="form-label">Nama Produk <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="product_select" name="name"> {{-- ID unik,
                                        name="name" untuk submit form --}}
                                        {{-- Opsi placeholder ini akan digunakan oleh Select2 --}}
                                        <option value="">Pilih Produk</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->name }}" {{ old('name', $defaultValue ?? '') == $product->name ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="category" class="form-label">Kategori Produk <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="category" name="category"
                                        placeholder="Masukkan Kategori Produk" value={{ old('category') }}>
                                    @error('category')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga Produk <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="price" name="price"
                                        placeholder="Masukkan Harga Produk" value={{ old('price') }}>
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Deskripsi Produk</label>
                                    <textarea class="form-control" name="description" id="description" value={{ old('description') }}
                                        placeholder="Masukkan Deskripsi Produk"></textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Foto Produk <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="image" id="image" accept="image/*" class="form-control"
                                        value={{ old('image') }}>
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary" type="submit">Simpan Produk</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- [ link-button ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection