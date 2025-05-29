let userData = {
    name: "syamaidzar a s",
    birthdate: "2002-02-07",
    gender: "Pria",
    email: "syamadaniayah@gmail.com",
    phone: "6282229657300",
    photo: "https://via.placeholder.com/80",
    addresses: [
        {
            id: 1,
            label: "Rumah Utama",
            name: "syamaidzar a s",
            phone: "6282229657300",
            address: "Gang Menco, RT.3/RW.5, Dusun Glagahan, Patianrowo",
            note: "Rumahnya mempunyai gapura berpagar hitam",
            isPrimary: true,
        },
        {
            id: 2,
            label: "Dari Teman",
            name: "syamaidzar a s",
            phone: "6282229657300",
            address: "Jl. Contoh No. 123, Jakarta Selatan",
            note: "",
            isPrimary: false,
        },
    ],
};

// Load data from localStorage if available
function loadData() {
    const savedData = localStorage.getItem("userProfileData");
    if (savedData) {
        userData = JSON.parse(savedData);
    }
    renderProfile();
    renderAddresses();
}

// Save data to localStorage
function saveData() {
    localStorage.setItem("userProfileData", JSON.stringify(userData));
    renderProfile();
    renderAddresses();
}

// Render profile data
function renderProfile() {
    document.getElementById("profile-name").textContent = userData.name;
    document.getElementById("profile-avatar").src = userData.photo;

    document.getElementById("display-name").textContent = userData.name;
    document.getElementById("display-birthdate").textContent = formatDate(
        userData.birthdate
    );
    document.getElementById("display-gender").textContent = userData.gender;
    document.getElementById("display-email").textContent = userData.email;
    document.getElementById("display-phone").textContent = userData.phone;
}

// Format date to Indonesian format
function formatDate(dateString) {
    const options = { year: "numeric", month: "long", day: "numeric" };
    const date = new Date(dateString);
    return date.toLocaleDateString("id-ID", options);
}

// Render addresses
function renderAddresses() {
    const addressList = document.getElementById("address-list");
    addressList.innerHTML = "";

    userData.addresses.forEach((address) => {
        const addressCard = document.createElement("div");
        addressCard.className = "address-card";
        addressCard.dataset.id = address.id;

        addressCard.innerHTML = `
          ${
              address.isPrimary
                  ? '<div class="address-primary">Rumah Utama</div>'
                  : ""
          }
          <div class="address-name">${address.name}</div>
          <div class="address-phone">${address.phone}</div>
          <div class="address-detail">${address.address}</div>
          ${
              address.note
                  ? `<div class="address-note">${address.note}</div>`
                  : ""
          }
          <div class="address-actions">
            <div class="address-action" onclick="setPrimaryAddress(${
                address.id
            })">${address.isPrimary ? "Alamat Utama" : "Jadikan Utama"}</div>
            <div class="address-action" onclick="openEditAddressForm(${
                address.id
            })">Ubah Alamat</div>
            ${
                !address.isPrimary
                    ? `<div class="address-action" onclick="deleteAddress(${address.id})">Hapus</div>`
                    : ""
            }
          </div>
        `;

        addressList.appendChild(addressCard);
    });
}

// DOM Elements
const biodataContent = document.getElementById("biodata-content");
const addressContent = document.getElementById("address-content");
const sidebarItems = document.querySelectorAll(".sidebar-item");
const formContainer = document.getElementById("form-container");
const formTitle = document.getElementById("form-title");
const formContent = document.getElementById("form-content");
const photoUpload = document.getElementById("photo-upload");
const profileAvatar = document.getElementById("profile-avatar");
const editPhotoBtn = document.getElementById("edit-photo-btn");

// Initialize
loadData();

// Switch between Biodata and Address
sidebarItems.forEach((item) => {
    item.addEventListener("click", function () {
        sidebarItems.forEach((i) => i.classList.remove("active"));
        this.classList.add("active");

        const target = this.dataset.target;
        document.querySelectorAll(".content").forEach((content) => {
            content.classList.add("hidden");
        });
        document.getElementById(target).classList.remove("hidden");
    });
});

// Photo upload functionality
editPhotoBtn.addEventListener("click", () => photoUpload.click());
profileAvatar.addEventListener("click", () => photoUpload.click());

photoUpload.addEventListener("change", function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
            userData.photo = event.target.result;
            saveData();
        };
        reader.readAsDataURL(file);
    }
});

// Form functions
function openForm(title, content) {
    formTitle.textContent = title;
    formContent.innerHTML = content;
    formContainer.classList.remove("hidden");
    document.body.style.overflow = "hidden";
}

