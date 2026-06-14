# Sistem Informasi Sekolah RA PERWANIDA (Management System)

Sistem Informasi Sekolah berbasis web untuk RA PERWANIDA (Taman Kanak-kanak). Aplikasi ini dibangun menggunakan framework **CodeIgniter 4**, HTML, Javascript, CSS, dan MySQL. Sistem ini mengelola data guru, murid, kehadiran, jadwal kelas, e-book perpustakaan, pengumuman, serta pembayaran SPP (SPay) wali murid.

---

## 🚀 Fitur Utama

1. **Dashboard Khusus Multi-Role**:
   - **Administrator/Staff TU**: Kelola seluruh data master (guru, murid, kelas, pengumuman, tagihan SPP, dll.).
   - **Guru**: Manajemen kehadiran murid dan jadwal mengajar.
   - **Orang Tua**: Dashboard khusus (SPay) untuk memantau tagihan sekolah, upload bukti bayar, membaca pengumuman, dan e-book belajar anak.
2. **Manajemen Guru & Murid**: Data biodata guru, data siswa (NISN), alamat, penempatan kelas, hingga foto profil.
3. **Manajemen Kehadiran (Presensi)**: Absensi harian murid dengan status (Hadir, Sakit, Izin, Alpha).
4. **Sebook Ebook (Perpustakaan Digital)**: Modul untuk mengunggah buku bacaan anak digital (PDF) berdasarkan kategori kelas.
5. **SPay (Sistem Pembayaran Sekolah)**:
   - Pengaturan tagihan SPP bulanan, biaya seragam, outing class, dll.
   - Halaman wali murid untuk upload bukti transfer.
   - Verifikasi bukti bayar oleh Administrator (Pending, Verified, Rejected).

---

## 🛠️ Persyaratan Sistem (Prerequisites)

Sebelum menjalankan project secara lokal, pastikan perangkat Anda telah terinstal:

