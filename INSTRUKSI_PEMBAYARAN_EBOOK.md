# Instruksi Fitur Pembayaran & E-Book

## 1. Login Orang Tua (Testing)

### Cara Membuat Akun Test

Jalankan SQL berikut di phpMyAdmin untuk membuat akun orang tua test:

```sql
-- ============================================
-- INSERT AKUN ORANG TUA TEST
-- ============================================
-- Password: orangtuatest123 ( Plain text )
-- Hash BCrypt sudah di-generate untuk password tersebut
-- ============================================

INSERT INTO spay_orang_tua (nama, email, password, no_hp, nama_siswa, kelas, is_active, created_at, updated_at)
VALUES (
    'Budi Santoso',
    'budi.santoso@email.com',
    '$2y$10$92IXUNpk1rq/p7F9ouemeSlQjKlHqBEGQqG0V5rK8N8F5u5kKjKSe',  -- Password: orangtuatest123
    '081234567890',
    'Ani Santoso',
    'TK A',
    1,
    NOW(),
    NOW()
);

INSERT INTO spay_orang_tua (nama, email, password, no_hp, nama_siswa, kelas, is_active, created_at, updated_at)
VALUES (
    'Siti Rahayu',
    'siti.rahayu@email.com',
    '$2y$10$92IXUNpk1rq/p7F9ouemeSlQjKlHqBEGQqG0V5rK8N8F5u5kKjKSe',  -- Password: orangtuatest123
    '089876543210',
    'Dewi Rahayu',
    'TK B',
    1,
    NOW(),
    NOW()
);
```

### Login Credentials

| Email | Password |
|-------|----------|
| `budi.santoso@email.com` | `orangtuatest123` |
| `siti.rahayu@email.com` | `orangtuatest123` |

### Cara Generate Password Hash Baru

Jika ingin membuat password berbeda, jalankan di terminal:

```bash
# Generate BCrypt hash untuk password baru
php spark "make:hash" password_anda
```

Atau buat file PHP untuk generate:

```php
<?php
// Simpan sebagai generate_hash.php dan jalankan di browser
echo password_hash('password_anda', PASSWORD_DEFAULT);
```

---

## 2. Membuat Data Tagihan Test

Jalankan SQL berikut untuk membuat tagihan test:

```sql
-- ============================================
-- INSERT TAGIHAN TEST
-- ============================================

-- Tagihan untuk Budi Santoso (id_orang_tua = 1)
INSERT INTO spay_tagihan (orang_tua_id, judul, nominal, batas_bayar, keterangan, created_at, updated_at)
VALUES
(1, 'SPP Bulan Juni 2026', 250000, '2026-06-20', 'SPP bulanan Juni', NOW(), NOW()),
(1, 'SPP Bulan Juli 2026', 250000, '2026-07-20', 'SPP bulanan Juli', NOW(), NOW()),
(1, 'Biaya KegiatanOUTING', 150000, '2026-06-25', 'Kegiatan outing ke museum', NOW(), NOW());

-- Tagihan untuk Siti Rahayu (id_orang_tua = 2)
INSERT INTO spay_tagihan (orang_tua_id, judul, nominal, batas_bayar, keterangan, created_at, updated_at)
VALUES
(2, 'SPP Bulan Juni 2026', 250000, '2026-06-20', 'SPP bulanan Juni', NOW(), NOW()),
(2, 'Biaya Seragam', 350000, '2026-07-05', 'Seragam sekolah lengkap', NOW(), NOW());
```

---

## 3. Membuat Data E-Book Test

```sql
-- ============================================
-- INSERT E-BOOK TEST
-- ============================================
-- Catatan: Untuk testing, buat file PDF dummy di writable/uploads/ebook/file/
-- ============================================

INSERT INTO sebook_ebook (judul, deskripsi, penulis, kategori, file_path, kelas, is_active, created_by, created_at, updated_at)
VALUES
('Belajar Mengenal Angka 1-20', 'Buku belajar angka untuk anak TK', 'Guru Anna', 'Matematika', 'dummy.pdf', 'TK A, TK B', 1, 1, NOW(), NOW()),
('Ayo Belajar Huruf Hijaiyah', 'Buku belajar huruf hijaiyah untuk TK', 'Guru Siti', 'Agama', 'dummy.pdf', 'TK A, TK B', 1, 1, NOW(), NOW()),
('Cerita Nusantara: Malin Kundang', 'Kisah Malin Kundang untuk anak-anak', 'Pak Hasan', 'Bahasa Indonesia', 'dummy.pdf', 'TK A', 1, 1, NOW(), NOW()),
('English for Kids: Animals', 'Belajar kosakata bahasa Inggris tentang hewan', 'Miss Lisa', 'Bahasa Inggris', 'dummy.pdf', 'TK B', 1, 1, NOW(), NOW());
```

---

## 4. Menu di Dashboard Admin

### Akses Menu Baru

Setelah login sebagai Admin, Anda bisa mengakses menu baru di sidebar:

| Menu | URL | Deskripsi |
|------|-----|-----------|
| **Verifikasi Pembayaran** | `/admin/verifikasi-pembayaran` | Melihat & memverifikasi pembayaran dari orang tua |
| **Manajemen E-Book** | `/admin/ebook` | CRUD e-book (tambah, edit, hapus) |

