# Website Rekomendasi Produk Supermarket
Website ini dirancang untuk memberikan rekomendasi produk berdasarkan pencocokkan daftar produk yang pernah dibeli oleh pelanggan lainnya dan juga pencocokkan daftar produk sesuai preferensi pelanggan yang memiliki riwayat transaksi sebelumnya. Website ini juga memiliki fitur tambahan lainnya seperti transaksi, pencarian dan filter produk. 

## Daftar Pengguna
Website ini memilki 2 jenis pengguna, yaitu:

**Admin**
   - Melihat indikator data statistik tentang akumulasi total pelanggan, produk, transaksi, terjual dan riwayat penambahan produk.
   - Melihat, menambahkan dan menghapus data produk.
   - Melihat daftar data transaksi yang pernah dilakukan pelanggan.
   - Melihat daftar data pelanggan yang sudah terdaftar pada sistem.

**Pelanggan**
   - Mendapatkan rekomendasi produk sesuai daftar produk yang pernah dibeli oleh pelanggan lain dan juga berdasarkan preferensi dari riwayat transaksi sebelumnya.
   - Transaksi pembelian produk.
   - Pencarian produk.
   - filter produk berdasarkan harga dan kategori.

## Fitur Utama
- **Rekomendasi Produk - (Admin & Pelanggan)**  
- **Transaksi Pembelian Produk - (Admin & Pelanggan)**
- **Pencarian Produk - (Admin & Pelanggan)**
- **Filter Produk - (Admin & Pelanggan)**
- **Panel Admin - (Admin)**
- **Autentikasi User - (Admin & Pelanggan)** 

## Instalasi
1. Clone repository ini ke dalam folder lokal Anda, misal nama folder adalah saranin.id :
    ```bash
    git clone https://github.com/KlikSaran/fe-be-saranin.git
    ```
    
2. Masuk ke folder dan install dependensi yang diperlukan :
    ```bash
    cd saranin.id
    npm install
    ```

3. Tambahkan file `.env` dengan menyalin file `.env.example` :
   ```bash
   cp .env.example .env
   ```

4. Buat kunci aplikasi (APP_KEY) di file `.env` :
   ```bash
   php artisan key:generate
   ```

5. Konfigurasi basis data MySQL (XAMPP, Laragon, DBeaver, dll). Sesuaikan pengaturan koneksi database di file `.env` .
   
6. Jalankan module bundler di mode development :
   ```bash
   npm run dev
   ```

7. Jalankan aplikasi pada web browser :
    ```bash
    php artisan serve
    ```

8. Akses aplikasi melalui browser di `http://localhost:8000` atau alamat IP laptop masing-masing.

## Teknologi yang Digunakan
- **Frontend**: HTML5, Javascript, Bootstrap, CSS.
- **Backend**: PHP, Flask.
- **Database**: MySQL (XAMPP, Laragon, DBeaver, dll).
- **Authentication**: DB Seeder untuk akun admin, pelanggan dan pendaftaran manual untuk pelanggan baru.
- **Version Control**: Git, GitHub.

## Penggunaan
**Login Admin**:  
   Email: `admin@gmail.com`  
   Password: `admin123`
   
**Login Pelanggan**:  
   Dapat mendaftar manual atau jika ingin melihat akun pelanggan yang telah terdaftar sebelumnya dapat menghubungi pengembang sistem.

## Kontribusi
Jika Anda ingin berkontribusi dalam pengembangan proyek ini, silakan lakukan **fork** repository ini dan kirimkan **pull request** dengan deskripsi perubahan yang jelas.

## Kontak
Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami di:  
- Email: mahennekkers27@gmail.com
- No. WA: 0895807400305

---
