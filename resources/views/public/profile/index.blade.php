@extends('index')

@section('content')
    <x-navbar-public :categories="$categories" />

    <div class="container">
        {{-- Header Profil --}}
        <div class="profile-header">
            <div class="profile-left-page">
                <div class="profile-avatar-container" id="edit-photo-container">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://via.placeholder.com/80' }}"
                        alt="Foto Profil" class="profile-avatar" id="profile-avatar">
                    <div class="profile-avatar-edit">Ubah Foto</div>
                </div>
            </div>
            <div class="profile-right-page">
                <div class="profile-title-con">
                    <h1 class="profile-name" id="profile-name">{{ Auth::user()->fullname }}</h1>
                    <p class="profile-role" id="profile-role">{{ Auth::user()->role == "consumer" ? "pelanggan" : "admin"}}</p>
                </div>
                <div class="profile-btn-con">
                    <div class="profile-edit" id="edit-photo-btn">Ubah Foto Profil</div>
                </div>
            </div>

            {{-- Form untuk upload foto, pastikan action diisi dengan route yang benar --}}
            <form id="photo-upload-form" action="{{ route('avatar.update') }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                {{-- Laravel seringkali menggunakan method POST untuk update file, jadi @method('PUT') mungkin tidak
                perlu --}}
                <input type="file" id="photo-upload" name="avatar" accept="image/*" style="display: none;">
            </form>
        </div>

        {{-- Konten Biodata --}}
        <div class="content" id="biodata-content">
            <div class="info-card">
                <h3 class="section-title">Biodata Diri</h3>

                <div class="info-row">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value" id="display-name">{{ $profiles->fullname }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value" id="display-email">{{ $profiles->email }}</div>
                </div>
                {{-- <div class="info-row">
                    <div class="info-label">Status Pengguna</div>
                    <div class="info-value" id="display-email">{{ $profiles->role == "consumer" ? "Pelanggan" : "Admin" }}
                    </div>
                </div> --}}
                <div class="info-row">
                    <div class="info-label">Jenis Kelamin</div>
                    <div class="info-value" id="display-gender" data-gender="{{ $profiles->gender }}">
                        {{ $profiles->gender == 'Male' ? 'Laki-laki' : 'Perempuan' }}
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Sandi Akun</div>
                    <div class="info-value">**********</div>
                </div>
                {{-- Tombol untuk memicu fungsi openEditForm() --}}
                <div class="info-action" onclick="openEditForm()">Edit Data</div>
            </div>
        </div>
    </div>

    {{-- Modal Form Edit (awalnya tersembunyi) --}}
    <div id="form-container" class="hidden">
        <div class="overlay" onclick="closeForm()"></div>
        <div class="form-card">
            <span class="close-btn" onclick="closeForm()">&times;</span>
            <h3 class="section-title" id="form-title">Edit Data</h3>

            <form id="edit-form" method="POST" action="{{ route('profiles-public.update', $profiles->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" id="fullname" name="fullname" value="{{ $profiles->fullname }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ $profiles->email }}" required>
                </div>
                <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <select id="gender" name="gender" required>
                        {{-- Opsi ini sudah diperbaiki --}}
                        <option value="Male" {{ $profiles->gender == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Female" {{ $profiles->gender == 'Female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi Baru</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Isi jika ingin mengubah sandi">
                        <span class="password-toggle" onclick="togglePassword('password')">&#128065;</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                    <div class="password-wrapper">
                        <input type="password" id="password_confirmation" name="password"
                            placeholder="Konfirmasi sandi baru">
                        <span class="password-toggle" onclick="togglePassword('password_confirmation')">&#128065;</span>
                    </div>
                </div>
                <button type="submit" class="save-button">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        @if(session('profileUpdateAlert'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('profileUpdateAlert') }}",
                icon: "success",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                timer: 3000
            });
        @elseif(session('avatarUpdateAlert'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('avatarUpdateAlert') }}",
                icon: "success",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                timer: 3000
            });
        @endif

        const formContainer = document.getElementById('form-container');
        const editPhotoContainer = document.getElementById('edit-photo-container');
        const editPhotoBtn = document.getElementById('edit-photo-btn');
        const photoUploadInput = document.getElementById('photo-upload');
        const photoUploadForm = document.getElementById('photo-upload-form');

        function openEditForm() {
            formContainer.classList.remove('hidden');
        }

        function closeForm() {
            formContainer.classList.add('hidden');
        }

        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const fieldType = passwordField.getAttribute('type');
            if (fieldType === 'password') {
                passwordField.setAttribute('type', 'text');
            } else {
                passwordField.setAttribute('type', 'password');
            }
        }

        const triggerPhotoUpload = () => {
            photoUploadInput.click();
        };

        editPhotoContainer.addEventListener('click', triggerPhotoUpload);
        editPhotoBtn.addEventListener('click', triggerPhotoUpload);

        photoUploadInput.addEventListener('change', () => {
            if (photoUploadInput.files.length > 0) {
                photoUploadForm.submit();
            }
        });
    </script>

@endsection