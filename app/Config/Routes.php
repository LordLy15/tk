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

$dashboardRoles     = ['filter' => 'role:Administrator,Admin,Guru,Staff'];
$muridGuruKelasRoles = ['filter' => 'role:Administrator,Admin,Staff'];
$pendidikanRoles    = ['filter' => 'role:Administrator,Admin'];
$pendaftaranRoles   = ['filter' => 'role:Administrator,Admin,Staff'];
$kehadiranRoles     = ['filter' => 'role:Administrator,Admin,Guru'];
$aktivitasRoles     = ['filter' => 'role:Administrator,Admin,Guru'];
$orangTuaRoles      = ['filter' => 'role:Administrator,Admin,Staff'];
$jadwalRoles        = ['filter' => 'role:Administrator,Admin,Guru'];
$pengumumanRoles    = ['filter' => 'role:Administrator,Admin,Staff'];
$liburRoles         = ['filter' => 'role:Administrator,Admin,Guru,Staff'];
$developerRoles     = ['filter' => 'role:Administrator'];
$userManagementRoles = ['filter' => 'role:Administrator'];


// =================================================================
// 3. AREA DASHBOARD GURU / ADMIN INTERNAL (Dari branch dashboard-porto)
// =================================================================
$routes->group('admin', $dashboardRoles, function($routes) use ($developerRoles, $userManagementRoles) {
    $routes->get('dashboard', 'Admin::index');
    $routes->post('saveSiswa', 'Dashboard::saveSiswa');
    $routes->get('deleteSiswa/(:num)', 'Dashboard::deleteSiswa/$1');
    $routes->post('saveGuru', 'Dashboard::saveGuru');
    
    // DEVELOPER MAINTENANCE PANEL ROUTES (Nested under admin group, but restricted)
    $routes->get('developer', 'Developer::index', $developerRoles);
    $routes->post('developer/toggle-maintenance', 'Developer::toggleMaintenance', $developerRoles);
    $routes->get('developer/clear-cache', 'Developer::clearCache', $developerRoles);
    $routes->get('developer/clear-logs', 'Developer::clearLogs', $developerRoles);
    $routes->get('developer/reset-db', 'Developer::resetDatabase', $developerRoles);
    $routes->get('developer/logs', 'Developer::logs', $developerRoles);

    // USER MANAGEMENT (CRUD)
    $routes->get('users', 'Users::index', $userManagementRoles);
    $routes->get('users/tambah', 'Users::tambah', $userManagementRoles);
    $routes->post('users/simpan', 'Users::simpan', $userManagementRoles);
    $routes->get('users/edit/(:num)', 'Users::edit/$1', $userManagementRoles);
    $routes->post('users/update/(:num)', 'Users::update/$1', $userManagementRoles);
    $routes->get('users/hapus/(:num)', 'Users::hapus/$1', $userManagementRoles);
});

// PUBLIC MAINTENANCE PAGE ROUTE
$routes->get('maintenance', static function() {
    return view('Developer/maintenance');
});


// =================================================================
// 4. AREA ADMIN MANAJEMEN DATA (Dari hasil merge dashboard)
// =================================================================
$routes->get('/admin', 'Admin::index', $dashboardRoles);
$routes->get('admin/pendaftaran', 'Admin::pendaftaran', $pendaftaranRoles);

// Murid
$routes->get('murid', 'Murid::index', $muridGuruKelasRoles);
$routes->get('murid/tambah', 'Murid::tambah', $muridGuruKelasRoles);
$routes->post('murid/simpan', 'Murid::simpan', $muridGuruKelasRoles);
$routes->get('murid/detail/(:num)', 'Murid::detail/$1', $muridGuruKelasRoles);
$routes->get('murid/edit/(:num)', 'Murid::edit/$1', $muridGuruKelasRoles);
$routes->post('murid/update/(:num)', 'Murid::update/$1', $muridGuruKelasRoles);
$routes->get('murid/hapus/(:num)', 'Murid::hapus/$1', $muridGuruKelasRoles);

// GURU
$routes->get('/guru', 'Guru::index', $muridGuruKelasRoles);
$routes->get('/guru/tambah', 'Guru::tambah', $muridGuruKelasRoles);
$routes->post('/guru/simpan', 'Guru::simpan', $muridGuruKelasRoles);
$routes->get('guru/detail/(:num)', 'Guru::detail/$1', $muridGuruKelasRoles);
$routes->get('/guru/edit/(:num)', 'Guru::edit/$1', $muridGuruKelasRoles);
$routes->post('/guru/update/(:num)', 'Guru::update/$1', $muridGuruKelasRoles);
$routes->get('/guru/hapus/(:num)', 'Guru::hapus/$1', $muridGuruKelasRoles);

