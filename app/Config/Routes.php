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
$routes->get('/login', 'Auth::index', ['filter' => 'guest']);
$routes->post('/auth/login', 'Auth::login', ['filter' => 'guest']);
$routes->get('/logout', 'Auth::logout', ['filter' => 'auth']);
$routes->post('/auth/logout', 'Auth::logout', ['filter' => 'auth']);

$allRoles = ['filter' => 'role:SuperAdmin,Admin,Staff'];
$adminRoles = ['filter' => 'role:SuperAdmin,Admin'];


// =================================================================
// 3. AREA DASHBOARD GURU / ADMIN INTERNAL (Dari branch dashboard-porto)
// =================================================================
$routes->group('admin', $allRoles, function($routes) {
    $routes->get('dashboard', 'Admin::index');
    $routes->post('saveSiswa', 'Dashboard::saveSiswa');
    $routes->get('deleteSiswa/(:num)', 'Dashboard::deleteSiswa/$1');
    $routes->post('saveGuru', 'Dashboard::saveGuru');
});


// =================================================================
// 4. AREA ADMIN MANAJEMEN DATA (Dari hasil merge dashboard)
// =================================================================
$routes->get('/admin', 'Admin::index', $allRoles);
$routes->get('admin/pendaftaran', 'Admin::pendaftaran', $adminRoles);

// Murid
$routes->get('murid', 'Murid::index', $adminRoles);
$routes->get('murid/tambah', 'Murid::tambah', $adminRoles);
$routes->post('murid/simpan', 'Murid::simpan', $adminRoles);
$routes->get('murid/detail/(:num)', 'Murid::detail/$1', $adminRoles);
$routes->get('murid/edit/(:num)', 'Murid::edit/$1', $adminRoles);
$routes->post('murid/update/(:num)', 'Murid::update/$1', $adminRoles);
$routes->get('murid/hapus/(:num)', 'Murid::hapus/$1', $adminRoles);

// GURU
$routes->get('/guru', 'Guru::index', $adminRoles);
$routes->get('/guru/tambah', 'Guru::tambah', $adminRoles);
$routes->post('/guru/simpan', 'Guru::simpan', $adminRoles);
$routes->get('guru/detail/(:num)', 'Guru::detail/$1', $adminRoles);
$routes->get('/guru/edit/(:num)', 'Guru::edit/$1', $adminRoles);
$routes->post('/guru/update/(:num)', 'Guru::update/$1', $adminRoles);
$routes->get('/guru/hapus/(:num)', 'Guru::hapus/$1', $adminRoles);

// KELAS
$routes->get('/kelas', 'Kelas::index', $adminRoles);
$routes->get('/kelas/tambah', 'Kelas::tambah', $adminRoles);
$routes->post('/kelas/simpan', 'Kelas::simpan', $adminRoles);
$routes->get('/kelas/edit/(:num)', 'Kelas::edit/$1', $adminRoles);
$routes->post('/kelas/update/(:num)', 'Kelas::update/$1', $adminRoles);
$routes->get('/kelas/hapus/(:num)', 'Kelas::hapus/$1', $adminRoles);
$routes->get('kelas/getGuru/(:num)', 'Kelas::getGuru/$1', $adminRoles);

// PENDIDIKAN
$routes->get('/pendidikan', 'Pendidikan::index', $adminRoles);
$routes->get('/pendidikan/tambah', 'Pendidikan::tambah', $adminRoles);
$routes->post('/pendidikan/simpan', 'Pendidikan::simpan', $adminRoles);
$routes->get('/pendidikan/edit/(:num)', 'Pendidikan::edit/$1', $adminRoles);
$routes->post('/pendidikan/update/(:num)', 'Pendidikan::update/$1', $adminRoles);
$routes->get('/pendidikan/hapus/(:num)', 'Pendidikan::hapus/$1', $adminRoles);

// KEHADIRAN (Attendance)
$routes->get('/kehadiran', 'Kehadiran::index', $allRoles);
$routes->get('/kehadiran/input', 'Kehadiran::input', $allRoles);
$routes->post('/kehadiran/simpan', 'Kehadiran::simpan', $allRoles);
$routes->get('/kehadiran/laporan', 'Kehadiran::laporan', $allRoles);

// AKTIVITAS (Activities)
$routes->get('/aktivitas', 'Aktivitas::index', $allRoles);
$routes->get('/aktivitas/tambah', 'Aktivitas::tambah', $allRoles);
$routes->post('/aktivitas/simpan', 'Aktivitas::simpan', $allRoles);
$routes->get('/aktivitas/edit/(:num)', 'Aktivitas::edit/$1', $allRoles);
$routes->post('/aktivitas/update/(:num)', 'Aktivitas::update/$1', $allRoles);
$routes->get('/aktivitas/hapus/(:num)', 'Aktivitas::hapus/$1', $allRoles);
$routes->get('/aktivitas/jadwal-kelas', 'Aktivitas::jadwalKelas', $allRoles);
$routes->get('/aktivitas/tambah-jadwal-kelas', 'Aktivitas::tambahJadwalKelas', $allRoles);
$routes->post('/aktivitas/simpan-jadwal-kelas', 'Aktivitas::simpanJadwalKelas', $allRoles);

// ORANG TUA (Parents)
$routes->get('/orang-tua', 'OrangTua::index', $adminRoles);
$routes->get('/orang-tua/tambah', 'OrangTua::tambah', $adminRoles);
$routes->post('/orang-tua/simpan', 'OrangTua::simpan', $adminRoles);
$routes->get('/orang-tua/detail/(:num)', 'OrangTua::detail/$1', $adminRoles);
$routes->get('/orang-tua/edit/(:num)', 'OrangTua::edit/$1', $adminRoles);
$routes->post('/orang-tua/update/(:num)', 'OrangTua::update/$1', $adminRoles);
$routes->get('/orang-tua/hapus/(:num)', 'OrangTua::hapus/$1', $adminRoles);

// JADWAL KELAS (Class Schedule)
$routes->get('/jadwal', 'Jadwal::index', $allRoles);
$routes->get('/jadwal/tambah', 'Jadwal::tambah', $allRoles);
$routes->post('/jadwal/simpan', 'Jadwal::simpan', $allRoles);
$routes->get('/jadwal/edit/(:num)', 'Jadwal::edit/$1', $allRoles);
$routes->post('/jadwal/update/(:num)', 'Jadwal::update/$1', $allRoles);
$routes->get('/jadwal/hapus/(:num)', 'Jadwal::hapus/$1', $allRoles);

// PENGUMUMAN (Announcements)
$routes->get('/pengumuman', 'Pengumuman::index', $allRoles);
$routes->get('/pengumuman/tambah', 'Pengumuman::tambah', $allRoles);
$routes->post('/pengumuman/simpan', 'Pengumuman::simpan', $allRoles);
$routes->get('/pengumuman/edit/(:num)', 'Pengumuman::edit/$1', $allRoles);
$routes->post('/pengumuman/update/(:num)', 'Pengumuman::update/$1', $allRoles);
$routes->post('/pengumuman/toggle-status/(:num)', 'Pengumuman::toggleStatus/$1', $allRoles);
$routes->get('/pengumuman/hapus/(:num)', 'Pengumuman::hapus/$1', $allRoles);

// LIBUR SEKOLAH (School Holidays)
$routes->get('/libur', 'Libur::index', $allRoles);
$routes->get('/libur/tambah', 'Libur::tambah', $allRoles);
$routes->post('/libur/simpan', 'Libur::simpan', $allRoles);
$routes->get('/libur/edit/(:num)', 'Libur::edit/$1', $allRoles);
$routes->post('/libur/update/(:num)', 'Libur::update/$1', $allRoles);
$routes->get('/libur/hapus/(:num)', 'Libur::hapus/$1', $allRoles);