function closeForm() {
    formContainer.classList.add("hidden");
    document.body.style.overflow = "";
}

// Open edit form for profile data
function openEditForm(field) {
    let title, content;

    switch (field) {
        case "name":
            title = "Ubah Nama";
            content = `
            <div class="form-note">Kamu hanya dapat mengubah nama 1 kali lagi. Pastikan nama sudah benar.</div>
            <div class="form-group">
              <label class="form-label">Nama</label>
              <input type="text" class="form-input" id="edit-field" value="${userData.name}">
              <div class="form-note">Nama dapat dilihat oleh pengguna lainnya</div>
            </div>
            <div class="form-actions">
              <button class="btn btn-secondary" onclick="closeForm()">Batal</button>
              <button class="btn btn-primary" onclick="saveProfileField('name')">Simpan</button>
            </div>
          `;
            break;

        case "birthdate":
            title = "Ubah Tanggal Lahir";
            content = `
            <div class="form-group">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" class="form-input" id="edit-field" value="${userData.birthdate}">
            </div>
            <div class="form-actions">
              <button class="btn btn-secondary" onclick="closeForm()">Batal</button>
              <button class="btn btn-primary" onclick="saveProfileField('birthdate')">Simpan</button>
            </div>
          `;
            break;

        case "gender":
            title = "Ubah Jenis Kelamin";
            content = `
            <div class="form-group">
              <label class="form-label">Jenis Kelamin</label>
              <select class="form-input" id="edit-field">
                <option value="Pria" ${
                    userData.gender === "Pria" ? "selected" : ""
                }>Pria</option>
                <option value="Wanita" ${
                    userData.gender === "Wanita" ? "selected" : ""
                }>Wanita</option>
              </select>
            </div>
            <div class="form-actions">
              <button class="btn btn-secondary" onclick="closeForm()">Batal</button>
              <button class="btn btn-primary" onclick="saveProfileField('gender')">Simpan</button>
            </div>
          `;
            break;

        case "email":
            title = "Ubah Email";
            content = `
            <div class="form-group">
              <label class="form-label">Email</label>
              <input type="email" class="form-input" id="edit-field" value="${userData.email}">
            </div>
            <div class="form-actions">
              <button class="btn btn-secondary" onclick="closeForm()">Batal</button>
              <button class="btn btn-primary" onclick="saveProfileField('email')">Simpan</button>
            </div>
          `;
            break;

        case "phone":
            title = "Ubah Nomor HP";
            content = `
            <div class="form-group">
              <label class="form-label">Nomor HP</label>
              <input type="tel" class="form-input" id="edit-field" value="${userData.phone}">
            </div>
            <div class="form-actions">
              <button class="btn btn-secondary" onclick="closeForm()">Batal</button>
              <button class="btn btn-primary" onclick="saveProfileField('phone')">Simpan</button>
            </div>
          `;
            break;

        case "password":
            title = "Ubah Kata Sandi";
            content = `
            <div class="form-group">
              <label class="form-label">Kata Sandi Lama</label>
              <input type="password" class="form-input" id="current-password">
            </div>
            <div class="form-group">
              <label class="form-label">Kata Sandi Baru</label>
              <input type="password" class="form-input" id="new-password">
            </div>
            <div class="form-group">
              <label class="form-label">Konfirmasi Kata Sandi Baru</label>
              <input type="password" class="form-input" id="confirm-password">
            </div>
            <div class="form-actions">
              <button class="btn btn-secondary" onclick="closeForm()">Batal</button>
              <button class="btn btn-primary" onclick="changePassword()">Simpan</button>
            </div>
          `;
            break;
    }

    openForm(title, content);
}

// Save profile field
function saveProfileField(field) {
    const value = document.getElementById("edit-field").value;
    userData[field] = value;
    saveData();
    closeForm();
}

// Change password
function changePassword() {
    const currentPassword = document.getElementById("current-password").value;
    const newPassword = document.getElementById("new-password").value;
    const confirmPassword = document.getElementById("confirm-password").value;

    if (!currentPassword || !newPassword || !confirmPassword) {
        alert("Harap isi semua field!");
        return;
    }

    if (newPassword !== confirmPassword) {
        alert("Konfirmasi password tidak sesuai!");
        return;
    }

    alert("Password berhasil diubah!");
    closeForm();
}

// Address functions
function openAddAddressForm() {
    const title = "Tambah Alamat Baru";
    const content = `
        <div class="form-group">
          <label class="form-label">Label Alamat</label>
          <input type="text" class="form-input" id="address-label" placeholder="Contoh: Rumah, Kantor">
        </div>
        <div class="form-group">
          <label class="form-label">Nama Penerima</label>
          <input type="text" class="form-input" id="address-name" value="${userData.name}">
        </div>
        <div class="form-group">
          <label class="form-label">Nomor HP</label>
          <input type="tel" class="form-input" id="address-phone" value="${userData.phone}">
        </div>
        <div class="form-group">
          <label class="form-label">Alamat Lengkap</label>
          <textarea class="form-input" id="address-detail" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Catatan Untuk Kurir (Opsional)</label>
          <textarea class="form-input" id="address-note" rows="2" placeholder="Contoh: Warna rumah, patokan, pesan khusus, dll."></textarea>
        </div>
        <div class="form-group">
          <label class="form-label">
            <input type="checkbox" id="address-primary"> Jadikan alamat utama
          </label>
        </div>
        <div class="form-actions">
          <button class="btn btn-secondary" onclick="closeForm()">Batal</button>
          <button class="btn btn-primary" onclick="saveNewAddress()">Simpan</button>
        </div>
      `;
    openForm(title, content);
}

function openEditAddressForm(id) {
    const address = userData.addresses.find((addr) => addr.id === id);
    if (!address) return;

    const title = "Ubah Alamat";
    const content = `
        <div class="form-group">
          <label class="form-label">Label Alamat</label>
          <input type="text" class="form-input" id="address-label" value="${
              address.label
          }">
        </div>
        <div class="form-group">
          <label class="form-label">Nama Penerima</label>
          <input type="text" class="form-input" id="address-name" value="${
              address.name
          }">
        </div>
        <div class="form-group">
          <label class="form-label">Nomor HP</label>
          <input type="tel" class="form-input" id="address-phone" value="${
              address.phone
          }">
        </div>
        <div class="form-group">
          <label class="form-label">Alamat Lengkap</label>
          <textarea class="form-input" id="address-detail" rows="3">${
              address.address
          }</textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Catatan Untuk Kurir (Opsional)</label>
          <textarea class="form-input" id="address-note" rows="2">${
              address.note
          }</textarea>
        </div>
        <div class="form-group">
          <label class="form-label">
            <input type="checkbox" id="address-primary" ${
                address.isPrimary ? "checked disabled" : ""
            }>
            ${address.isPrimary ? "Alamat utama" : "Jadikan alamat utama"}
          </label>
        </div>
        <div class="form-actions">
          <button class="btn btn-secondary" onclick="closeForm()">Batal</button>
          <button class="btn btn-primary" onclick="updateAddress(${id})">Simpan</button>
          ${
              !address.isPrimary
                  ? `<button class="btn btn-danger" onclick="deleteAddress(${id})">Hapus</button>`
                  : ""
          }
        </div>
      `;
    openForm(title, content);
}

function saveNewAddress() {
    const newAddress = {
        id: Date.now(),
        label: document.getElementById("address-label").value,
        name: document.getElementById("address-name").value,
        phone: document.getElementById("address-phone").value,
        address: document.getElementById("address-detail").value,
        note: document.getElementById("address-note").value,
        isPrimary: document.getElementById("address-primary").checked,
    };

    if (newAddress.isPrimary) {
        userData.addresses.forEach((addr) => (addr.isPrimary = false));
    }

    userData.addresses.push(newAddress);
    saveData();
    closeForm();
}

function updateAddress(id) {
    const address = userData.addresses.find((addr) => addr.id === id);
    if (!address) return;

    address.label = document.getElementById("address-label").value;
    address.name = document.getElementById("address-name").value;
    address.phone = document.getElementById("address-phone").value;
    address.address = document.getElementById("address-detail").value;
    address.note = document.getElementById("address-note").value;

    const makePrimary = document.getElementById("address-primary").checked;
    if (makePrimary && !address.isPrimary) {
        userData.addresses.forEach((addr) => (addr.isPrimary = false));
        address.isPrimary = true;
    }

    saveData();
    closeForm();
}

function setPrimaryAddress(id) {
    userData.addresses.forEach((addr) => {
        addr.isPrimary = addr.id === id;
    });
    saveData();
}

function deleteAddress(id) {
    if (confirm("Apakah Anda yakin ingin menghapus alamat ini?")) {
        userData.addresses = userData.addresses.filter(
            (addr) => addr.id !== id
        );
        saveData();
    }
}
