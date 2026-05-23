# Panduan Implementasi Fitur Admin Panel TK

## Fitur-Fitur Baru yang Ditambahkan

### 1. **Kehadiran (Attendance)**
- Mencatat kehadiran siswa per hari
- Status: Hadir, Sakit, Izin, Alpha
- Laporan kehadiran per siswa per bulan
- Validasi otomatis untuk tanggal libur

### 2. **Aktivitas Pembelajaran (Learning Activities)**
- Manajemen aktivitas pembelajaran di sekolah
- Kategori: Pembelajaran, Bermain, Seni, Olahraga, Musik, Lainnya
- Pencatatan aktivitas per kelas per hari
- Hasil pembelajaran dan catatan

### 3. **Data Orang Tua (Parent Information)**
- Menyimpan data ayah dan ibu
- Nomor telepon dan pekerjaan orang tua
- Alamat dan email keluarga
- Kontak darurat

### 4. **Jadwal Kelas (Class Schedule)**
- Jadwal harian per kelas
- Waktu masuk dan keluar
- Aktivitas yang dilakukan
- Ruangan/lokasi pembelajaran

### 5. **Pengumuman (Announcements)**
- Membuat pengumuman untuk sekolah
- Prioritas: Rendah, Normal, Tinggi
- Tanggal berlaku pengumuman
- Status aktif/nonaktif

### 6. **Libur Sekolah (School Holidays)**
- Manajemen tanggal libur sekolah
- Jenis: Nasional, Lokal, Cuti Bersama, Akhir Tahun
- Keterangan libur
- Otomatis mengecek tanggal untuk pencatatan kehadiran

### 7. **User Management**
- Tabel users untuk login admin
- Role: Admin, Guru
- Status: Aktif, Nonaktif

---

## Langkah-Langkah Implementasi

### 1. **Jalankan SQL Script**

Buka phpMyAdmin dan jalankan script `sql_tambahan_fitur_admin.sql`:
- Salin seluruh isi file SQL
- Buka database `db_tk`
- Paste script di tab SQL dan jalankan

Atau via terminal MySQL:
```bash
mysql -u root -p db_tk < sql_tambahan_fitur_admin.sql
```

### 2. **File yang Sudah Dibuat**

**Models** (di `app/Models/`):
- `UserModel.php`
- `OrangTuaModel.php`
- `KehadiranModel.php`
- `AktivitasModel.php`
- `AktivitasKelasModel.php`
- `JadwalKelasModel.php`
- `PengumumanModel.php`
- `LiburSekolahModel.php`

**Controllers** (di `app/Controllers/`):
- `Kehadiran.php`
- `Aktivitas.php`
- `OrangTua.php`
- `Jadwal.php`
- `Pengumuman.php`
- `Libur.php`

**Routes** (di `app/Config/Routes.php`):
Sudah ditambahkan semua endpoint untuk fitur-fitur baru

**Admin Controller** (di `app/Controllers/Admin.php`):
Sudah diupdate untuk menampilkan dashboard dengan statistik lengkap

### 3. **Membuat View Files**

Buat folder view di `app/Views/` untuk setiap fitur:

```
app/Views/
├── Kehadiran/
│   ├── index.php
│   ├── input.php
│   └── laporan.php
├── Aktivitas/
│   ├── index.php
│   ├── form.php
│   ├── jadwal_kelas.php
│   └── form_jadwal_kelas.php
├── OrangTua/
│   ├── index.php
│   └── form.php
├── Jadwal/
│   ├── index.php
│   └── form.php
├── Pengumuman/
│   ├── index.php
│   └── form.php
├── Libur/
│   ├── index.php
│   └── form.php
```

---

## Struktur Database

### Tabel-Tabel Baru

1. **users**
   - id, username, email, password, nama_lengkap, role, status

2. **orang_tua**
   - id, id_murid, nama_ayah, no_hp_ayah, pekerjaan_ayah, nama_ibu, no_hp_ibu, pekerjaan_ibu, alamat, email

