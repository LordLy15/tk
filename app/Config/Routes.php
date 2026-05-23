<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =================================================================
// 1. AREA PUBLIK (DASHBOARD PORTO)
// =================================================================
// Memanggil halaman utama portofolio langsung saat web dibuka
$routes->get('/', 'Home::index'); 
$routes->get('/pendaftaran', 'Home::pendaftaran');
$routes->post('/pendaftaran/simpan', 'Home::simpanPendaftaran'); // <-- INI ROUTE BARU UNTUK MENANGANI SUBMIT FORM

// Jika kamu masih punya controller Porto, bisa dibiarkan sebagai opsional
$routes->get('/porto', 'Porto::index'); 


// =================================================================
// 2. AREA OTENTIKASI (LOGIN)
// =================================================================
$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');


// =================================================================
// 3. AREA DASHBOARD GURU / ADMIN INTERNAL (Dari branch dashboard-porto)
// =================================================================
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->post('saveSiswa', 'Dashboard::saveSiswa');
    $routes->get('deleteSiswa/(:num)', 'Dashboard::deleteSiswa/$1');
    $routes->post('saveGuru', 'Dashboard::saveGuru');
});


// =================================================================
// 4. AREA ADMIN MANAJEMEN DATA (Dari hasil merge dashboard)
// =================================================================
$routes->get('/admin', 'Admin::index');
$routes->get('admin/pendaftaran', 'Admin::pendaftaran');

// Murid
$routes->get('murid', 'Murid::index');
$routes->get('murid/tambah', 'Murid::tambah');
$routes->post('murid/simpan', 'Murid::simpan');
$routes->get('murid/detail/(:num)', 'Murid::detail/$1');
$routes->get('murid/edit/(:num)', 'Murid::edit/$1');
$routes->post('murid/update/(:num)', 'Murid::update/$1');
$routes->get('murid/hapus/(:num)', 'Murid::hapus/$1');

// GURU
$routes->get('/guru', 'Guru::index');
$routes->get('/guru/tambah', 'Guru::tambah');
$routes->post('/guru/simpan', 'Guru::simpan');
$routes->get('guru/detail/(:num)', 'Guru::detail/$1');
$routes->get('/guru/edit/(:num)', 'Guru::edit/$1');
$routes->post('/guru/update/(:num)', 'Guru::update/$1');
$routes->get('/guru/hapus/(:num)', 'Guru::hapus/$1');

// KELAS
$routes->get('/kelas', 'Kelas::index');
$routes->get('/kelas/tambah', 'Kelas::tambah');
$routes->post('/kelas/simpan', 'Kelas::simpan');
$routes->get('/kelas/edit/(:num)', 'Kelas::edit/$1');
$routes->post('/kelas/update/(:num)', 'Kelas::update/$1');
$routes->get('/kelas/hapus/(:num)', 'Kelas::hapus/$1');
$routes->get('kelas/getGuru/(:num)', 'Kelas::getGuru/$1');

// PENDIDIKAN
$routes->get('/pendidikan', 'Pendidikan::index');
$routes->get('/pendidikan/tambah', 'Pendidikan::tambah');
$routes->post('/pendidikan/simpan', 'Pendidikan::simpan');
$routes->get('/pendidikan/edit/(:num)', 'Pendidikan::edit/$1');
$routes->post('/pendidikan/update/(:num)', 'Pendidikan::update/$1');
$routes->get('/pendidikan/hapus/(:num)', 'Pendidikan::hapus/$1');

// KEHADIRAN (Attendance)
$routes->get('/kehadiran', 'Kehadiran::index');
$routes->get('/kehadiran/input', 'Kehadiran::input');
$routes->post('/kehadiran/simpan', 'Kehadiran::simpan');
$routes->get('/kehadiran/laporan', 'Kehadiran::laporan');

// AKTIVITAS (Activities)
$routes->get('/aktivitas', 'Aktivitas::index');
$routes->get('/aktivitas/tambah', 'Aktivitas::tambah');
$routes->post('/aktivitas/simpan', 'Aktivitas::simpan');
$routes->get('/aktivitas/edit/(:num)', 'Aktivitas::edit/$1');
$routes->post('/aktivitas/update/(:num)', 'Aktivitas::update/$1');
$routes->get('/aktivitas/hapus/(:num)', 'Aktivitas::hapus/$1');
$routes->get('/aktivitas/jadwal-kelas', 'Aktivitas::jadwalKelas');
$routes->get('/aktivitas/tambah-jadwal-kelas', 'Aktivitas::tambahJadwalKelas');
$routes->post('/aktivitas/simpan-jadwal-kelas', 'Aktivitas::simpanJadwalKelas');

// ORANG TUA (Parents)
$routes->get('/orang-tua', 'OrangTua::index');
$routes->get('/orang-tua/tambah', 'OrangTua::tambah');
$routes->post('/orang-tua/simpan', 'OrangTua::simpan');
$routes->get('/orang-tua/detail/(:num)', 'OrangTua::detail/$1');
$routes->get('/orang-tua/edit/(:num)', 'OrangTua::edit/$1');
$routes->post('/orang-tua/update/(:num)', 'OrangTua::update/$1');
$routes->get('/orang-tua/hapus/(:num)', 'OrangTua::hapus/$1');

// JADWAL KELAS (Class Schedule)
$routes->get('/jadwal', 'Jadwal::index');
$routes->get('/jadwal/tambah', 'Jadwal::tambah');
$routes->post('/jadwal/simpan', 'Jadwal::simpan');
$routes->get('/jadwal/edit/(:num)', 'Jadwal::edit/$1');
$routes->post('/jadwal/update/(:num)', 'Jadwal::update/$1');
$routes->get('/jadwal/hapus/(:num)', 'Jadwal::hapus/$1');

// PENGUMUMAN (Announcements)
$routes->get('/pengumuman', 'Pengumuman::index');
$routes->get('/pengumuman/tambah', 'Pengumuman::tambah');
$routes->post('/pengumuman/simpan', 'Pengumuman::simpan');
$routes->get('/pengumuman/edit/(:num)', 'Pengumuman::edit/$1');
$routes->post('/pengumuman/update/(:num)', 'Pengumuman::update/$1');
$routes->post('/pengumuman/toggle-status/(:num)', 'Pengumuman::toggleStatus/$1');
$routes->get('/pengumuman/hapus/(:num)', 'Pengumuman::hapus/$1');

// LIBUR SEKOLAH (School Holidays)
$routes->get('/libur', 'Libur::index');
$routes->get('/libur/tambah', 'Libur::tambah');
$routes->post('/libur/simpan', 'Libur::simpan');
$routes->get('/libur/edit/(:num)', 'Libur::edit/$1');
$routes->post('/libur/update/(:num)', 'Libur::update/$1');
$routes->get('/libur/hapus/(:num)', 'Libur::hapus/$1');