// KELAS
$routes->get('/kelas', 'Kelas::index', $muridGuruKelasRoles);
$routes->get('/kelas/tambah', 'Kelas::tambah', $muridGuruKelasRoles);
$routes->post('/kelas/simpan', 'Kelas::simpan', $muridGuruKelasRoles);
$routes->get('/kelas/edit/(:num)', 'Kelas::edit/$1', $muridGuruKelasRoles);
$routes->post('/kelas/update/(:num)', 'Kelas::update/$1', $muridGuruKelasRoles);
$routes->get('/kelas/hapus/(:num)', 'Kelas::hapus/$1', $muridGuruKelasRoles);
$routes->get('kelas/getGuru/(:num)', 'Kelas::getGuru/$1', $muridGuruKelasRoles);

// PENDIDIKAN
$routes->get('/pendidikan', 'Pendidikan::index', $pendidikanRoles);
$routes->get('/pendidikan/tambah', 'Pendidikan::tambah', $pendidikanRoles);
$routes->post('/pendidikan/simpan', 'Pendidikan::simpan', $pendidikanRoles);
$routes->get('/pendidikan/edit/(:num)', 'Pendidikan::edit/$1', $pendidikanRoles);
$routes->post('/pendidikan/update/(:num)', 'Pendidikan::update/$1', $pendidikanRoles);
$routes->get('/pendidikan/hapus/(:num)', 'Pendidikan::hapus/$1', $pendidikanRoles);

// KEHADIRAN (Attendance)
$routes->get('/kehadiran', 'Kehadiran::index', $kehadiranRoles);
$routes->get('/kehadiran/input', 'Kehadiran::input', $kehadiranRoles);
$routes->post('/kehadiran/simpan', 'Kehadiran::simpan', $kehadiranRoles);
$routes->get('/kehadiran/laporan', 'Kehadiran::laporan', $kehadiranRoles);

// AKTIVITAS (Activities)
$routes->get('/aktivitas', 'Aktivitas::index', $aktivitasRoles);
$routes->get('/aktivitas/tambah', 'Aktivitas::tambah', $aktivitasRoles);
$routes->post('/aktivitas/simpan', 'Aktivitas::simpan', $aktivitasRoles);
$routes->get('/aktivitas/edit/(:num)', 'Aktivitas::edit/$1', $aktivitasRoles);
$routes->post('/aktivitas/update/(:num)', 'Aktivitas::update/$1', $aktivitasRoles);
$routes->get('/aktivitas/hapus/(:num)', 'Aktivitas::hapus/$1', $aktivitasRoles);
$routes->get('/aktivitas/jadwal-kelas', 'Aktivitas::jadwalKelas', $aktivitasRoles);
$routes->get('/aktivitas/tambah-jadwal-kelas', 'Aktivitas::tambahJadwalKelas', $aktivitasRoles);
$routes->post('/aktivitas/simpan-jadwal-kelas', 'Aktivitas::simpanJadwalKelas', $aktivitasRoles);

// ORANG TUA (Parents)
$routes->get('/orang-tua', 'OrangTua::index', $orangTuaRoles);
$routes->get('/orang-tua/tambah', 'OrangTua::tambah', $orangTuaRoles);
$routes->post('/orang-tua/simpan', 'OrangTua::simpan', $orangTuaRoles);
$routes->get('/orang-tua/detail/(:num)', 'OrangTua::detail/$1', $orangTuaRoles);
$routes->get('/orang-tua/edit/(:num)', 'OrangTua::edit/$1', $orangTuaRoles);
$routes->post('/orang-tua/update/(:num)', 'OrangTua::update/$1', $orangTuaRoles);
$routes->get('/orang-tua/hapus/(:num)', 'OrangTua::hapus/$1', $orangTuaRoles);

// JADWAL KELAS (Class Schedule)
$routes->get('/jadwal', 'Jadwal::index', $jadwalRoles);
$routes->get('/jadwal/tambah', 'Jadwal::tambah', $jadwalRoles);
$routes->post('/jadwal/simpan', 'Jadwal::simpan', $jadwalRoles);
$routes->get('/jadwal/edit/(:num)', 'Jadwal::edit/$1', $jadwalRoles);
$routes->post('/jadwal/update/(:num)', 'Jadwal::update/$1', $jadwalRoles);
$routes->get('/jadwal/hapus/(:num)', 'Jadwal::hapus/$1', $jadwalRoles);

// PENGUMUMAN (Announcements)
$routes->get('/pengumuman', 'Pengumuman::index', $pengumumanRoles);
$routes->get('/pengumuman/tambah', 'Pengumuman::tambah', $pengumumanRoles);
$routes->post('/pengumuman/simpan', 'Pengumuman::simpan', $pengumumanRoles);
$routes->get('/pengumuman/edit/(:num)', 'Pengumuman::edit/$1', $pengumumanRoles);
$routes->post('/pengumuman/update/(:num)', 'Pengumuman::update/$1', $pengumumanRoles);
$routes->post('/pengumuman/toggle-status/(:num)', 'Pengumuman::toggleStatus/$1', $pengumumanRoles);
$routes->get('/pengumuman/hapus/(:num)', 'Pengumuman::hapus/$1', $pengumumanRoles);

