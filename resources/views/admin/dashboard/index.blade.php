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
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @forelse ($clientContents as $content)
                                        <tr>
                                            @if($content->client)
                                            <th scope="row">{{ ($clientContents->currentPage() - 1) *
                                                $clientContents->perPage() + $loop->iteration }}</th>
                                            <td>Beranda</td>
                                            <td>{{ $content->client->name }}</td>
                                            <td>{{ $content->created_at->format('d M Y') }}</td>
                                            <td><span class="d-flex align-items-center gap-2"><i
                                                        class="fas fa-circle text-primary f-10 m-r-5"></i>Baru
                                                    Ditambahkan</span>
                                            </td>
                                            @elseif($content->team)
                                            <th scope="row">{{ ($clientContents->currentPage() - 1) *
                                                $clientContents->perPage() + $loop->iteration }}</th>
                                            <td>Beranda</td>
                                            <td>{{ $content->team->name }}</td>
                                            <td>{{ $content->created_at->format('d M Y') }}</td>
                                            <td><span class="d-flex align-items-center gap-2"><i
                                                        class="fas fa-circle text-primary f-10 m-r-5"></i>Baru
                                                    Ditambahkan</span>
                                            </td>
                                            @elseif($content->study)
                                            <th scope="row">{{ ($clientContents->currentPage() - 1) *
                                                $clientContents->perPage() + $loop->iteration }}</th>
                                            <td>Bidang Studi</td>
                                            <td>{{ $content->study->name }}</td>
                                            <td>{{ $content->created_at->format('d M Y') }}</td>
                                            <td><span class="d-flex align-items-center gap-2"><i
                                                        class="fas fa-circle text-primary f-10 m-r-5"></i>Baru
                                                    Ditambahkan</span>
                                            </td>
                                            @elseif($content->service)
                                            <th scope="row">{{ ($clientContents->currentPage() - 1) *
                                                $clientContents->perPage() + $loop->iteration }}</th>
                                            <td>Layanan Jasa</td>
                                            <td>{{ $content->service->name }}</td>
                                            <td>{{ $content->created_at->format('d M Y') }}</td>
                                            <td><span class="d-flex align-items-center gap-2"><i
                                                        class="fas fa-circle text-primary f-10 m-r-5"></i>Baru
                                                    Ditambahkan</span>
                                            </td>
                                            @elseif($content->studentWork)
                                            <th scope="row">{{ ($clientContents->currentPage() - 1) *
                                                $clientContents->perPage() + $loop->iteration }}</th>
                                            <td>Karya Siswa</td>
                                            <td>{{ $content->studentWork->name }}</td>
                                            <td>{{ $content->created_at->format('d M Y') }}</td>
                                            <td><span class="d-flex align-items-center gap-2"><i
                                                        class="fas fa-circle text-primary f-10 m-r-5"></i>Baru
                                                    Ditambahkan</span>
                                            </td>
                                            @elseif($content->testimony)
                                            <th scope="row">{{ ($clientContents->currentPage() - 1) *
                                                $clientContents->perPage() + $loop->iteration }}</th>
                                            <td>Testimoni</td>
                                            <td>{{ $content->testimony->name }}</td>
                                            <td>{{ $content->created_at->format('d M Y') }}</td>
                                            <td><span class="d-flex align-items-center gap-2"><i
                                                        class="fas fa-circle text-primary f-10 m-r-5"></i>Baru
                                                    Ditambahkan</span>
                                            </td>
                                            @elseif($content->article)
                                            <th scope="row">{{ ($clientContents->currentPage() - 1) *
                                                $clientContents->perPage() + $loop->iteration }}</th>
                                            <td>Artikel</td>
                                            <td>{{ $content->article->title }}</td>
                                            <td>{{ $content->created_at->format('d M Y') }}</td>
                                            <td><span class="d-flex align-items-center gap-2"><i
                                                        class="fas fa-circle text-primary f-10 m-r-5"></i>Baru
                                                    Ditambahkan</span>
                                            </td>
                                            @elseif($content->contact)
                                            <th scope="row">{{ ($clientContents->currentPage() - 1) *
                                                $clientContents->perPage() + $loop->iteration }}</th>
                                            <td>Hubungi Kami</td>
                                            <td>{{ $content->contact->location }}</td>
                                            <td>{{ $content->created_at->format('d M Y') }}</td>
                                            <td><span class="d-flex align-items-center gap-2"><i
                                                        class="fas fa-circle text-primary f-10 m-r-5"></i>Baru
                                                    Ditambahkan</span>
                                            </td>
                                            @endif
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Content not available</td>
                                        </tr>
                                        @endforelse --}}
                                    </tbody>
                                </table>
                                <div class="pagination-container">
                                    {{-- {{ $clientContents->links('components.custom-pagination') }} --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection