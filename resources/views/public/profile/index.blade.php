@extends('index')
@section('content')
    <x-navbar-public :categories="$categories"></x-navbar-public>
    <div class="container">
        <!-- Header Profil -->
        <div class="profile-header">
            <div class="profile-avatar-container">
                <img src="https://via.placeholder.com/80" alt="Foto Profil" class="profile-avatar" id="profile-avatar">
                <div class="profile-avatar-edit">Ubah Foto</div>
            </div>
            <div>
                <div class="profile-name" id="profile-name">syamaidzar a s</div>
                <div class="profile-edit" id="edit-photo-btn">Ubah Foto Profil</div>
                <input type="file" id="photo-upload" accept="image/*" class="hidden">
            </div>
        </div>

        <div class="sidebar">
            <div class="sidebar-item active" data-target="biodata-content">Biodata Diri</div>
            <div class="sidebar-item" data-target="address-content">Daftar Alamat</div>
        </div>

        <!-- Konten Biodata Diri -->
        <div class="content" id="biodata-content">
            <h2 class="section-title">Biodata Diri</h2>

            <div class="info-card">
                <h3 class="section-title">Ubah Biodata Diri</h3>
                <div class="info-row">
                    <div class="info-label">Nama</div>
                    <div class="info-value" id="display-name">syamaidzar a s</div>
                    <div class="info-action" onclick="openEditForm('name')">Ubah</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal Lahir</div>
                    <div class="info-value" id="display-birthdate">7 Februari 2002</div>
                    <div class="info-action" onclick="openEditForm('birthdate')">Ubah</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jenis Kelamin</div>
                    <div class="info-value" id="display-gender">Pria</div>
                    <div class="info-action" onclick="openEditForm('gender')">Ubah</div>
                </div>
            </div>

            <div class="info-card">
                <h3 class="section-title">Ubah Kontak</h3>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value" id="display-email">syamadaniayah@gmail.com</div>
                    <div class="verified-badge">Terverifikasi</div>
                    <div class="info-action" onclick="openEditForm('email')">Ubah</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nomor HP</div>
                    <div class="info-value" id="display-phone">6282229657300</div>
                    <div class="verified-badge">Terverifikasi</div>
                    <div class="info-action" onclick="openEditForm('phone')">Ubah</div>
                </div>
            </div>

            <div class="info-card">
                <h3 class="section-title">Ubah Kata Sandi</h3>
                <div class="info-row">
                    <div class="info-value">••••••••</div>
                    <div class="info-action" onclick="openEditForm('password')">Ubah</div>
                </div>
            </div>
        </div>

        <!-- Konten Daftar Alamat (Awalnya Disembunyikan) -->
        <div class="content hidden" id="address-content">
            <h2 class="section-title">Daftar Alamat</h2>

            <div id="address-list">
                <!-- Alamat akan di-render oleh JavaScript -->
            </div>

            <div class="add-address-btn" onclick="openAddAddressForm()">+ Tambah Alamat Baru</div>
        </div>
    </div>

    <!-- Form Edit (Awalnya Disembunyikan) -->
    <div id="form-container" class="hidden">
        <div class="overlay" onclick="closeForm()"></div>
        <div class="form-card">
            <span class="close-btn" onclick="closeForm()">&times;</span>
            <h3 class="section-title" id="form-title">Edit Data</h3>
            <div class="edit-form" id="form-content">
                <!-- Form akan diisi oleh JavaScript -->
            </div>
        </div>
    </div>
@endsection