// LIBUR SEKOLAH (School Holidays)
$routes->get('/libur', 'Libur::index', $liburRoles);
$routes->get('/libur/tambah', 'Libur::tambah', $liburRoles);
$routes->post('/libur/simpan', 'Libur::simpan', $liburRoles);
$routes->get('/libur/edit/(:num)', 'Libur::edit/$1', $liburRoles);
$routes->post('/libur/update/(:num)', 'Libur::update/$1', $liburRoles);
$routes->get('/libur/hapus/(:num)', 'Libur::hapus/$1', $liburRoles);


// ============================================================
// ORANG TUA — Auth & Pembayaran
// ============================================================
$routes->group('orangtua', function($routes) {
    // Public (tidak perlu login)
    $routes->get('login',  'OrangTua\AuthController::login');
    $routes->post('login', 'OrangTua\AuthController::loginProses');
    $routes->get('logout', 'OrangTua\AuthController::logout');

    // Protected (harus login orang tua)
    $routes->group('', ['filter' => 'orangtuaauth'], function($routes) {
        $routes->get('dashboard',              'OrangTua\PembayaranController::dashboard');
        $routes->get('pembayaran',             'OrangTua\PembayaranController::index');
        $routes->get('pembayaran/(:num)',      'OrangTua\PembayaranController::detail/$1');
        $routes->post('pembayaran/upload/(:num)', 'OrangTua\PembayaranController::uploadBukti/$1');
        $routes->get('ubah-password',           'OrangTua\AuthController::ubahPassword');
        $routes->post('ubah-password/simpan',  'OrangTua\AuthController::simpanPassword');
    });
});

// ============================================================
// ADMIN — Verifikasi Pembayaran & CRUD E-Book
// ============================================================
$verifikasiRoles = ['filter' => 'role:Administrator,Admin,Staff'];
$ebookRoles = ['filter' => 'role:Administrator,Admin,Staff'];

$routes->group('admin/verifikasi-pembayaran', $verifikasiRoles, function($routes) {
    $routes->get('/',              'Admin\VerifikasiPembayaranController::index');
    $routes->get('(:num)',        'Admin\VerifikasiPembayaranController::detail/$1');
    $routes->post('proses/(:num)','Admin\VerifikasiPembayaranController::proses/$1');
});

$routes->group('admin/ebook', $ebookRoles, function($routes) {
    $routes->get('/',            'Admin\EbookController::index');
    $routes->get('tambah',       'Admin\EbookController::tambah');
    $routes->post('simpan',      'Admin\EbookController::simpan');
    $routes->get('edit/(:num)', 'Admin\EbookController::edit/$1');
    $routes->post('update/(:num)','Admin\EbookController::update/$1');
    $routes->get('hapus/(:num)', 'Admin\EbookController::hapus/$1');
});

// Akun Orang Tua untuk Pembayaran
$routes->group('admin/spay-orang-tua', $verifikasiRoles, function($routes) {
    $routes->get('/',              'Admin\SpayOrangTuaController::index');
    $routes->get('tambah',       'Admin\SpayOrangTuaController::tambah');
    $routes->post('simpan',      'Admin\SpayOrangTuaController::simpan');
    $routes->get('edit/(:num)', 'Admin\SpayOrangTuaController::edit/$1');
    $routes->post('update/(:num)','Admin\SpayOrangTuaController::update/$1');
    $routes->get('hapus/(:num)', 'Admin\SpayOrangTuaController::hapus/$1');
});

// Tagihan Pembayaran
$routes->group('admin/spay-tagihan', $verifikasiRoles, function($routes) {
    $routes->get('/',              'Admin\SpayTagihanController::index');
    $routes->get('tambah',       'Admin\SpayTagihanController::tambah');
    $routes->post('simpan',      'Admin\SpayTagihanController::simpan');
    $routes->get('get-orang-tua-by-kelas', 'Admin\SpayTagihanController::getOrangTuaByKelas');
    $routes->get('edit/(:num)', 'Admin\SpayTagihanController::edit/$1');
    $routes->post('update/(:num)','Admin\SpayTagihanController::update/$1');
    $routes->get('hapus/(:num)', 'Admin\SpayTagihanController::hapus/$1');
});

// ============================================================
// PUBLIC E-BOOK — Semua orang tua & siswa
// ============================================================
$routes->get('ebook',                    'Ebook\PublicEbookController::index');
$routes->get('ebook/download/(:num)',    'Ebook\PublicEbookController::download/$1');

