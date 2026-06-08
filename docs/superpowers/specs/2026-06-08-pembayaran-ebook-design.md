# Design Spec: Fitur Pembayaran & E-Book untuk Orang Tua

**Project:** Website Sekolah TK - CodeIgniter 4  
**Tanggal:** 2026-06-08  
**Status:** Draft - Menunggu Review

---

## 1. Prinsip Desain

### Brand Consistency
- Menggunakan logo RA Perwanida yang sama untuk konsistensi branding
- Tema warna berbeda (ungu) untuk membedakan area orang tua dari area admin (hijau)

### Color Palette - Tema Ungu
```css
--primary: #8b5cf6;        /* Ungu utama */
--primary-dark: #7c3aed;   /* Ungu gelap */
--primary-light: #a78bfa;  /* Ungu terang */
--secondary: #f1f5f9;      /* Background netral */
--accent: #f59e0b;         /* Aksen oranye untuk CTA */
--success: #10b981;        /* Hijau - lunas */
--warning: #f59e0b;        /* Oranye - pending */
--danger: #ef4444;         /* Merah - ditolak */
--text-dark: #1e293b;      /* Teks utama */
--text-muted: #64748b;     /* Teks sekunder */
```

---

## 2. Layout Login Orang Tua

### Struktur Halaman
```
┌─────────────────────────────────────┐
│           BACKGROUND GRADIENT       │
│     (ungu muda → putih soft)        │
├─────────────────────────────────────┤
│                                     │
│    ┌─────────────────────────┐      │
│    │      LOGO + NAMA        │      │
│    │    RA PERWANIDA         │      │
│    │   TK PERWANIDA          │      │
│    └─────────────────────────┘      │
│                                     │
│    ┌─────────────────────────┐      │
│    │  "Login Orang Tua"      │      │
│    │  Subtitle:              │      │
│    │  "Masuk untuk melihat   │      │
│    │   tagihan & e-book"     │      │
│    ├─────────────────────────┤      │
│    │  Email Input            │      │
│    ├─────────────────────────┤      │
│    │  Password Input         │      │
│    ├─────────────────────────┤      │
│    │  [  LOGIN  ]  Button    │      │
│    └─────────────────────────┘      │
│                                     │
│    Link: "Lupa password?"           │
│                                     │
└─────────────────────────────────────┘
```

### Styling Login
- Background: gradient linear dari `#8b5cf6` (10% opacity) ke putih
- Card: shadow elevated, border-radius 16px, padding generous
- Input fields: rounded, focus ring ungu
- Button: gradient ungu, hover scale subtle
- Animasi: card fade-in saat load, input focus glow

---

## 3. Layout Dashboard Orang Tua

### Struktur Utama
```
┌────────────────────────────────────────────────────────┐
│  TOPBAR: Logo | "Selamat datang, [Nama]" | Logout      │
├────────────────────────────────────────────────────────┤
│                                                        │
│  ┌─────────────────────────────────────────────────┐   │
│  │  HERO SECTION - Gradient Card                   │   │
│  │  "Tagihan Aktif" + Total Nominal + Due Date     │   │
│  │  [  Bayar Sekarang  ] Button                    │   │
│  └─────────────────────────────────────────────────┘   │
│                                                        │
│  ┌──────────────┐  ┌──────────────┐  ┌────────────┐   │
│  │  Card 1      │  │  Card 2      │  │  Card 3    │   │
│  │  Total       │  │  Pending     │  │  Lunas     │   │
│  │  Tagihan     │  │  (count)     │  │  (count)   │   │
│  └──────────────┘  └──────────────┘  └────────────┘   │
│                                                        │
│  ┌─────────────────────────────────────────────────┐   │
│  │  DAFTAR TAGIHAN                                 │   │
│  │  ┌─────────────────────────────────────────┐    │   │
│  │  │ Tagihan 1 | Rp XXX | Status | [Detail]  │    │   │
│  │  └─────────────────────────────────────────┘    │   │
│  │  ┌─────────────────────────────────────────┐    │   │
│  │  │ Tagihan 2 | Rp XXX | Status | [Detail]  │    │   │
│  │  └─────────────────────────────────────────┘    │   │
│  └─────────────────────────────────────────────────┘   │
│                                                        │
│  ┌─────────────────────────────────────────────────┐   │
│  │  E-BOOK TERBARU                    [Lihat All]  │   │
│  │  ┌─────┐  ┌─────┐  ┌─────┐  ┌─────┐            │   │
│  │  │     │  │     │  │     │  │     │            │   │
│  │  │Cover│  │Cover│  │Cover│  │Cover│            │   │
│  │  │     │  │     │  │     │  │     │            │   │
│  │  └─────┘  └─────┘  └─────┘  └─────┘            │   │
│  └─────────────────────────────────────────────────┘   │
│                                                        │
└────────────────────────────────────────────────────────┘
```

### Card Animations
1. **Hero Card**: Fade-in + slide-up saat load (delay 0ms)
2. **Stat Cards**: Staggered slide-in (100ms delay antar card)
3. **Tagihan List**: Fade-in staggered dari atas
4. **E-Book Cards**: Horizontal slide-in staggered
5. **Hover Effects**: Scale 1.02 + shadow lift pada cards

