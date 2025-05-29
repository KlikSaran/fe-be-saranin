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
                            <form action="{{ route('search.consumer') }}" method="GET" class="col-lg-4" id="searchForm">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" name="query" id="searchInput" class="form-control rounded"
                                        placeholder="Cari Pelanggan..." aria-label="Search" aria-describedby="search-addon"
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
                            <a href="" class="btn btn-primary">Tambah Pelanggan</a>
                        </div>
                        <div class="card-body d-flex flex-column align-items-center">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Jenis Kelamin</th>
                                        <th scope="col">Jumlah Transaksi</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userTransactions as $user)
                                        <tr>
                                            <th scope="row">
                                                {{ ($userTransactions->currentPage() - 1) * $userTransactions->perPage() + $loop->iteration }}
                                            </th>
                                            <td>{{ $user->fullname }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->gender == "Male")
                                                    Laki-Laki
                                                @elseif ($user->gender == "Female")
                                                    Perempuan
                                                @elseif ($user->gender == "Polygender")
                                                    Poligender
                                                @else
                                                    {{ $user->gender ?? 'Tidak Ditentukan' }}
                                                @endif
                                            </td>
                                            <td>{{ $user->transactions_count }}</td>

                                            {{-- <td>{{ $userTransaction->user_id }}</td> --}}
                                            {{-- <td>{{ $userTransaction->stock == 'True' ? 'Tersedia' : 'Tidak Tersedia'}}</td>
                                            --}}
                                            {{-- <td><img src="{{ asset('storage/' . $product->image) }}" alt="" width="100px">
                                            </td> --}}
                                            {{-- <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $product->id }}"
                                                        data-name="{{ $product->name }}" data-title="{{ $product->title }}"
                                                        data-content="{{ $product->content }}"
                                                        data-image="{{ $product->image }}">
                                                        Edit
                                                    </button>
                                                    <form id="deleteForm" action="{{ route('product.destroy', $product->id) }}"
                                                        method="POST" class="ms-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" id="delete-btn"
                                                            data-id="{{ $product->id }}">Hapus</button>
                                                    </form>
                                                </div>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-container">
                                {{ $userTransactions->links('components.custom-pagination') }}
                            </div>
                        </div>
                    </div>

                    {{-- Scrollable modal --}}
                    {{-- <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Bidang Studi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm" action="{{ route('study_admin.update', ':id') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="edit-modal-id" name="study_id">

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Kelas</label>
                                            <select class="form-select" id="name" name="name" value="{{ $study->name }}"
                                                required>
                                                <option selected disabled>Pilih Kelas</option>
                                                <option value="Komputer Umum & Internet">Komputer Umum & Internet</option>
                                                <option value="Desain Grafis">Desain Grafis</option>
                                                <option value="Animasi 2D & 3D">Animasi 2D & 3D</option>
                                                <option value="Digital Marketing">Digital Marketing</option>
                                                <option value="Desain Interior">Desain Interior</option>
                                                <option value="Desain Arsitektur">Desain Arsitektur</option>
                                                <option value="Administrasi Perkantoran">Administrasi Perkantoran</option>
                                                <option value="Komputer Akuntansi">Komputer Akuntansi</option>
                                                <option value="Editing Video Multimedia">Editing Video Multimedia</option>
                                                <option value="Website Design CMS">Editing Video Multimedia</option>
                                                <option value="Web Designer">Web Designer</option>
                                                <option value="Programming Web">Programming Web</option>
                                                <option value="Programming Java Android">Programming Java Android</option>
                                                <option value="Photography">Photography</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Judul Artikel</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                placeholder="Masukkan Judul Artikel" value="{{ $study->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="summernote" class="form-label">Isi Konten</label>
                                            <textarea id="summernote" name="content" class="form-control"
                                                required>{{ $study->content }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Foto Sampul</label>
                                            <img id="preview-image" src="{{ asset('storage/' . $study->image) }}"
                                                alt="Artikel Image" width="150px" class="d-block mb-2">
                                            <input type="file" name="image" id="image" accept="image/*"
                                                class="form-control">
                                            <small class="text-muted">Unggah gambar baru jika ingin mengubah foto
                                                sampul.</small>
                                        </div>

                                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <!-- [ link-button ] end -->
            </div>
            <!-- [ Main Content ] end -->

        </div>
    </div>
    <script>
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
    </script>
@endsection