### Cara Akses:

1. Login ke `/login` sebagai admin (bukan orang tua)
2. Di sidebar kiri, scroll ke bawah
3. Menu baru ada di bagian "MANAJEMEN" atau "FITUR BARU"

---

## 5. Flow Testing Lengkap

### Step 1: Login sebagai Admin
```
URL: /login
Username: admin (default)
Password: (sesuaikan dengan akun admin Anda)
```

### Step 2: Tambahkan E-Book (Admin)
```
1. Buka /admin/ebook
2. Klik "Tambah E-Book"
3. Isi judul, penulis, kategori, kelas
4. Upload file PDF
5. Upload cover (opsional)
6. Klik Simpan
```

### Step 3: Login sebagai Orang Tua
```
URL: /orangtua/login
Email: budi.santoso@email.com
Password: orangtuatest123
```

### Step 4: Lihat Dashboard Orang Tua
```
1. Setelah login, akan redirect ke /orangtua/dashboard
2. Lihat statistik tagihan
3. Lihat e-book terbaru
```

### Step 5: Upload Bukti Bayar (Orang Tua)
```
1. Klik "Bayar Sekarang" di hero card
2. Pilih tagihan
3. Klik "Upload Bukti Pembayaran"
4. Pilih file (JPG/PNG/PDF, maks 5MB)
5. Klik Kirim
```

### Step 6: Verifikasi Pembayaran (Admin)
```
1. Buka /admin/verifikasi-pembayaran
2. Klik "Detail" pada pembayaran pending
3. Lihat bukti bayar
4. Pilih status: "Verifikasi" atau "Tolak"
5. Tambahkan catatan (opsional)
6. Klik Simpan
```

---

## 6. File yang Dibuat

### Database Tables (Baru):
- `spay_orang_tua` - Data akun orang tua
- `spay_tagihan` - Data tagihan
- `spay_pembayaran` - Data pembayaran & bukti transfer
- `sebook_ebook` - Data e-book

### Controllers:
- `app/Controllers/OrangTua/AuthController.php`
- `app/Controllers/OrangTua/PembayaranController.php`
- `app/Controllers/Admin/VerifikasiPembayaranController.php`
- `app/Controllers/Admin/EbookController.php`
- `app/Controllers/Ebook/PublicEbookController.php`

### Models:
- `app/Models/SpayOrangTuaModel.php`
- `app/Models/SpayPembayaranModel.php`
- `app/Models/SeBookEbookModel.php`

### Views (Baru):
- `app/Views/orangtua/auth/login.php` - Login tema ungu
- `app/Views/orangtua/dashboard.php` - Dashboard dengan animasi
- `app/Views/orangtua/pembayaran/index.php`
- `app/Views/orangtua/pembayaran/detail.php`
- `app/Views/admin/pembayaran/index.php`
- `app/Views/admin/pembayaran/verifikasi.php`
- `app/Views/admin/ebook/index.php`
- `app/Views/admin/ebook/create.php`
- `app/Views/admin/ebook/edit.php`
- `app/Views/public_ebook/index.php`

### CSS:
- `assets/dashboard/css/orangtua-custom.css` - Tema ungu + animasi

---

## 7. Catatan Penting

1. **TIDAK mengubah database/fitur yang sudah ada**
   - Semua tabel baru pakai prefix `spay_` dan `sebook_`
   - Session terpisah dari admin

2. **Password Default:**
   - Admin login: gunakan akun admin yang sudah ada
   - Orang Tua login: `orangtuatest123`

3. **Upload Folder:**
   - Bukti bayar: `writable/uploads/bukti_bayar/`
   - E-book PDF: `writable/uploads/ebook/file/`
   - E-book cover: `writable/uploads/ebook/cover/`

4. **Filter Auth:**
   - `/orangtua/*` dilindungi `OrangTuaAuthFilter`
   - `/admin/verifikasi-pembayaran` & `/admin/ebook` dilindungi `role:Administrator,Admin`

---

## 8. Troubleshooting

### Q: Login orang tua tidak bisa?
A: Pastikan:
1. Akun ada di tabel `spay_orang_tua`
2. `is_active = 1`
3. Password hash benar (gunakan BCrypt)

### Q: Upload bukti bayar gagal?
A: Pastikan:
1. Folder `writable/uploads/bukti_bayar/` ada & writable
2. Format file: JPG, PNG, atau PDF
3. Ukuran maksimal 5MB

### Q: Download e-book tidak works?
A: Pastikan:
1. File PDF ada di `writable/uploads/ebook/file/`
2. Nama file sesuai dengan `file_path` di database

### Q: Menu admin tidak muncul di sidebar?
A: Menu baru belum ditambahkan ke sidebar. Anda perlu edit:
- `app/Views/Admin/partials/sidebar.php`
- Tambahkan menu manual untuk link ke `/admin/verifikasi-pembayaran` dan `/admin/ebook`

---

**Tanggal dibuat:** 2026-06-08
**Project:** Website TK RA Perwanida