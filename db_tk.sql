-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jun 2026 pada 16.15
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin_users`
--

INSERT INTO `admin_users` (`id`, `name`, `username`, `password`, `is_active`, `created_at`) VALUES
(1, 'Administrator', 'admin', '$2y$10$zox6vo/gTjMudycIWfPSA.YYelTDGVTYb5i4egQUZCnstpFWnbgJG', 1, '2026-05-14 21:26:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id` int(11) UNSIGNED NOT NULL,
  `judul_aktivitas` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `jenis_aktivitas` enum('pembelajaran','bermain','seni','olahraga','musik','lainnya') NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `tujuan` text DEFAULT NULL,
  `metode` text DEFAULT NULL,
  `durasi_menit` int(11) DEFAULT NULL,
  `bahan_alat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aktivitas`
--

INSERT INTO `aktivitas` (`id`, `judul_aktivitas`, `deskripsi`, `jenis_aktivitas`, `kategori`, `tujuan`, `metode`, `durasi_menit`, `bahan_alat`, `created_at`, `updated_at`) VALUES
(1, 'senam pagi', 'senam jas mani besok kita party', 'olahraga', 'senam', 'jasmani', '---', 30, 'tidak ada', '2026-05-15 08:40:11', '2026-05-15 08:40:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktivitas_kelas`
--

CREATE TABLE `aktivitas_kelas` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_aktivitas` int(11) UNSIGNED NOT NULL,
  `id_kelas` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `hasil_pembelajaran` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `nip_nik` varchar(18) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `pendidikan` varchar(50) NOT NULL,
  `foto_guru` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `nama_guru`, `nip_nik`, `jabatan`, `pendidikan`, `foto_guru`) VALUES
(1, 'Ahmad Surya', '1234567890', 'Guru Kelas A', 'S1', NULL),
(2, 'Siti Aminah', '987654321', 'Guru Kelas A', 'S1', NULL),
(3, 'Adi N', '2147483647', 'Guru Kelas A', 'S1', NULL),
(4, 'Sulistya', '2147483647', 'Guru Kelas B', 'S1', NULL),
(5, 'Kepin', '2147483647', 'Guru Kelas B', 'S1', '1779475341_398d29dfe0359fd2970f.png'),
(7, 'Adnan', '664686568', 'Guru Kelas B', 'S1', NULL),
(11, 'test 1', '214748364654646468', 'jkhjh', 'khukh', NULL),
(12, 'test 2', '654686468465465216', 'akd', 'ajhd', NULL),
(13, 'ahmar supriadi', '1234567890', 'Guru Kelas A', 'S3', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_kelas`
--

CREATE TABLE `jadwal_kelas` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_kelas` int(11) UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `aktivitas` varchar(150) DEFAULT NULL,
  `ruangan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_kelas`
--

INSERT INTO `jadwal_kelas` (`id`, `id_kelas`, `hari`, `jam_masuk`, `jam_keluar`, `aktivitas`, `ruangan`, `created_at`, `updated_at`) VALUES
(1, 13, 'Senin', '08:00:00', '10:00:00', 'Ngocok', 'A1', '2026-05-18 01:29:47', '2026-05-18 01:29:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kehadiran`
--

CREATE TABLE `kehadiran` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_murid` int(11) UNSIGNED NOT NULL,
  `id_kelas` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','sakit','izin','alpha') NOT NULL DEFAULT 'hadir',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kehadiran`
--

INSERT INTO `kehadiran` (`id`, `id_murid`, `id_kelas`, `tanggal`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 8, 16, '2026-05-19', 'izin', 'berak berak', '2026-05-18 10:45:24', '2026-05-18 10:45:24'),
(2, 8, 16, '2026-05-21', 'hadir', 'luka luka', '2026-05-21 02:01:11', '2026-05-21 02:18:47'),
(3, 9, 16, '2026-05-21', 'alpha', 'membolos', '2026-05-21 02:01:11', '2026-05-21 02:18:47'),
(4, 10, 13, '2026-05-21', 'sakit', 'panas men', '2026-05-21 02:29:04', '2026-05-21 02:29:04'),
(5, 9, 16, '2026-05-22', 'hadir', '', '2026-05-22 05:30:35', '2026-05-22 08:52:04'),
(6, 8, 16, '2026-05-22', 'hadir', '', '2026-05-22 05:30:35', '2026-05-22 08:52:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) UNSIGNED NOT NULL,
  `id_guru` int(11) UNSIGNED NOT NULL,
  `id_pendidikan` int(11) UNSIGNED NOT NULL,
  `nama_kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `id_guru`, `id_pendidikan`, `nama_kelas`) VALUES
(13, 1, 1, 'Kelas A1'),
(16, 2, 1, 'Kelas A2'),
(17, 3, 1, 'Kelas A3'),
(18, 4, 2, 'Kelas B1'),
(19, 5, 2, 'Kelas B2'),
(20, 7, 2, 'Kelas B3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `libur_sekolah`
--

CREATE TABLE `libur_sekolah` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_libur` varchar(100) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jenis_libur` enum('nasional','lokal','cuti_bersama','akhir_tahun') NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) UNSIGNED DEFAULT NULL,
  `aksi` varchar(100) NOT NULL,
  `modul` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-05-23-000001', 'App\\Database\\Migrations\\AddFotoProfilGuruMurid', 'default', 'App', 1779473881, 1),
(2, '2026-06-08-000001', 'App\\Database\\Migrations\\CreateSpayOrangTua', 'default', 'App', 1780919090, 2),
(3, '2026-06-08-000002', 'App\\Database\\Migrations\\CreateSpayTagihan', 'default', 'App', 1780919090, 2),
(4, '2026-06-08-000003', 'App\\Database\\Migrations\\CreateSpayPembayaran', 'default', 'App', 1780919090, 2),
(5, '2026-06-08-000004', 'App\\Database\\Migrations\\CreateSeBookEbook', 'default', 'App', 1780919090, 2),
(6, '2026-06-08-000005', 'App\\Database\\Migrations\\AddKategoriToSpayTagihan', 'default', 'App', 1780927850, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `murid`
--

CREATE TABLE `murid` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_kelas` int(11) UNSIGNED NOT NULL,
  `id_tk` int(11) NOT NULL,
  `nisn` varchar(10) NOT NULL,
  `nama_murid` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `foto_murid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `murid`
--

INSERT INTO `murid` (`id`, `id_kelas`, `id_tk`, `nisn`, `nama_murid`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `foto_murid`) VALUES
(8, 16, 0, '5465464654', 'test', 'L', 'bekasi', '2026-05-13', 'adhaiuw', NULL),
(9, 16, 0, '1537176473', 'Ahmar rafly', 'L', 'nganjuk', '2026-05-21', 'knwuhbjbwdAMBWd/lkasbd\nRT 007/RW 014, Kel. Kebalen, Kec. Bebelan, Bekasi, Jawa Barat, Kode Pos 17610\nPatokan: Pinggir Jalan banjir', NULL),
(10, 13, 0, '1537176473', 'yanto basnan', 'L', 'Bandung', '2026-05-21', 'kouBJbdAKLdaljaiwda\nRT 008/RW 019, Kel. Kebalen, Kec. Bebelan, Bekasi, DKI Jakarta, Kode Pos 17610\nPatokan: Pinggir Jalan', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orang_tua`
--

CREATE TABLE `orang_tua` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_murid` int(11) UNSIGNED NOT NULL,
  `nama_ayah` varchar(100) NOT NULL,
  `no_hp_ayah` varchar(15) NOT NULL,
  `pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `no_hp_ibu` varchar(15) NOT NULL,
  `pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `alamat` text NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orang_tua`
--

INSERT INTO `orang_tua` (`id`, `id_murid`, `nama_ayah`, `no_hp_ayah`, `pekerjaan_ayah`, `nama_ibu`, `no_hp_ibu`, `pekerjaan_ibu`, `alamat`, `email`, `created_at`, `updated_at`) VALUES
(4, 8, 'gua', '111111111111111', 'ojol', 'kpein', '684846464646484', 'ojol', 'Jl. Melati N15 No. 15, Bekasi, Jawa Barat\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\nRT 007/RW 014, Kel. Kebalen, Kec. Bebelan, Bekasi, Aceh, Kode Pos 17610\nPatokan: Pinggir Jalan', 'admin@example.com', '2026-05-18 01:28:00', '2026-05-18 01:42:30'),
(5, 9, 'gua', '111111111111111', 'ojol', 'kpein', '684846464646484', 'ojol', 'ssfsfeEF wefvwefvwevfzs\nRT 007/RW 014, Kel. Kebalen, Kec. Bebelan, Bekasi, Jawa Barat, Kode Pos 17610\nPatokan: Pinggir Jalan banjir', 'admin@example.com', '2026-05-23 00:46:47', '2026-05-23 00:46:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `nama_ayah` varchar(100) NOT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `akta_kelahiran` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `nama_siswa`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `nama_ayah`, `nama_ibu`, `no_hp`, `alamat`, `akta_kelahiran`, `created_at`) VALUES
(1, 'yanto', 'Jakarta', '2026-05-07', 'Laki-laki', 'gua', 'dia', '0884132876', 'yufhjfc,hnfcjyfliufyi\r\nd\r\nad\r\na\r\nda\r\nd\r\nAd\r\na\r\ndA\r\nda\r\n', '1779479094_b3f2695db6f38a9c6980.pdf', '2026-05-23 02:44:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id_pendidikan` int(11) UNSIGNED NOT NULL,
  `nama` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendidikan`
--

INSERT INTO `pendidikan` (`id_pendidikan`, `nama`) VALUES
(1, 'TK A'),
(2, 'TK B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) UNSIGNED NOT NULL,
  `judul` varchar(200) NOT NULL,
  `konten` text NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `prioritas` enum('rendah','normal','tinggi') NOT NULL DEFAULT 'normal',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `konten`, `tanggal_mulai`, `tanggal_selesai`, `prioritas`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(4, 'mengingatkan pembayaran sekolah', 'a\r\na\r\na\r\na\r\na\r\na\r\n\r\na\r\na\r\na\r\na\r\na\r\na\r\n\r\na\r\n', '2026-05-21', '2026-05-25', 'rendah', 'nonaktif', NULL, '2026-05-21 05:04:49', '2026-05-23 00:43:01');



--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` int(11) UNSIGNED NOT NULL,
  `nama_role` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id_role`, `nama_role`) VALUES
(1, 'Administrator'),
(2, 'Admin'),
(3, 'Staff'),
(4, 'Guru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sebook_ebook`
--

CREATE TABLE `sebook_ebook` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `penulis` varchar(150) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `kelas` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sebook_ebook`
--

INSERT INTO `sebook_ebook` (`id`, `judul`, `deskripsi`, `penulis`, `kategori`, `cover`, `file_path`, `kelas`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Belajar Mengenal Angka 1-20', 'Buku belajar angka untuk anak TK', 'Guru Anna', 'Matematika', NULL, 'dummy.pdf', 'TK A, TK B', 1, 1, '2026-06-08 20:11:04', '2026-06-08 20:11:04'),
(2, 'Ayo Belajar Huruf Hijaiyah', 'Buku belajar huruf hijaiyah untuk TK', 'Guru Siti', 'Agama', NULL, 'dummy.pdf', 'TK A, TK B', 1, 1, '2026-06-08 20:11:04', '2026-06-08 20:11:04'),
(3, 'Cerita Nusantara: Malin Kundang', 'Kisah Malin Kundang untuk anak-anak', 'Pak Hasan', 'Bahasa Indonesia', NULL, 'dummy.pdf', 'TK A', 1, 1, '2026-06-08 20:11:04', '2026-06-08 20:11:04'),
(4, 'English for Kids: Animals', 'Belajar kosakata bahasa Inggris tentang hewan', 'Miss Lisa', 'Bahasa Inggris', NULL, 'dummy.pdf', 'TK B', 1, 1, '2026-06-08 20:11:04', '2026-06-08 20:11:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `spay_orang_tua`
--

CREATE TABLE `spay_orang_tua` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `nama_siswa` varchar(150) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `spay_orang_tua`
--

INSERT INTO `spay_orang_tua` (`id`, `nama`, `email`, `password`, `no_hp`, `nama_siswa`, `kelas`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', 'budi.santoso@email.com', '$2y$10$92IXUNpk1rq/p7F9ouemeSlQjKlHqBEGQqG0V5rK8N8F5u5kKjKSe', '081234567890', 'Ani Santoso', 'TK A', 1, '2026-06-08 20:09:21', '2026-06-08 20:09:21'),
(2, 'Siti Rahayu', 'siti.rahayu@email.com', '$2y$10$92IXUNpk1rq/p7F9ouemeSlQjKlHqBEGQqG0V5rK8N8F5u5kKjKSe', '089876543210', 'Dewi Rahayu', 'TK B', 1, '2026-06-08 20:10:11', '2026-06-08 20:10:11'),
(3, 'nanan', 'nanan@gmail.com', '$2a$10$0aISzamI0jBCVTxONzJlHOk7O7QS.XPFIheLVhXultVa9Ju7SarZ6', '082123821832', 'Pian', 'TK A', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `spay_pembayaran`
--

CREATE TABLE `spay_pembayaran` (
  `id` int(11) NOT NULL,
  `tagihan_id` int(11) NOT NULL,
  `orang_tua_id` int(11) NOT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `spay_tagihan`
--

CREATE TABLE `spay_tagihan` (
  `id` int(11) NOT NULL,
  `orang_tua_id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `batas_bayar` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `spay_tagihan`
--

INSERT INTO `spay_tagihan` (`id`, `orang_tua_id`, `judul`, `nominal`, `batas_bayar`, `keterangan`, `created_at`, `updated_at`, `kategori`) VALUES
(1, 1, 'SPP Bulan Juni 2026', 250000.00, '2026-06-20', 'SPP bulanan Juni', '2026-06-08 20:09:21', '2026-06-08 20:09:21', NULL),
(2, 1, 'SPP Bulan Juni 2026', 250000.00, '2026-06-20', 'SPP bulanan Juni', '2026-06-08 20:10:47', '2026-06-08 20:10:47', NULL),
(3, 1, 'SPP Bulan Juli 2026', 250000.00, '2026-07-20', 'SPP bulanan Juli', '2026-06-08 20:10:47', '2026-06-08 20:10:47', NULL),
(4, 1, 'Biaya KegiatanOUTING', 150000.00, '2026-06-25', 'Kegiatan outing ke museum', '2026-06-08 20:10:47', '2026-06-08 20:10:47', NULL),
(5, 2, 'SPP Bulan Juni 2026', 250000.00, '2026-06-20', 'SPP bulanan Juni', '2026-06-08 20:10:47', '2026-06-08 20:10:47', NULL),
(6, 2, 'Biaya Seragam', 350000.00, '2026-07-05', 'Seragam sekolah lengkap', '2026-06-08 20:10:47', '2026-06-08 20:10:47', NULL),
(7, 1, 'SPP Bulan Juni 2026', 250000.00, '2026-06-20', 'SPP bulanan Juni', '2026-06-08 20:10:52', '2026-06-08 20:10:52', NULL),
(8, 1, 'SPP Bulan Juli 2026', 250000.00, '2026-07-20', 'SPP bulanan Juli', '2026-06-08 20:10:52', '2026-06-08 20:10:52', NULL),
(9, 1, 'Biaya KegiatanOUTING', 150000.00, '2026-06-25', 'Kegiatan outing ke museum', '2026-06-08 20:10:52', '2026-06-08 20:10:52', NULL),
(10, 2, 'SPP Bulan Juni 2026', 250000.00, '2026-06-20', 'SPP bulanan Juni', '2026-06-08 20:10:52', '2026-06-08 20:10:52', NULL),
(11, 2, 'Biaya Seragam', 350000.00, '2026-07-05', 'Seragam sekolah lengkap', '2026-06-08 20:10:52', '2026-06-08 20:10:52', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_users` int(11) UNSIGNED NOT NULL,
  `id_role` int(11) UNSIGNED DEFAULT NULL,
  `id_guru` int(11) UNSIGNED DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_users`, `id_role`, `id_guru`, `username`, `password`, `email`, `nama_lengkap`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'adingrh', '$2y$10$gE17VIq39B60Lcv6R0GfvOa7svhg9tDGRbHGTlZm5L4Sym54/Nfjq', 'adi@gmail.com', 'Adi Nugroho', 'aktif', '2026-05-23 17:12:23', '2026-05-23 17:12:23'),
(2, 4, 1, 'ahmadsurya', '$2y$10$7Yjgw3RewGjspqLveBVRk./nIYLR29mCYIlyGEdEQ21fvtqMoPyCS', 'ahmad@example.com', 'Ahmad Surya', 'aktif', '2026-05-30 15:15:00', '2026-05-30 15:15:00'),
(3, 3, NULL, 'stafftu', '$2y$10$7Yjgw3RewGjspqLveBVRk./nIYLR29mCYIlyGEdEQ21fvtqMoPyCS', 'staff@example.com', 'Staff Tata Usaha', 'aktif', '2026-05-30 15:15:00', '2026-05-30 15:15:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aktivitas_kelas`
--
ALTER TABLE `aktivitas_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aktivitas_kelas_id_aktivitas_foreign` (`id_aktivitas`),
  ADD KEY `aktivitas_kelas_id_kelas_foreign` (`id_kelas`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jadwal_unique` (`id_kelas`,`hari`);

--
-- Indeks untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kehadiran_unique` (`id_murid`,`tanggal`),
  ADD KEY `kehadiran_id_kelas_foreign` (`id_kelas`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD UNIQUE KEY `kelas_id_guru_unique` (`id_guru`),
  ADD UNIQUE KEY `kelas_nama_kelas_unique` (`nama_kelas`),
  ADD KEY `id_pendidikan` (`id_pendidikan`),
  ADD KEY `id_pendidikan_2` (`id_pendidikan`);

--
-- Indeks untuk tabel `libur_sekolah`
--
ALTER TABLE `libur_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `murid`
--
ALTER TABLE `murid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `murid_id_kelas_foreign` (`id_kelas`),
  ADD KEY `id_tk` (`id_tk`);

--
-- Indeks untuk tabel `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orang_tua_id_murid_foreign` (`id_murid`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- Indeks untuk tabel `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `sebook_ebook`
--
ALTER TABLE `sebook_ebook`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `spay_orang_tua`
--
ALTER TABLE `spay_orang_tua`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `spay_pembayaran`
--
ALTER TABLE `spay_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spay_pembayaran_tagihan_id_foreign` (`tagihan_id`),
  ADD KEY `spay_pembayaran_orang_tua_id_foreign` (`orang_tua_id`);

--
-- Indeks untuk tabel `spay_tagihan`
--
ALTER TABLE `spay_tagihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spay_tagihan_orang_tua_id_foreign` (`orang_tua_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_guru` (`id_guru`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `aktivitas_kelas`
--
ALTER TABLE `aktivitas_kelas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `libur_sekolah`
--
ALTER TABLE `libur_sekolah`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `murid`
--
ALTER TABLE `murid`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `orang_tua`
--
ALTER TABLE `orang_tua`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id_pendidikan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `sebook_ebook`
--
ALTER TABLE `sebook_ebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `spay_orang_tua`
--
ALTER TABLE `spay_orang_tua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `spay_pembayaran`
--
ALTER TABLE `spay_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `spay_tagihan`
--
ALTER TABLE `spay_tagihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `aktivitas_kelas`
--
ALTER TABLE `aktivitas_kelas`
  ADD CONSTRAINT `aktivitas_kelas_id_aktivitas_foreign` FOREIGN KEY (`id_aktivitas`) REFERENCES `aktivitas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aktivitas_kelas_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD CONSTRAINT `jadwal_kelas_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD CONSTRAINT `kehadiran_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kehadiran_id_murid_foreign` FOREIGN KEY (`id_murid`) REFERENCES `murid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `murid`
--
ALTER TABLE `murid`
  ADD CONSTRAINT `murid_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD CONSTRAINT `orang_tua_id_murid_foreign` FOREIGN KEY (`id_murid`) REFERENCES `murid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `spay_pembayaran`
--
ALTER TABLE `spay_pembayaran`
  ADD CONSTRAINT `spay_pembayaran_orang_tua_id_foreign` FOREIGN KEY (`orang_tua_id`) REFERENCES `spay_orang_tua` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spay_pembayaran_tagihan_id_foreign` FOREIGN KEY (`tagihan_id`) REFERENCES `spay_tagihan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `spay_tagihan`
--
ALTER TABLE `spay_tagihan`
  ADD CONSTRAINT `spay_tagihan_orang_tua_id_foreign` FOREIGN KEY (`orang_tua_id`) REFERENCES `spay_orang_tua` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