3. **kehadiran**
   - id, id_murid, id_kelas, tanggal, status, keterangan

4. **aktivitas**
   - id, judul_aktivitas, deskripsi, jenis_aktivitas, kategori, tujuan, metode, durasi_menit, bahan_alat

5. **aktivitas_kelas**
   - id, id_aktivitas, id_kelas, tanggal, waktu_mulai, waktu_selesai, hasil_pembelajaran, catatan

6. **jadwal_kelas**
   - id, id_kelas, hari, jam_masuk, jam_keluar, aktivitas, ruangan

7. **pengumuman**
   - id, judul, konten, tanggal_mulai, tanggal_selesai, prioritas, status, created_by

8. **libur_sekolah**
   - id, nama_libur, tanggal_mulai, tanggal_selesai, keterangan, jenis_libur, status

9. **log_aktivitas**
    - id, id_user, aksi, modul, deskripsi, ip_address

---

## URL Endpoint & Fitur

| Fitur | URL | Method |
|-------|-----|--------|
| Dashboard | `/` atau `/admin` | GET |
| **Kehadiran** | | |
| Lihat Kehadiran | `/kehadiran` | GET |
| Input Kehadiran | `/kehadiran/input` | GET |
| Simpan Kehadiran | `/kehadiran/simpan` | POST |
| Laporan Kehadiran | `/kehadiran/laporan` | GET |
| **Aktivitas** | | |
| Lihat Aktivitas | `/aktivitas` | GET |
| Tambah Aktivitas | `/aktivitas/tambah` | GET |
| Simpan Aktivitas | `/aktivitas/simpan` | POST |
| Edit Aktivitas | `/aktivitas/edit/{id}` | GET |
| Update Aktivitas | `/aktivitas/update/{id}` | POST |
| Hapus Aktivitas | `/aktivitas/hapus/{id}` | GET |
| Jadwal Kelas | `/aktivitas/jadwal-kelas` | GET |
| **Orang Tua** | | |
| Lihat Data | `/orang-tua` | GET |
| Tambah Data | `/orang-tua/tambah` | GET |
| Simpan Data | `/orang-tua/simpan` | POST |
| Edit Data | `/orang-tua/edit/{id}` | GET |
| Update Data | `/orang-tua/update/{id}` | POST |
| Hapus Data | `/orang-tua/hapus/{id}` | GET |
| **Jadwal** | | |
| Lihat Jadwal | `/jadwal` | GET |
| Tambah Jadwal | `/jadwal/tambah` | GET |
| **Pengumuman** | | |
| Lihat Pengumuman | `/pengumuman` | GET |
| **Libur** | | |
| Lihat Libur | `/libur` | GET |

---

## Tips & Catatan Penting

1. **Password Admin (dari SQL):**
   ```
   Username: admin
   Email: admin@tk.com
   Password: (hashed) $2y$10$92IXUNpkm1rq/p7F9oueme
   ```
   Ganti password ini setelah pertama kali login (belum diimplementasi sistem login di sini)

2. **Data Sample:** SQL script sudah menyertakan data sampel untuk testing

3. **Validasi:** Pastikan untuk menambahkan validasi di form views sesuai kebutuhan

4. **Keamanan:** 
   - Implementasikan CSRF protection
   - Gunakan prepared statements (sudah dihandle oleh CodeIgniter Model)
   - Hash password dengan proper algorithm

5. **Laporan:** Gunakan library seperti mPDF untuk export laporan ke PDF

---

## Next Steps

1. **Buat View Files**: Sesuaikan dengan template HTML yang sudah ada
2. **Tambahkan Bootstrap/CSS**: Untuk styling interface
3. **Implementasi Login**: Gunakan UserModel yang sudah dibuat
4. **Export Laporan**: Tambahkan fitur export PDF/Excel
5. **API**: Jika diperlukan, tambahkan RESTful API endpoints

---

Untuk pertanyaan lebih lanjut, silakan sesuaikan sesuai kebutuhan sekolah Anda!