- **PHP 8.2** atau versi yang lebih baru (aktifkan ekstensi `intl`, `mbstring`, `mysqli`, `curl`, `json` di file `php.ini` Anda).
- **Web Server & Database**: [XAMPP](https://www.apachefriends.org/) (versi terbaru dengan PHP 8.2) atau [Laragon](https://laragon.org/).
- **Composer** (opsional, jika ingin mengupdate dependensi vendor PHP).
- **Web Browser** modern (Chrome, Edge, Firefox).

---

## ⚙️ Langkah Instalasi & Konfigurasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan project pada PC/Laptop Anda:

### Langkah 1: Pindahkan/Klon Project ke Web Server Anda
Pastikan folder project ini berada di direktori `htdocs` web server lokal Anda.
- Contoh di Windows (XAMPP): `C:\xampp-baru\htdocs\tk` atau `C:\xampp\htdocs\tk`

### Langkah 2: Import Database MySQL
1. Aktifkan modul **Apache** dan **MySQL** pada panel kontrol XAMPP Anda.
2. Buka web browser Anda, kunjungi url [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Buat database baru dengan nama `db_tk` atau `raperwan_admin` (sesuai selera).
4. Pilih database baru tersebut, masuk ke tab **Import**.
5. Klik **Choose File** / **Pilih File**, cari file `db_tk.sql` yang ada di root direktori project ini.
6. Klik tombol **Import** di bagian bawah dan tunggu sampai proses import selesai.

### Langkah 3: Konfigurasi File Environment (`.env`)
Salin atau edit file `.env` di root direktori project Anda. Ubah pengaturannya untuk environment lokal:

```env
# 1. Ubah environment ke development untuk menampilkan halaman error jika terjadi bug
CI_ENVIRONMENT = development

# 2. Sesuaikan baseURL sesuai dengan cara Anda menjalankan project (pilih salah satu):
# Jika menggunakan Spark serve (Rekomendasi):
app.baseURL = 'http://localhost:8080/'
# Jika menggunakan default Apache/XAMPP:
# app.baseURL = 'http://localhost/tk/'

# 3. WAJIB ubah forceGlobalSecureRequests menjadi false untuk menghindari loop SSL (HTTPS) di local
app.forceGlobalSecureRequests = false

# 4. Sesuaikan konfigurasi koneksi database Anda
database.default.hostname = localhost
database.default.database = db_tk (Sesuaikan dengan nama database yang Anda buat di phpmyadmin)
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306

# 5. Nonaktifkan atau komentari path session hosting lama agar menggunakan path default local
# session.savePath = '/home/raperwan/public_html/session'
```

---

## 🏃 Cara Menjalankan Aplikasi

Anda dapat menggunakan salah satu dari dua cara berikut untuk menjalankan aplikasi:

### Cara A: Menggunakan CLI Spark Serve (Sangat Direkomendasikan)
1. Buka terminal (Command Prompt / PowerShell / Git Bash) di direktori root project (`C:\xampp-baru\htdocs\tk`).
2. Jalankan perintah berikut:
   ```bash
   php spark serve
   ```
3. Buka browser Anda dan akses alamat:
   ```text
   http://localhost:8080
   ```

### Cara B: Menggunakan Apache XAMPP Direct Access
1. Simpan project Anda di direktori `htdocs` (misal: `C:\xampp\htdocs\tk`).
2. Buka browser Anda dan akses alamat:
   ```text
   http://localhost/tk/
   ```
   *(Catatan: Project ini sudah dilengkapi front controller `index.php` pada tingkat root, sehingga Anda bisa langsung mengakses folder utama tanpa perlu memasukkan `/public` di URL)*

---

## 🔑 Data Akun Uji Coba (Default Credentials)

Berdasarkan dump database (`db_tk.sql`), berikut adalah beberapa akun uji coba yang sudah siap digunakan:

| Peran (Role) | Username / Email | Password default | Keterangan |
|---|---|---|---|
| **Administrator** | `adingrh` | *(Gunakan password Anda)* | Akun utama admin sekolah (Tabel `users`) |
| **Guru** | `ahmadsurya` | *(Gunakan password Anda)* | Guru Kelas A (Tabel `users`) |
| **Staff TU** | `stafftu` | *(Gunakan password Anda)* | Staff Tata Usaha (Tabel `users`) |
| **Orang Tua / Wali** | `budi.santoso@email.com` | *(Gunakan password Anda)* | Dashboard Pembayaran SPP (Tabel `spay_orang_tua`) |
| **Orang Tua / Wali** | `siti.rahayu@email.com` | *(Gunakan password Anda)* | Dashboard Pembayaran SPP (Tabel `spay_orang_tua`) |

> [!NOTE]
> Semua password dienkripsi menggunakan hashing Bcrypt (`password_hash` PHP). Jika Anda lupa password atau ingin membuat password baru untuk uji coba lokal, Anda dapat memperbarui kolom `password` pada tabel terkait menggunakan hash Bcrypt baru atau melakukan registrasi baru jika menu tersedia.

---

## 📁 Struktur Penting Direktori

- `/app` : Folder inti logika aplikasi (Config, Controllers, Models, Views, Database).
- `/public` : Aset publik (CSS, JS, Images, Uploads) dan entry point asli.
- `/system` : Core file framework CodeIgniter 4 (jangan diubah).
- `/writable` : Folder untuk menyimpan log, session lokal, cache, dan file unggahan sementara (memerlukan hak akses tulis/write permission).
- `/db_tk.sql` : Dump database mentah untuk di-import.
- `index.php` : Front controller di tingkat root untuk mempermudah routing hosting / Apache.
- `spark` : CLI tools dari CodeIgniter 4 untuk menjalankan server local, migration, generator, dll.

---

## ⚠️ Troubleshooting Umum

1. **Error: "Your PHP version must be 8.2 or higher..."**
   - Pastikan PHP CLI dan PHP Apache Anda sudah versi 8.2+. Jalankan `php -v` di terminal untuk memeriksa versi PHP yang aktif di environment path Anda.
2. **Error: "Database connection refused" atau sejenisnya**
   - Pastikan MySQL di XAMPP/Laragon sudah aktif.
   - Periksa kembali konfigurasi database di file `.env`. Pastikan username, database, dan password sudah benar.
3. **Mengapa halaman redirect terus-menerus (Redirection Loop)?**
   - Masalah ini terjadi karena `app.forceGlobalSecureRequests` bernilai `true` di file `.env`. Saat berjalan di localhost tanpa HTTPS (SSL), ini memicu redirection loop. Pastikan diubah menjadi `false` di local environment.
4. **Session tidak berfungsi / Gagal login**
   - Pastikan baris `session.savePath` milik server hosting di `.env` sudah dikomentari (`#`) atau dihapus, agar aplikasi menggunakan folder `writable/session` lokal.
   - Pastikan folder `writable` memiliki izin tulis (tidak Write-Protected/Read-Only).