### Animasi Detail
```css
/* Card entrance */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover effect */
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(139, 92, 246, 0.15);
}

/* Counter animation */
.stat-number {
    animation: countUp 1s ease-out;
}
```

---

## 4. Fitur Utama

### 4.1 Login Orang Tua
- Form login dengan email & password
- Validasi input (email format, required fields)
- Error message untuk login gagal
- Session terpisah dari admin (`orangtua_logged_in`)

### 4.2 Dashboard
- **Hero Section**: Tagihan aktif dengan countdown batas waktu
- **Stats Cards**: Total tagihan, pending, lunas (dengan icon + animasi counter)
- **Tagihan List**: Card per tagihan dengan status badge
- **E-Book Preview**: 4 e-book terbaru dalam grid

### 4.3 Halaman Pembayaran
- List semua tagihan dengan filter (Semua/Pending/Lunas)
- Detail tagihan dengan informasi lengkap
- Form upload bukti pembayaran
- Progress tracker status pembayaran

### 4.4 E-Book Gallery
- Grid responsive card e-book
- Filter berdasarkan kategori
- Preview cover + info dasar
- Tombol download PDF

---

## 5. Komponen UI

### Status Badge
| Status | Warna | Label |
|--------|-------|-------|
| Pending | Oranye | Menunggu |
| Verified | Hijau | Lunas |
| Rejected | Merah | Ditolak |

### Button Variants
| Type | Warna | Usage |
|------|-------|-------|
| Primary | Ungu gradient | Main CTA |
| Secondary | Outline ungu | Secondary actions |
| Success | Hijau | Approve/Confirm |
| Danger | Merah | Reject/Cancel |

### Card Variants
| Variant | Usage |
|---------|-------|
| Hero | Main call-to-action section |
| Stat | Stats display with icon |
| List Item | Tagihan list rows |
| E-Book | Book preview cards |

---

## 6. Responsive Breakpoints

```css
/* Mobile first */
@media (min-width: 576px)  { /* SM - 2 stat cards per row */ }
@media (min-width: 768px)  { /* MD - 3 stat cards per row */ }
@media (min-width: 992px)  { /* LG - Full layout */ }
@media (min-width: 1200px) { /* XL - Extended container */ }
```

---

## 7. Font & Typography

- **Heading**: Font keluarga sistem (system-ui) atau Google Font "Plus Jakarta Sans"
- **Body**: Font keluarga sistem dengan fallback
- **Scale**: 
  - H1: 2rem (32px)
  - H2: 1.5rem (24px)
  - H3: 1.25rem (20px)
  - Body: 1rem (16px)
  - Small: 0.875rem (14px)

---

## 8. File yang Akan Dibuat/Dimodifikasi

### File Baru
1. `app/Controllers/OrangTua/AuthController.php`
2. `app/Controllers/OrangTua/PembayaranController.php`
3. `app/Controllers/Admin/VerifikasiPembayaranController.php`
4. `app/Controllers/Admin/EbookController.php`
5. `app/Controllers/Ebook/PublicEbookController.php`
6. `app/Models/OrangTuaModel.php` (prefix spay_)
7. `app/Models/PembayaranModel.php`
8. `app/Models/EbookModel.php`
9. `app/Filters/OrangTuaAuthFilter.php`
10. `app/Views/orangtua/auth/login.php` (BRAND NEW - Tema Ungu)
11. `app/Views/orangtua/dashboard.php` (BRAND NEW - Animasi)
12. `app/Views/orangtua/pembayaran/index.php`
13. `app/Views/orangtua/pembayaran/detail.php`
14. `app/Views/admin/pembayaran/index.php`
15. `app/Views/admin/pembayaran/verifikasi.php`
16. `app/Views/admin/ebook/index.php`
17. `app/Views/admin/ebook/create.php`
18. `app/Views/admin/ebook/edit.php`
19. `app/Views/public_ebook/index.php`
20. `app/Database/Migrations/2026-06-08-*.php`

### File yang Dimodifikasi
1. `app/Config/Routes.php` - Tambahkan routes baru
2. `app/Config/Filters.php` - Daftarkan OrangTuaAuthFilter

### TIDAK PERLU DIRUBAH
- `app/Views/Admin/*` - Sidebar, dashboard admin tetap seperti semula
- Database tabel lama - Hanya buat tabel baru dengan prefix
- Controller/Model/View fitur admin yang sudah ada

---

## 9. Scope Tidak Termasuk

- Sistem lupa password
- Notifikasi email
- Payment gateway integration
- Mobile app
- Print/download laporan

---

## 10. Success Criteria

1. ✅ Login orang tua dengan tampilan ungu menarik & animasi
2. ✅ Dashboard orang tua dengan card layout & animasi moderat
3. ✅ Fokus utama pada tagihan & pembayaran
4. ✅ E-book section terlihat tapi secondary
5. ✅ Tidak mengubah kode/tampilan admin yang sudah ada
6. ✅ Session terpisah antara auth admin & orang tua
7. ✅ Database baru dengan prefix `spay_` dan `sebook_`