-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Bulan Mei 2026 pada 12.43
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
(1, 'Administrator', 'admin', '$2y$10$7Yjgw3RewGjspqLveBVRk./nIYLR29mCYIlyGEdEQ21fvtqMoPyCS', 1, '2026-05-14 21:26:38');

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
(1, 'senam pagi', 'senam jas mani besok kita party', 'olahraga', 'senam', 'jasmani', '---', 30, 'tidak ada', '2026-05-15 08:40:11', '2026-05-15 08:40:11'),
(2, 'aldmad', 'damDKANWdAWd\r\nawdlmA:Wdl', 'pembelajaran', 'mendalam', 'daLMDAd\r\nadKAd', 'dAdkpaOwd', 50, 'tidak ada', '2026-05-18 10:41:10', '2026-05-18 10:41:10');

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

INSERT INTO `guru` (`id`, `nama_guru`, `nip_nik`, `jabatan`, `pendidikan`) VALUES
(1, 'Ahmad Surya', '1234567890', 'Guru Kelas A', 'S1'),
(2, 'Siti Aminah', '987654321', 'Guru Kelas A', 'S1'),
(3, 'Adi N', '2147483647', 'Guru Kelas A', 'S1'),
(4, 'Sulistya', '2147483647', 'Guru Kelas B', 'S1'),
(5, 'Kepin', '2147483647', 'Guru Kelas B', 'S1'),
(7, 'Adnan', '664686568', 'Guru Kelas B', 'S1'),
(11, 'test 1', '214748364654646468', 'jkhjh', 'khukh'),
(12, 'test 2', '654686468465465216', 'akd', 'ajhd');

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
(1, 8, 16, '2026-05-19', 'izin', 'berak berak', '2026-05-18 10:45:24', '2026-05-18 10:45:24');

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
-- Struktur dari tabel `kesehatan_murid`
--

CREATE TABLE `kesehatan_murid` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_murid` int(11) UNSIGNED NOT NULL,
  `golongan_darah` varchar(5) DEFAULT NULL,
  `tinggi_badan` decimal(5,2) DEFAULT NULL,
  `berat_badan` decimal(5,2) DEFAULT NULL,
  `alergi` text DEFAULT NULL,
  `penyakit_bawaan` text DEFAULT NULL,
  `imunisasi` text DEFAULT NULL,
  `keterangan_kesehatan` text DEFAULT NULL,
  `tanggal_pemeriksaan` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

INSERT INTO `murid` (`id`, `id_kelas`, `id_tk`, `nisn`, `nama_murid`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`) VALUES
(8, 16, 0, '5465464654', 'test', 'L', 'bekasi', '2026-05-13', 'adhaiuw');

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
(4, 8, 'gua', '111111111111111', 'ojol', 'kpein', '684846464646484', 'ojol', 'Jl. Melati N15 No. 15, Bekasi, Jawa Barat\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\nRT 007/RW 014, Kel. Kebalen, Kec. Bebelan, Bekasi, Aceh, Kode Pos 17610\nPatokan: Pinggir Jalan', 'admin@example.com', '2026-05-18 01:28:00', '2026-05-18 01:42:30');

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `perkembangan_murid`
--

CREATE TABLE `perkembangan_murid` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_murid` int(11) UNSIGNED NOT NULL,
  `id_guru` int(11) UNSIGNED NOT NULL,
  `bulan` int(2) DEFAULT NULL,
  `tahun` int(4) DEFAULT NULL,
  `nilai_kognitif` int(3) DEFAULT NULL,
  `nilai_afektif` int(3) DEFAULT NULL,
  `nilai_motorik` int(3) DEFAULT NULL,
  `nilai_sosial` int(3) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `rekomendasi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','guru') NOT NULL DEFAULT 'guru',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `nama_lengkap`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@tk.com', '$2y$10$92IXUNpkm1rq/p7F9oueme', 'Administrator', 'admin', 'aktif', '2026-05-15 15:05:39', '2026-05-15 15:05:39');

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
  ADD KEY `kelas_id_guru_foreign` (`id_guru`),
  ADD KEY `id_pendidikan` (`id_pendidikan`),
  ADD KEY `id_pendidikan_2` (`id_pendidikan`);

--
-- Indeks untuk tabel `kesehatan_murid`
--
ALTER TABLE `kesehatan_murid`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kesehatan_id_murid_unique` (`id_murid`);

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
-- Indeks untuk tabel `perkembangan_murid`
--
ALTER TABLE `perkembangan_murid`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `perkembangan_unique` (`id_murid`,`bulan`,`tahun`),
  ADD KEY `perkembangan_id_guru_foreign` (`id_guru`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `kesehatan_murid`
--
ALTER TABLE `kesehatan_murid`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT untuk tabel `murid`
--
ALTER TABLE `murid`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `orang_tua`
--
ALTER TABLE `orang_tua`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id_pendidikan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `perkembangan_murid`
--
ALTER TABLE `perkembangan_murid`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Ketidakleluasaan untuk tabel `kesehatan_murid`
--
ALTER TABLE `kesehatan_murid`
  ADD CONSTRAINT `kesehatan_murid_id_murid_foreign` FOREIGN KEY (`id_murid`) REFERENCES `murid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Ketidakleluasaan untuk tabel `perkembangan_murid`
--
ALTER TABLE `perkembangan_murid`
  ADD CONSTRAINT `perkembangan_murid_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `perkembangan_murid_id_murid_foreign` FOREIGN KEY (`id_murid`) REFERENCES `murid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
