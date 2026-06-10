# Fitur Pembayaran & E-Book - Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Implementasi fitur login orang tua, dashboard pembayaran, dan e-book dengan tema ungu menarik dan animasi moderat.

**Architecture:** Fitur独立性 tinggi menggunakan prefix tabel `spay_` dan `sebook_`, session terpisah dari admin, route terisolasi di namespace `/orangtua/`, `/admin/verifikasi-pembayaran`, `/admin/ebook`, dan `/ebook`.

**Tech Stack:** CodeIgniter 4, PHP 8.x, MySQL, Bootstrap 5, Custom CSS animations

---

## File Map

### Database Migrations (Create)
- `app/Database/Migrations/2026-06-08-000001_CreateSpayOrangTua.php`
- `app/Database/Migrations/2026-06-08-000002_CreateSpayTagihan.php`
- `app/Database/Migrations/2026-06-08-000003_CreateSpayPembayaran.php`
- `app/Database/Migrations/2026-06-08-000004_CreateSebookEbook.php`

### Models (Create)
- `app/Models/OrangTuaModel.php` - Model untuk tabel spay_orang_tua
- `app/Models/PembayaranModel.php` - Model untuk spay_tagihan & spay_pembayaran
- `app/Models/EbookModel.php` - Model untuk tabel sebook_ebook

### Controllers - Orang Tua (Create)
- `app/Controllers/OrangTua/AuthController.php` - Login/logout orang tua
- `app/Controllers/OrangTua/PembayaranController.php` - Dashboard, list tagihan, detail, upload bukti

### Controllers - Admin Baru (Create)
- `app/Controllers/Admin/VerifikasiPembayaranController.php` - Verifikasi pembayaran masuk
- `app/Controllers/Admin/EbookController.php` - CRUD e-book untuk admin

### Controllers - E-Book Public (Create)
- `app/Controllers/Ebook/PublicEbookController.php` - Galeri & download e-book

### Filters (Create)
- `app/Filters/OrangTuaAuthFilter.php` - Middleware auth orang tua

### Views - Orang Tua (Create with Animasi)
- `app/Views/orangtua/auth/login.php` - Login page dengan tema ungu
- `app/Views/orangtua/dashboard.php` - Dashboard dengan card animasi
- `app/Views/orangtua/pembayaran/index.php` - List tagihan
- `app/Views/orangtua/pembayaran/detail.php` - Detail tagihan + upload bukti

### Views - Admin Baru (Create)
- `app/Views/admin/pembayaran/index.php` - List verifikasi pembayaran
- `app/Views/admin/pembayaran/verifikasi.php` - Form verifikasi
- `app/Views/admin/ebook/index.php` - List e-book
- `app/Views/admin/ebook/create.php` - Form tambah e-book
- `app/Views/admin/ebook/edit.php` - Form edit e-book

### Views - E-Book Public (Create)
- `app/Views/public_ebook/index.php` - Galeri e-book

### CSS Custom (Create)
- `assets/dashboard/css/orangtua-custom.css` - Styling tema ungu + animasi

### Config Modifications
- `app/Config/Routes.php` - Tambahkan routes baru
- `app/Config/Filters.php` - Daftarkan OrangTuaAuthFilter

### TIDAK PERLU DIRUBAH
- `app/Views/Admin/*` - Sidebar, dashboard admin tetap seperti semula
- `app/Controllers/Admin.php` - Tidak diubah
- Database tabel lama - Hanya buat tabel baru

---

## PHASE 1: Database & Setup

### Task 1: Buat Database Migrations

**Files:**
- Create: `app/Database/Migrations/2026-06-08-000001_CreateSpayOrangTua.php`
- Create: `app/Database/Migrations/2026-06-08-000002_CreateSpayTagihan.php`
- Create: `app/Database/Migrations/2026-06-08-000003_CreateSpayPembayaran.php`
- Create: `app/Database/Migrations/2026-06-08-000004_CreateSebookEbook.php`

- [ ] **Step 1: Buat migration spay_orang_tua**

```php
<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateSpayOrangTua extends Migration {
    public function up() {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'no_hp'      => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'nama_siswa' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'kelas'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('spay_orang_tua');
    }
    public function down() {
        $this->forge->dropTable('spay_orang_tua');
    }
}
```

- [ ] **Step 2: Buat migration spay_tagihan**

```php
<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateSpayTagihan extends Migration {
    public function up() {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'orang_tua_id' => ['type' => 'INT'],
            'judul'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'nominal'      => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'batas_bayar'  => ['type' => 'DATE', 'null' => true],
            'keterangan'   => ['type' => 'TEXT', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('orang_tua_id', 'spay_orang_tua', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('spay_tagihan');
    }
    public function down() {
        $this->forge->dropTable('spay_tagihan');
    }
}
```

- [ ] **Step 3: Buat migration spay_pembayaran**

```php
<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateSpayPembayaran extends Migration {
    public function up() {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'auto_increment' => true],
            'tagihan_id'     => ['type' => 'INT'],
            'orang_tua_id'   => ['type' => 'INT'],
            'bukti_bayar'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tanggal_bayar'  => ['type' => 'DATE', 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['pending','verified','rejected'], 'default' => 'pending'],
            'catatan_admin'  => ['type' => 'TEXT', 'null' => true],
            'verified_at'    => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('tagihan_id', 'spay_tagihan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('orang_tua_id', 'spay_orang_tua', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('spay_pembayaran');
    }
    public function down() {
        $this->forge->dropTable('spay_pembayaran');
    }
}
```

- [ ] **Step 4: Buat migration sebook_ebook**

```php
<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateSeBookEbook extends Migration {
    public function up() {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'judul'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi'  => ['type' => 'TEXT', 'null' => true],
            'penulis'    => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'kategori'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'cover'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'file_path'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'kelas'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_by' => ['type' => 'INT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('sebook_ebook');
    }
    public function down() {
        $this->forge->dropTable('sebook_ebook');
    }
}
```

- [ ] **Step 5: Jalankan migrations**

Run: `php spark migrate`

---

### Task 2: Buat Folder Upload

**Files:**
- Create: `writable/uploads/bukti_bayar/` (folder)
- Create: `writable/uploads/ebook/cover/` (folder)
- Create: `writable/uploads/ebook/file/` (folder)

- [ ] **Step 1: Buat folder-folder upload**

Run: `mkdir -p writable/uploads/bukti_bayar writable/uploads/ebook/cover writable/uploads/ebook/file`

---

### Task 3: Konfigurasi Filter & Routes

**Files:**
- Modify: `app/Config/Filters.php` - Tambahkan OrangTuaAuthFilter
- Modify: `app/Config/Routes.php` - Tambahkan routes baru

- [ ] **Step 1: Tambahkan filter di Filters.php**

Tambahkan di array `$aliases`:
```php
'orangtuaauth' => \App\Filters\OrangTuaAuthFilter::class,
```

- [ ] **Step 2: Tambahkan routes di Routes.php**

Tambahkan di bagian BAWAH file (setelah semua route yang ada):

```php
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
    });
});

// ============================================================
// ADMIN — Verifikasi Pembayaran & CRUD E-Book
// ============================================================
$verifikasiRoles = ['filter' => 'role:Administrator,Admin'];
$ebookRoles = ['filter' => 'role:Administrator,Admin'];

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

// ============================================================
// PUBLIC E-BOOK — Semua orang tua & siswa
// ============================================================
$routes->get('ebook',                    'Ebook\PublicEbookController::index');
$routes->get('ebook/download/(:num)',    'Ebook\PublicEbookController::download/$1');
```

---

## PHASE 2: Models

### Task 4: Buat Models

**Files:**
- Create: `app/Models/OrangTuaModel.php`
- Create: `app/Models/PembayaranModel.php`
- Create: `app/Models/EbookModel.php`

- [ ] **Step 1: Buat OrangTuaModel.php**

```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class OrangTuaModel extends Model {
    protected $table      = 'spay_orang_tua';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama','email','password','no_hp','nama_siswa','kelas','is_active','created_at','updated_at'];
}
```

- [ ] **Step 2: Buat PembayaranModel.php**

```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class PembayaranModel extends Model {
    protected $table      = 'spay_pembayaran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tagihan_id','orang_tua_id','bukti_bayar','tanggal_bayar','status','catatan_admin','verified_at','created_at','updated_at'];

    public function getTagihanByOrangTua($orangTuaId, $status = null) {
        $builder = $this->db->table('spay_tagihan t')
            ->select('t.*, p.status, p.bukti_bayar, p.id as pembayaran_id, p.created_at as bayar_created_at')
            ->join('spay_pembayaran p', 'p.tagihan_id = t.id AND p.orang_tua_id = t.orang_tua_id', 'left')
            ->where('t.orang_tua_id', $orangTuaId);
        if ($status) $builder->where('p.status', $status);
        return $builder->orderBy('t.batas_bayar', 'ASC')->get()->getResultArray();
    }

    public function getDetailTagihan($tagihanId, $orangTuaId) {
        return $this->db->table('spay_tagihan t')
            ->select('t.*, p.status, p.bukti_bayar, p.catatan_admin, p.id as pembayaran_id, p.tanggal_bayar, p.verified_at')
            ->join('spay_pembayaran p', 'p.tagihan_id = t.id', 'left')
            ->where('t.id', $tagihanId)
            ->where('t.orang_tua_id', $orangTuaId)
            ->get()->getRowArray();
    }

    public function getAllPembayaran() {
        return $this->db->table('spay_pembayaran p')
            ->select('p.*, t.judul, t.nominal, ot.nama as nama_ortu, ot.nama_siswa, ot.kelas')
            ->join('spay_tagihan t', 't.id = p.tagihan_id')
            ->join('spay_orang_tua ot', 'ot.id = p.orang_tua_id')
            ->orderBy('p.created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function getPembayaranDetail($id) {
        return $this->db->table('spay_pembayaran p')
            ->select('p.*, t.judul, t.nominal, t.keterangan, ot.nama as nama_ortu, ot.nama_siswa, ot.kelas, ot.no_hp')
            ->join('spay_tagihan t', 't.id = p.tagihan_id')
            ->join('spay_orang_tua ot', 'ot.id = p.orang_tua_id')
            ->where('p.id', $id)
            ->get()->getRowArray();
    }

    public function simpanPembayaran($data) {
        return $this->db->table('spay_pembayaran')->insert($data);
    }

    public function updateStatus($id, $status, $catatan = null) {
        $updateData = [
            'status'      => $status,
            'verified_at' => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];
        if ($catatan) $updateData['catatan_admin'] = $catatan;
        return $this->db->table('spay_pembayaran')->where('id', $id)->update($updateData);
    }

    public function getStatsByOrangTua($orangTuaId) {
        $tagihan = $this->db->table('spay_tagihan')
            ->where('orang_tua_id', $orangTuaId)
            ->get()->getResultArray();

        $total = 0;
        $pending = 0;
        $lunas = 0;
        $pendingCount = 0;
        $lunasCount = 0;

        foreach ($tagihan as $t) {
            $total += (float) $t['nominal'];
            $pembayaran = $this->db->table('spay_pembayaran')
                ->where('tagihan_id', $t['id'])
                ->where('status', 'verified')
                ->get()->getRowArray();
            if ($pembayaran) {
                $lunas += (float) $t['nominal'];
                $lunasCount++;
            } else {
                $pending += (float) $t['nominal'];
                $pendingCount++;
            }
        }

        return [
            'total' => $total,
            'pending' => $pending,
            'lunas' => $lunas,
            'pending_count' => $pendingCount,
            'lunas_count' => $lunasCount,
        ];
    }
}
```

- [ ] **Step 3: Buat EbookModel.php**

```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class EbookModel extends Model {
    protected $table      = 'sebook_ebook';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul','deskripsi','penulis','kategori','cover','file_path','kelas','is_active','created_by','created_at','updated_at'];

    public function getKategoriList() {
        return $this->db->table('sebook_ebook')
            ->select('kategori')->distinct()
            ->where('is_active', 1)
            ->where('kategori IS NOT NULL')
            ->get()->getResultArray();
    }

    public function getLatestEbooks($limit = 4) {
        return $this->where('is_active', 1)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
```

---

## PHASE 3: Filter & Controllers

### Task 5: Buat OrangTuaAuthFilter

**Files:**
- Create: `app/Filters/OrangTuaAuthFilter.php`

- [ ] **Step 1: Buat filter**

```php
<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class OrangTuaAuthFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        if (!session()->get('orangtua_logged_in')) {
            return redirect()->to('/orangtua/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
```

---

### Task 6: Buat AuthController

**Files:**
- Create: `app/Controllers/OrangTua/AuthController.php`

- [ ] **Step 1: Buat controller**

```php
<?php
namespace App\Controllers\OrangTua;
use App\Controllers\BaseController;
use App\Models\OrangTuaModel;

class AuthController extends BaseController {
    public function login() {
        if (session()->get('orangtua_logged_in')) {
            return redirect()->to('/orangtua/dashboard');
        }
        return view('orangtua/auth/login');
    }

    public function loginProses() {
        $model = new OrangTuaModel();
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)
                      ->where('is_active', 1)
                      ->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'orangtua_logged_in' => true,
                'orangtua_id'        => $user['id'],
                'orangtua_nama'      => $user['nama'],
                'orangtua_nama_siswa'=> $user['nama_siswa'] ?? '',
            ]);
            return redirect()->to('/orangtua/dashboard');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Email atau password salah.');
    }

    public function logout() {
        session()->remove(['orangtua_logged_in', 'orangtua_id', 'orangtua_nama', 'orangtua_nama_siswa']);
        return redirect()->to('/orangtua/login');
    }
}
```

---

### Task 7: Buat PembayaranController

**Files:**
- Create: `app/Controllers/OrangTua/PembayaranController.php`

- [ ] **Step 1: Buat controller**

```php
<?php
namespace App\Controllers\OrangTua;
use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\EbookModel;

class PembayaranController extends BaseController {
    protected $pembayaranModel;
    protected $ebookModel;

    public function __construct() {
        $this->pembayaranModel = new PembayaranModel();
        $this->ebookModel = new EbookModel();
    }

    public function dashboard() {
        $id = session()->get('orangtua_id');
        $data['stats'] = $this->pembayaranModel->getStatsByOrangTua($id);
        $data['tagihan_aktif'] = $this->pembayaranModel->getTagihanByOrangTua($id, 'pending');
        $data['tagihan_terbaru'] = array_slice($this->pembayaranModel->getTagihanByOrangTua($id), 0, 3);
        $data['ebooks'] = $this->ebookModel->getLatestEbooks(4);
        return view('orangtua/dashboard', $data);
    }

    public function index() {
        $id = session()->get('orangtua_id');
        $status = $this->request->getGet('status');
        $data['tagihan'] = $this->pembayaranModel->getTagihanByOrangTua($id, $status ?: null);
        $data['filter_status'] = $status;
        return view('orangtua/pembayaran/index', $data);
    }

    public function detail($id) {
        $orangTuaId = session()->get('orangtua_id');
        $data['tagihan'] = $this->pembayaranModel->getDetailTagihan($id, $orangTuaId);

        if (!$data['tagihan']) {
            return redirect()->to('/orangtua/pembayaran')
                ->with('error', 'Tagihan tidak ditemukan.');
        }
        return view('orangtua/pembayaran/detail', $data);
    }

    public function uploadBukti($tagihanId) {
        $file = $this->request->getFile('bukti_bayar');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Format file harus JPG, PNG, atau PDF.');
        }

        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file->getSize() > $maxSize) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 5MB.');
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/bukti_bayar', $newName);

        $this->pembayaranModel->simpanPembayaran([
            'tagihan_id'    => $tagihanId,
            'orang_tua_id'  => session()->get('orangtua_id'),
            'bukti_bayar'   => $newName,
            'tanggal_bayar' => date('Y-m-d'),
            'status'        => 'pending',
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/orangtua/pembayaran')
            ->with('success', 'Bukti pembayaran berhasil dikirim, menunggu verifikasi admin.');
    }
}
```

---

### Task 8: Buat VerifikasiPembayaranController

**Files:**
- Create: `app/Controllers/Admin/VerifikasiPembayaranController.php`

- [ ] **Step 1: Buat controller**

```php
<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PembayaranModel;

class VerifikasiPembayaranController extends BaseController {
    protected $model;

    public function __construct() {
        $this->model = new PembayaranModel();
    }

    public function index() {
        $data['pembayaran'] = $this->model->getAllPembayaran();
        return view('admin/pembayaran/index', $data);
    }

    public function detail($id) {
        $data['pembayaran'] = $this->model->getPembayaranDetail($id);
        if (!$data['pembayaran']) {
            return redirect()->to('/admin/verifikasi-pembayaran')
                ->with('error', 'Data tidak ditemukan.');
        }
        return view('admin/pembayaran/verifikasi', $data);
    }

    public function proses($id) {
        $status  = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        if (!in_array($status, ['verified', 'rejected'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $this->model->updateStatus($id, $status, $catatan);

        $msg = $status === 'verified'
            ? 'Pembayaran berhasil diverifikasi.'
            : 'Pembayaran ditolak.';
        return redirect()->to('/admin/verifikasi-pembayaran')->with('success', $msg);
    }
}
```

---

### Task 9: Buat EbookController

**Files:**
- Create: `app/Controllers/Admin/EbookController.php`

- [ ] **Step 1: Buat controller**

```php
<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\EbookModel;

class EbookController extends BaseController {
    protected $model;

    public function __construct() {
        $this->model = new EbookModel();
    }

    public function index() {
        $data['ebooks'] = $this->model->findAll();
        return view('admin/ebook/index', $data);
    }

    public function tambah() {
        return view('admin/ebook/create');
    }

    public function simpan() {
        $cover = $this->request->getFile('cover');
        $file  = $this->request->getFile('file_pdf');

        $validation = $this->validate([
            'file_pdf' => 'uploaded[file_pdf]|max_size[file_pdf,10240]|mime_in[file_pdf,application/pdf]',
            'cover'    => 'max_size[cover,2048]|mime_in[cover,image/jpg,image/jpeg,image/png]',
        ]);

        if (!$validation) {
            return redirect()->back()->with('error', 'File tidak valid. PDF wajib, cover gambar JPG/PNG.');
        }

        $coverName = null;
        if ($cover && $cover->isValid()) {
            $coverName = $cover->getRandomName();
            $cover->move(WRITEPATH . 'uploads/ebook/cover', $coverName);
        }

        $fileName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/ebook/file', $fileName);

        $this->model->insert([
            'judul'      => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'penulis'   => $this->request->getPost('penulis'),
            'kategori'  => $this->request->getPost('kategori'),
            'kelas'     => $this->request->getPost('kelas'),
            'cover'     => $coverName,
            'file_path' => $fileName,
            'is_active' => 1,
            'created_by'=> session()->get('user_id'),
            'created_at'=> date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/ebook')->with('success', 'E-Book berhasil ditambahkan.');
    }

    public function edit($id) {
        $data['ebook'] = $this->model->find($id);
        if (!$data['ebook']) {
            return redirect()->to('/admin/ebook')->with('error', 'E-Book tidak ditemukan.');
        }
        return view('admin/ebook/edit', $data);
    }

    public function update($id) {
        $updateData = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'penulis'   => $this->request->getPost('penulis'),
            'kategori'  => $this->request->getPost('kategori'),
            'kelas'     => $this->request->getPost('kelas'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ];

        $file = $this->request->getFile('file_pdf');
        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/ebook/file', $fileName);
            $updateData['file_path'] = $fileName;
        }

        $cover = $this->request->getFile('cover');
        if ($cover && $cover->isValid()) {
            $coverName = $cover->getRandomName();
            $cover->move(WRITEPATH . 'uploads/ebook/cover', $coverName);
            $updateData['cover'] = $coverName;
        }

        $this->model->update($id, $updateData);
        return redirect()->to('/admin/ebook')->with('success', 'E-Book berhasil diperbarui.');
    }

    public function hapus($id) {
        $this->model->update($id, ['is_active' => 0]);
        return redirect()->to('/admin/ebook')->with('success', 'E-Book berhasil dihapus.');
    }
}
```

---

### Task 10: Buat PublicEbookController

**Files:**
- Create: `app/Controllers/Ebook/PublicEbookController.php`

- [ ] **Step 1: Buat controller**

```php
<?php
namespace App\Controllers\Ebook;
use App\Controllers\BaseController;
use App\Models\EbookModel;

class PublicEbookController extends BaseController {
    public function index() {
        $model = new EbookModel();
        $kategori = $this->request->getGet('kategori');

        $builder = $model->where('is_active', 1);
        if ($kategori) {
            $builder = $builder->where('kategori', $kategori);
        }
        $data['ebooks'] = $builder->orderBy('created_at', 'DESC')->findAll();
        $data['kategoris'] = $model->getKategoriList();
        $data['filter_kategori'] = $kategori;

        return view('public_ebook/index', $data);
    }

    public function download($id) {
        $model = new EbookModel();
        $ebook = $model->find($id);

        if (!$ebook || !$ebook['is_active']) {
            return redirect()->to('/ebook')->with('error', 'E-Book tidak ditemukan.');
        }

        $path = WRITEPATH . 'uploads/ebook/file/' . $ebook['file_path'];
        if (!file_exists($path)) {
            return redirect()->to('/ebook')->with('error', 'File tidak ditemukan.');
        }

        return $this->response->download($path, null)
            ->setFileName($ebook['judul'] . '.pdf');
    }
}
```

---

## PHASE 4: Views - Login & Dashboard Orang Tua

### Task 11: Buat CSS Custom Animasi

**Files:**
- Create: `assets/dashboard/css/orangtua-custom.css`

- [ ] **Step 1: Buat CSS dengan tema ungu dan animasi**

```css
/* ============================================
   TEMA UNGU - ORANG TUA DASHBOARD
   ============================================ */

:root {
    --ot-primary: #8b5cf6;
    --ot-primary-dark: #7c3aed;
    --ot-primary-light: #a78bfa;
    --ot-primary-glow: rgba(139, 92, 246, 0.25);
    --ot-secondary: #f1f5f9;
    --ot-accent: #f59e0b;
    --ot-success: #10b981;
    --ot-warning: #f59e0b;
    --ot-danger: #ef4444;
    --ot-text-dark: #1e293b;
    --ot-text-muted: #64748b;
}

/* Animasi Fade In Up */
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

/* Animasi Fade In */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Animasi Slide In Left */
@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Animasi Scale In */
@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Animasi Pulse */
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Animasi Float */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

/* Animasi Gradient */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Staggered Animation Classes */
.anim-fade-in-up {
    animation: fadeInUp 0.5s ease-out forwards;
    opacity: 0;
}

.anim-fade-in {
    animation: fadeIn 0.4s ease-out forwards;
    opacity: 0;
}

.anim-slide-in-left {
    animation: slideInLeft 0.5s ease-out forwards;
    opacity: 0;
}

.anim-scale-in {
    animation: scaleIn 0.4s ease-out forwards;
    opacity: 0;
}

.anim-float {
    animation: float 3s ease-in-out infinite;
}

/* Delay Classes */
.delay-100 { animation-delay: 100ms; }
.delay-200 { animation-delay: 200ms; }
.delay-300 { animation-delay: 300ms; }
.delay-400 { animation-delay: 400ms; }
.delay-500 { animation-delay: 500ms; }
.delay-600 { animation-delay: 600ms; }

/* ============================================
   CARD STYLES
   ============================================ */

.ot-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    overflow: hidden;
}

.ot-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px var(--ot-primary-glow);
    border-color: var(--ot-primary-light);
}

.ot-card-hero {
    background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%);
    color: #fff;
    border: none;
    position: relative;
    overflow: hidden;
}

.ot-card-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
}

.ot-card-hero:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(139, 92, 246, 0.4);
}

.ot-stat-card {
    text-align: center;
    padding: 1.5rem;
}

.ot-stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.ot-stat-icon-primary {
    background: var(--ot-primary-glow);
    color: var(--ot-primary);
}

.ot-stat-icon-warning {
    background: rgba(245, 158, 11, 0.15);
    color: var(--ot-warning);
}

.ot-stat-icon-success {
    background: rgba(16, 185, 129, 0.15);
    color: var(--ot-success);
}

.ot-stat-number {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.2;
}

.ot-stat-label {
    font-size: 0.875rem;
    color: var(--ot-text-muted);
    margin-top: 0.25rem;
}

/* ============================================
   BADGE STYLES
   ============================================ */

.ot-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    gap: 0.35rem;
}

.ot-badge-pending {
    background: rgba(245, 158, 11, 0.15);
    color: #b45309;
}

.ot-badge-verified {
    background: rgba(16, 185, 129, 0.15);
    color: #047857;
}

.ot-badge-rejected {
    background: rgba(239, 68, 68, 0.15);
    color: #dc2626;
}

/* ============================================
   BUTTON STYLES
   ============================================ */

.ot-btn-primary {
    background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%);
    color: #fff;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.ot-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px var(--ot-primary-glow);
    color: #fff;
}

.ot-btn-secondary {
    background: transparent;
    color: var(--ot-primary);
    border: 2px solid var(--ot-primary);
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.ot-btn-secondary:hover {
    background: var(--ot-primary);
    color: #fff;
}

/* ============================================
   E-BOOK CARD
   ============================================ */

.ebook-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
}

.ebook-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(139, 92, 246, 0.2);
}

.ebook-cover {
    width: 100%;
    height: 180px;
    object-fit: cover;
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
}

.ebook-placeholder {
    width: 100%;
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    color: var(--ot-text-muted);
    font-size: 3rem;
}

/* ============================================
   LOGIN PAGE
   ============================================ */

.ot-login-bg {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.08) 0%, rgba(167, 139, 250, 0.05) 50%, #f6f8fb 100%);
    min-height: 100vh;
}

.ot-login-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 25px 50px -12px rgba(139, 92, 246, 0.15);
    border: 1px solid rgba(139, 92, 246, 0.1);
}

.ot-login-input {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.ot-login-input:focus {
    border-color: var(--ot-primary);
    box-shadow: 0 0 0 4px var(--ot-primary-glow);
    outline: none;
}

.ot-login-btn {
    background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%);
    color: #fff;
    border: none;
    padding: 0.875rem 1.5rem;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.3s ease;
    width: 100%;
}

.ot-login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px var(--ot-primary-glow);
    color: #fff;
}

/* ============================================
   TOPBAR ORANG TUA
   ============================================ */

.ot-topbar {
    background: #fff;
    border-bottom: 1px solid #e2e8f0;
    padding: 0.75rem 1.5rem;
}

.ot-topbar-brand {
    font-weight: 700;
    color: var(--ot-primary);
    font-size: 1.125rem;
}

/* ============================================
   LIST ITEM
   ============================================ */

.ot-list-item {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
}

.ot-list-item:hover {
    border-color: var(--ot-primary-light);
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.1);
}

/* ============================================
   RESPONSIVE
   ============================================ */

@media (max-width: 768px) {
    .ot-stat-number {
        font-size: 1.5rem;
    }

    .ot-card-hero {
        padding: 1.5rem;
    }

    .ebook-cover, .ebook-placeholder {
        height: 140px;
    }
}
```

---

### Task 12: Buat View Login Orang Tua (Tema Ungu)

**Files:**
- Create: `app/Views/orangtua/auth/login.php`

- [ ] **Step 1: Buat view login dengan animasi**

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Orang Tua - RA Perwanida</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/main.css?v=20260523a') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/orangtua-custom.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        }
    </style>
</head>
<body class="ot-login-bg">
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center py-5">
            <div class="col-12 col-sm-10 col-md-6 col-lg-5">

                <!-- Login Card -->
                <div class="ot-login-card p-4 p-sm-5 anim-fade-in-up">

                    <!-- Logo & Brand -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center gap-3 mb-4">
                            <img src="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>"
                                 alt="Logo RA Perwanida"
                                 width="50"
                                 height="50">
                            <div class="text-start">
                                <span class="fw-bold d-block" style="color: #1e293b; font-size: 1.1rem;">RA PERWANIDA</span>
                                <small class="text-muted">TK PERWANIDA</small>
                            </div>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-4 text-center anim-fade-in-up delay-100">
                        <h1 class="h4 fw-bold mb-1" style="color: var(--ot-primary);">Login Orang Tua</h1>
                        <p class="text-muted mb-0 small">Masuk untuk melihat tagihan dan e-book anak</p>
                    </div>

                    <!-- Alert -->
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show anim-fade-in" role="alert">
                            <i class="ti ti-alert-circle me-2"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form action="<?= base_url('orangtua/login') ?>" method="post" class="anim-fade-in-up delay-200">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-muted">
                                <i class="ti ti-mail me-1"></i> Email
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control ot-login-input"
                                   placeholder="nama@email.com"
                                   value="<?= old('email') ?>"
                                   required
                                   autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold small text-muted">
                                <i class="ti ti-lock me-1"></i> Password
                            </label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control ot-login-input"
                                   placeholder="Masukkan password"
                                   required>
                        </div>

                        <button type="submit" class="ot-login-btn">
                            <i class="ti ti-login me-2"></i>
                            Masuk
                        </button>
                    </form>

                    <!-- Footer -->
                    <div class="text-center mt-4 pt-3 border-top anim-fade-in delay-300">
                        <a href="<?= base_url('/') ?>" class="text-decoration-none small text-muted">
                            <i class="ti ti-home me-1"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div class="position-fixed bottom-0 start-0 p-3 opacity-25 anim-float">
                    <i class="ti ti-book" style="font-size: 4rem; color: var(--ot-primary);"></i>
                </div>
                <div class="position-fixed top-0 end-0 p-3 opacity-25 anim-float" style="animation-delay: 1s;">
                    <i class="ti ti-school" style="font-size: 4rem; color: var(--ot-primary);"></i>
                </div>

            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/dashboard/js/main.js') ?>"></script>
</body>
</html>
```

---

### Task 13: Buat View Dashboard Orang Tua (Animasi)

**Files:**
- Create: `app/Views/orangtua/dashboard.php`

- [ ] **Step 1: Buat dashboard dengan card animasi**

```php
<?php
$namaOrtu = session()->get('orangtua_nama') ?? 'Orang Tua';
$namaSiswa = session()->get('orangtua_nama_siswa') ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - RA Perwanida</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/main.css?v=20260523a') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/orangtua-custom.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body>

    <!-- Topbar -->
    <nav class="ot-topbar fixed-top shadow-sm">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>"
                         alt="Logo" width="36" height="36">
                    <span class="ot-topbar-brand">RA Perwanida</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-sm-block">
                        <span class="fw-semibold d-block" style="color: #1e293b;"><?= esc($namaOrtu) ?></span>
                        <small class="text-muted">Orang Tua</small>
                    </div>
                    <a href="<?= base_url('orangtua/logout') ?>"
                       class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                        <i class="ti ti-logout"></i>
                        <span class="d-none d-sm-inline">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-5 mt-3">
        <div class="container-fluid py-4">

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show anim-fade-in" role="alert">
                    <i class="ti ti-check-circle me-2"></i>
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show anim-fade-in" role="alert">
                    <i class="ti ti-alert-circle me-2"></i>
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Welcome Section -->
            <div class="mb-4 anim-fade-in-up">
                <h4 class="fw-bold mb-1">
                    <i class="ti ti-user me-2" style="color: var(--ot-primary);"></i>
                    Selamat datang, <?= esc($namaOrtu) ?>!
                </h4>
                <?php if ($namaSiswa) : ?>
                    <p class="text-muted mb-0">
                        <i class="ti ti-heart me-1"></i>
                        Orang tua dari <strong><?= esc($namaSiswa) ?></strong>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Hero Card - Tagihan Aktif -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="ot-card ot-card-hero p-4 p-md-5 anim-fade-in-up delay-100">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <i class="ti ti-receipt" style="font-size: 2.5rem; opacity: 0.9;"></i>
                                    <div>
                                        <h3 class="mb-0 fw-bold">Tagihan Aktif</h3>
                                        <p class="mb-0 opacity-75">
                                            <?= ($stats['pending_count'] ?? 0) ?> tagihan menunggu pembayaran
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="mb-2">
                                    <small class="opacity-75">Total Tagihan</small>
                                    <h2 class="mb-0 fw-bold">
                                        Rp <?= number_format($stats['pending'] ?? 0, 0, ',', '.') ?>
                                    </h2>
                                </div>
                                <a href="<?= base_url('orangtua/pembayaran') ?>" class="ot-btn-primary d-inline-flex align-items-center gap-2">
                                    <i class="ti ti-credit-card"></i>
                                    Bayar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-6 col-lg-3 mb-3">
                    <div class="ot-card ot-stat-card anim-fade-in-up delay-200">
                        <div class="ot-stat-icon ot-stat-icon-primary">
                            <i class="ti ti-file-invoice"></i>
                        </div>
                        <div class="ot-stat-number" style="color: var(--ot-primary);">
                            <?= ($stats['pending_count'] ?? 0) + ($stats['lunas_count'] ?? 0) ?>
                        </div>
                        <div class="ot-stat-label">Total Tagihan</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-3">
                    <div class="ot-card ot-stat-card anim-fade-in-up delay-300">
                        <div class="ot-stat-icon ot-stat-icon-warning">
                            <i class="ti ti-clock"></i>
                        </div>
                        <div class="ot-stat-number" style="color: var(--ot-warning);">
                            <?= $stats['pending_count'] ?? 0 ?>
                        </div>
                        <div class="ot-stat-label">Menunggu</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-3">
                    <div class="ot-card ot-stat-card anim-fade-in-up delay-400">
                        <div class="ot-stat-icon ot-stat-icon-success">
                            <i class="ti ti-check"></i>
                        </div>
                        <div class="ot-stat-number" style="color: var(--ot-success);">
                            <?= $stats['lunas_count'] ?? 0 ?>
                        </div>
                        <div class="ot-stat-label">Lunas</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-3">
                    <div class="ot-card ot-stat-card anim-fade-in-up delay-500">
                        <div class="ot-stat-icon" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6;">
                            <i class="ti ti-wallet"></i>
                        </div>
                        <div class="ot-stat-number" style="color: #8b5cf6; font-size: 1.25rem;">
                            Rp <?= number_format($stats['total'] ?? 0, 0, ',', '.') ?>
                        </div>
                        <div class="ot-stat-label">Total</div>
                    </div>
                </div>
            </div>

            <!-- Tagihan Terbaru -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="ot-card p-4 anim-fade-in-up delay-300">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="fw-bold mb-0">
                                <i class="ti ti-list me-2" style="color: var(--ot-primary);"></i>
                                Tagihan Terbaru
                            </h5>
                            <a href="<?= base_url('orangtua/pembayaran') ?>" class="ot-btn-secondary btn-sm">
                                Lihat Semua
                            </a>
                        </div>

                        <?php if (empty($tagihan_terbaru)) : ?>
                            <div class="text-center py-5">
                                <i class="ti ti-check-circle" style="font-size: 4rem; color: var(--ot-success);"></i>
                                <h5 class="mt-3 mb-1">Semua Lunas!</h5>
                                <p class="text-muted mb-0">Tidak ada tagihan yang menunggu.</p>
                            </div>
                        <?php else : ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($tagihan_terbaru as $tagihan) : ?>
                                    <div class="list-group-item px-0 py-3 border-0 border-bottom">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width: 48px; height: 48px; background: <?= $tagihan['status'] === 'verified'
                                                         ? 'rgba(16, 185, 129, 0.1)'
                                                         : ($tagihan['status'] === 'rejected'
                                                             ? 'rgba(239, 68, 68, 0.1)'
                                                             : 'rgba(245, 158, 11, 0.1)'); ?>">
                                                    <i class="ti <?= $tagihan['status'] === 'verified'
                                                        ? 'ti-check'
                                                        : ($tagihan['status'] === 'rejected'
                                                            ? 'ti-x'
                                                            : 'ti-clock'); ?>"
                                                       style="color: <?= $tagihan['status'] === 'verified'
                                                           ? 'var(--ot-success)'
                                                           : ($tagihan['status'] === 'rejected'
                                                               ? 'var(--ot-danger)'
                                                               : 'var(--ot-warning)'); ?>;"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold"><?= esc($tagihan['judul']) ?></h6>
                                                    <small class="text-muted">
                                                        <?= $tagihan['batas_bayar']
                                                            ? 'Batas: ' . date('d M Y', strtotime($tagihan['batas_bayar']))
                                                            : 'Tidak ada batas waktu'; ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <div class="fw-bold mb-1">
                                                    Rp <?= number_format($tagihan['nominal'], 0, ',', '.') ?>
                                                </div>
                                                <span class="ot-badge <?= $tagihan['status'] === 'verified'
                                                    ? 'ot-badge-verified'
                                                    : ($tagihan['status'] === 'rejected'
                                                        ? 'ot-badge-rejected'
                                                        : 'ot-badge-pending'); ?>">
                                                    <?= $tagihan['status'] === 'verified'
                                                        ? '<i class="ti ti-check"></i> Lunas'
                                                        : ($tagihan['status'] === 'rejected'
                                                            ? '<i class="ti ti-x"></i> Ditolak'
                                                            : '<i class="ti ti-clock"></i> Menunggu'); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- E-Book Section -->
            <div class="row">
                <div class="col-12">
                    <div class="ot-card p-4 anim-fade-in-up delay-400">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="fw-bold mb-0">
                                <i class="ti ti-book me-2" style="color: var(--ot-primary);"></i>
                                E-Book Terbaru
                            </h5>
                            <a href="<?= base_url('ebook') ?>" class="ot-btn-secondary btn-sm">
                                Lihat Semua
                            </a>
                        </div>

                        <?php if (empty($ebooks)) : ?>
                            <div class="text-center py-5">
                                <i class="ti ti-book-off" style="font-size: 4rem; color: var(--ot-text-muted);"></i>
                                <h5 class="mt-3 mb-1">Belum Ada E-Book</h5>
                                <p class="text-muted mb-0">E-book akan segera tersedia.</p>
                            </div>
                        <?php else : ?>
                            <div class="row g-3">
                                <?php foreach ($ebooks as $index => $ebook) : ?>
                                    <div class="col-6 col-md-3 anim-slide-in-left" style="animation-delay: <?= $index * 100 + 400 ?>ms;">
                                        <div class="ebook-card h-100">
                                            <?php if ($ebook['cover']) : ?>
                                                <img src="<?= base_url('writable/uploads/ebook/cover/' . $ebook['cover']) ?>"
                                                     alt="<?= esc($ebook['judul']) ?>"
                                                     class="ebook-cover">
                                            <?php else : ?>
                                                <div class="ebook-placeholder">
                                                    <i class="ti ti-book"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="p-3">
                                                <h6 class="mb-1 fw-semibold" style="font-size: 0.9rem;">
                                                    <?= esc($ebook['judul']) ?>
                                                </h6>
                                                <?php if ($ebook['penulis']) : ?>
                                                    <p class="mb-1 text-muted small"><?= esc($ebook['penulis']) ?></p>
                                                <?php endif; ?>
                                                <?php if ($ebook['kategori']) : ?>
                                                    <span class="badge bg-light text-dark"><?= esc($ebook['kategori']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5 text-muted">
        <p class="mb-0 small">Copyright &copy; 2026 RA Perwanida</p>
    </footer>

    <script src="<?= base_url('assets/dashboard/js/main.js') ?>"></script>
</body>
</html>
```

---

### Task 14: Buat View Pembayaran Index

**Files:**
- Create: `app/Views/orangtua/pembayaran/index.php`

- [ ] **Step 1: Buat view list tagihan**

```php
<?php
$namaOrtu = session()->get('orangtua_nama') ?? 'Orang Tua';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - RA Perwanida</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/main.css?v=20260523a') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/orangtua-custom.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }</style>
</head>
<body>
    <!-- Topbar -->
    <nav class="ot-topbar fixed-top shadow-sm">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <a href="<?= base_url('orangtua/dashboard') ?>" class="btn btn-light btn-sm">
                        <i class="ti ti-arrow-left"></i>
                    </a>
                    <img src="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>" alt="Logo" width="36" height="36">
                    <span class="ot-topbar-brand">RA Perwanida</span>
                </div>
                <a href="<?= base_url('orangtua/logout') ?>" class="btn btn-sm btn-outline-danger">
                    <i class="ti ti-logout"></i>
                </a>
            </div>
        </div>
    </nav>

    <main class="pt-5 mt-3">
        <div class="container-fluid py-4">
            <!-- Header -->
            <div class="mb-4 anim-fade-in-up">
                <h4 class="fw-bold mb-1">
                    <i class="ti ti-credit-card me-2" style="color: var(--ot-primary);"></i>
                    Pembayaran
                </h4>
                <p class="text-muted mb-0">Daftar tagihan dan riwayat pembayaran</p>
            </div>

            <!-- Filter -->
            <div class="ot-card p-3 mb-4 anim-fade-in-up delay-100">
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= base_url('orangtua/pembayaran') ?>"
                       class="btn <?= !$filter_status ? 'ot-btn-primary' : 'btn-light'; ?> btn-sm">
                        Semua
                    </a>
                    <a href="<?= base_url('orangtua/pembayaran?status=pending') ?>"
                       class="btn <?= $filter_status === 'pending' ? 'ot-btn-primary' : 'btn-light'; ?> btn-sm">
                        <i class="ti ti-clock me-1"></i> Menunggu
                    </a>
                    <a href="<?= base_url('orangtua/pembayaran?status=verified') ?>"
                       class="btn <?= $filter_status === 'verified' ? 'ot-btn-primary' : 'btn-light'; ?> btn-sm">
                        <i class="ti ti-check me-1"></i> Lunas
                    </a>
                </div>
            </div>

            <!-- Alert -->
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show anim-fade-in" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Tagihan List -->
            <?php if (empty($tagihan)) : ?>
                <div class="ot-card p-5 text-center anim-fade-in-up delay-200">
                    <i class="ti ti-check-circle" style="font-size: 4rem; color: var(--ot-success);"></i>
                    <h5 class="mt-3 mb-2">Tidak Ada Tagihan</h5>
                    <p class="text-muted">Belum ada tagihan dengan status ini.</p>
                </div>
            <?php else : ?>
                <div class="anim-fade-in-up delay-200">
                    <?php foreach ($tagihan as $t) : ?>
                        <div class="ot-list-item">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6 mb-2 mb-md-0">
                                    <h6 class="fw-bold mb-1"><?= esc($t['judul']) ?></h6>
                                    <div class="d-flex flex-wrap gap-2 small">
                                        <?php if ($t['batas_bayar']) : ?>
                                            <span class="text-muted">
                                                <i class="ti ti-calendar me-1"></i>
                                                <?= date('d M Y', strtotime($t['batas_bayar'])) ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($t['keterangan']) : ?>
                                            <span class="text-muted">
                                                <i class="ti ti-info-circle me-1"></i>
                                                <?= esc($t['keterangan']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 text-md-end mb-2 mb-md-0">
                                    <div class="fw-bold" style="font-size: 1.1rem;">
                                        Rp <?= number_format($t['nominal'], 0, ',', '.') ?>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 text-md-end">
                                    <?php $statusClass = $t['status'] === 'verified'
                                        ? 'ot-badge-verified'
                                        : ($t['status'] === 'rejected' ? 'ot-badge-rejected' : 'ot-badge-pending'); ?>
                                    <?php $statusIcon = $t['status'] === 'verified'
                                        ? 'ti-check'
                                        : ($t['status'] === 'rejected' ? 'ti-x' : 'ti-clock'); ?>
                                    <?php $statusLabel = $t['status'] === 'verified'
                                        ? 'Lunas'
                                        : ($t['status'] === 'rejected' ? 'Ditolak' : 'Menunggu'); ?>
                                    <span class="ot-badge <?= $statusClass ?> mb-2">
                                        <i class="ti <?= $statusIcon ?>"></i>
                                        <?= $statusLabel ?>
                                    </span>
                                    <a href="<?= base_url('orangtua/pembayaran/' . $t['id']) ?>"
                                       class="btn btn-sm btn-outline-primary d-block">
                                        <i class="ti ti-eye me-1"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script src="<?= base_url('assets/dashboard/js/main.js') ?>"></script>
</body>
</html>
```

---

### Task 15: Buat View Pembayaran Detail

**Files:**
- Create: `app/Views/orangtua/pembayaran/detail.php`

- [ ] **Step 1: Buat view detail + upload bukti**

```php
<?php $t = $tagihan; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Tagihan - RA Perwanida</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/main.css?v=20260523a') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/orangtua-custom.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }</style>
</head>
<body>
    <nav class="ot-topbar fixed-top shadow-sm">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <a href="<?= base_url('orangtua/pembayaran') ?>" class="btn btn-light btn-sm">
                        <i class="ti ti-arrow-left"></i>
                    </a>
                    <img src="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>" alt="Logo" width="36" height="36">
                    <span class="ot-topbar-brand">RA Perwanida</span>
                </div>
                <a href="<?= base_url('orangtua/logout') ?>" class="btn btn-sm btn-outline-danger">
                    <i class="ti ti-logout"></i>
                </a>
            </div>
        </div>
    </nav>

    <main class="pt-5 mt-3">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">

                    <!-- Alert -->
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show anim-fade-in" role="alert">
                            <?= esc(session()->getFlashdata('success')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show anim-fade-in" role="alert">
                            <?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Detail Card -->
                    <div class="ot-card p-4 mb-4 anim-fade-in-up">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div>
                                <h4 class="fw-bold mb-1"><?= esc($t['judul']) ?></h4>
                                <?php $statusClass = $t['status'] === 'verified'
                                    ? 'ot-badge-verified'
                                    : ($t['status'] === 'rejected' ? 'ot-badge-rejected' : 'ot-badge-pending'); ?>
                                <?php $statusLabel = $t['status'] === 'verified'
                                    ? 'Lunas'
                                    : ($t['status'] === 'rejected' ? 'Ditolak' : 'Menunggu'); ?>
                                <span class="ot-badge <?= $statusClass ?>">
                                    <?= $statusLabel ?>
                                </span>
                            </div>
                            <div class="text-end">
                                <div class="small text-muted">Total Tagihan</div>
                                <h3 class="fw-bold mb-0" style="color: var(--ot-primary);">
                                    Rp <?= number_format($t['nominal'], 0, ',', '.') ?>
                                </h3>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <?php if ($t['batas_bayar']) : ?>
                                <div class="col-6 col-md-4">
                                    <div class="p-3 rounded" style="background: var(--ot-secondary);">
                                        <small class="text-muted d-block mb-1">Batas Pembayaran</small>
                                        <span class="fw-semibold">
                                            <?= date('d M Y', strtotime($t['batas_bayar'])) ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($t['tanggal_bayar']) : ?>
                                <div class="col-6 col-md-4">
                                    <div class="p-3 rounded" style="background: var(--ot-secondary);">
                                        <small class="text-muted d-block mb-1">Tanggal Bayar</small>
                                        <span class="fw-semibold">
                                            <?= date('d M Y', strtotime($t['tanggal_bayar'])) ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($t['keterangan']) : ?>
                                <div class="col-12 col-md-4">
                                    <div class="p-3 rounded" style="background: var(--ot-secondary);">
                                        <small class="text-muted d-block mb-1">Keterangan</small>
                                        <span class="fw-semibold"><?= esc($t['keterangan']) ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($t['status'] === 'rejected' && $t['catatan_admin']) : ?>
                            <div class="alert alert-danger mb-4">
                                <i class="ti ti-alert-circle me-2"></i>
                                <strong>Catatan Admin:</strong> <?= esc($t['catatan_admin']) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($t['bukti_bayar']) : ?>
                            <div class="alert alert-info mb-4">
                                <i class="ti ti-file-check me-2"></i>
                                <strong>Bukti bayar sudah diupload.</strong>
                                Silakan tunggu verifikasi dari admin.
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Bukti Bayar -->
                    <?php if ($t['status'] !== 'verified') : ?>
                        <div class="ot-card p-4 anim-fade-in-up delay-200">
                            <h5 class="fw-bold mb-3">
                                <i class="ti ti-upload me-2" style="color: var(--ot-primary);"></i>
                                Upload Bukti Pembayaran
                            </h5>
                            <form action="<?= base_url('orangtua/pembayaran/upload/' . $t['id']) ?>"
                                  method="post"
                                  enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label for="bukti_bayar" class="form-label">
                                        Pilih file bukti transfer
                                    </label>
                                    <input type="file"
                                           id="bukti_bayar"
                                           name="bukti_bayar"
                                           class="form-control ot-login-input"
                                           accept=".jpg,.jpeg,.png,.pdf"
                                           required>
                                    <div class="form-text">
                                        Format: JPG, PNG, atau PDF. Maksimal 5MB.
                                    </div>
                                </div>
                                <button type="submit" class="ot-btn-primary">
                                    <i class="ti ti-upload me-2"></i>
                                    Kirim Bukti Pembayaran
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </main>

    <script src="<?= base_url('assets/dashboard/js/main.js') ?>"></script>
</body>
</html>
```

---

## PHASE 5: Views - Admin & Public E-Book

### Task 16: Buat View Admin Verifikasi Pembayaran

**Files:**
- Create: `app/Views/admin/pembayaran/index.php`
- Create: `app/Views/admin/pembayaran/verifikasi.php`

- [ ] **Step 1: Buat index.php**

```php
<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-credit-card me-2"></i>
            Verifikasi Pembayaran
        </h4>
        <p class="text-muted mb-0">Kelola dan verifikasi pembayaran dari orang tua</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($pembayaran)) : ?>
            <div class="text-center py-5">
                <i class="ti ti-inbox" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h5 class="mt-3 mb-1">Belum Ada Pembayaran</h5>
                <p class="text-muted">Belum ada pembayaran yang perlu diverifikasi.</p>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Orang Tua</th>
                            <th>Siswa</th>
                            <th>Tagihan</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Tanggal Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pembayaran as $p) : ?>
                            <tr>
                                <td>
                                    <strong><?= esc($p['nama_ortu']) ?></strong>
                                </td>
                                <td><?= esc($p['nama_siswa'] ?? '-') ?></td>
                                <td><?= esc($p['judul']) ?></td>
                                <td>
                                    <strong>Rp <?= number_format($p['nominal'], 0, ',', '.') ?></strong>
                                </td>
                                <td>
                                    <?php
                                    $badgeClass = $p['status'] === 'verified'
                                        ? 'bg-success'
                                        : ($p['status'] === 'rejected' ? 'bg-danger' : 'bg-warning text-dark');
                                    $label = $p['status'] === 'verified'
                                        ? 'Lunas'
                                        : ($p['status'] === 'rejected' ? 'Ditolak' : 'Pending');
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= $label ?></span>
                                </td>
                                <td>
                                    <?= $p['tanggal_bayar']
                                        ? date('d M Y', strtotime($p['tanggal_bayar']))
                                        : '-'; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/verifikasi-pembayaran/' . $p['id']) ?>"
                                       class="btn btn-sm btn-primary">
                                        <i class="ti ti-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
```

- [ ] **Step 2: Buat verifikasi.php**

```php
<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= base_url('admin/verifikasi-pembayaran') ?>" class="btn btn-light mb-3">
        <i class="ti ti-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Detail Pembayaran -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0">
                    <i class="ti ti-receipt me-2"></i>
                    Detail Pembayaran
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Orang Tua</label>
                        <p class="fw-semibold mb-0"><?= esc($pembayaran['nama_ortu']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Siswa</label>
                        <p class="fw-semibold mb-0"><?= esc($pembayaran['nama_siswa'] ?? '-') ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Tagihan</label>
                        <p class="fw-semibold mb-0"><?= esc($pembayaran['judul']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Nominal</label>
                        <p class="fw-bold mb-0 text-primary">
                            Rp <?= number_format($pembayaran['nominal'], 0, ',', '.') ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">No. HP</label>
                        <p class="mb-0"><?= esc($pembayaran['no_hp'] ?? '-') ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Tanggal Bayar</label>
                        <p class="mb-0">
                            <?= $pembayaran['tanggal_bayar']
                                ? date('d M Y', strtotime($pembayaran['tanggal_bayar']))
                                : '-'; ?>
                        </p>
                    </div>
                    <?php if ($pembayaran['keterangan']) : ?>
                        <div class="col-12">
                            <label class="text-muted small">Keterangan</label>
                            <p class="mb-0"><?= esc($pembayaran['keterangan']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Form Verifikasi -->
        <?php if ($pembayaran['status'] === 'pending') : ?>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        <i class="ti ti-settings me-2"></i>
                        Proses Verifikasi
                    </h5>
                </div>
                <div class="card-body">
                    <?= form_open(base_url('admin/verifikasi-pembayaran/proses/' . $pembayaran['id'])) ?>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="verified">Verifikasi (Lunas)</option>
                            <option value="rejected">Tolak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3"
                                  placeholder="Masukkan catatan jika diperlukan"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-check me-2"></i> Simpan
                        </button>
                        <a href="<?= base_url('admin/verifikasi-pembayaran') ?>"
                           class="btn btn-light">
                            Batal
                        </a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        <?php else : ?>
            <div class="alert <?= $pembayaran['status'] === 'verified' ? 'alert-success' : 'alert-danger' ?>">
                <i class="ti <?= $pembayaran['status'] === 'verified' ? 'ti-check-circle' : 'ti-x-circle' ?> me-2"></i>
                Pembayaran ini sudah <?= $pembayaran['status'] === 'verified' ? 'diverifikasi' : 'ditolak' ?>.
                <?php if ($pembayaran['catatan_admin']) : ?>
                    <br><strong>Catatan:</strong> <?= esc($pembayaran['catatan_admin']) ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <!-- Bukti Bayar -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0">
                    <i class="ti ti-file me-2"></i>
                    Bukti Bayar
                </h5>
            </div>
            <div class="card-body">
                <?php if ($pembayaran['bukti_bayar']) : ?>
                    <?php $ext = strtolower(pathinfo($pembayaran['bukti_bayar'], PATHINFO_EXTENSION)); ?>
                    <?php if (in_array($ext, ['jpg', 'jpeg', 'png'])) : ?>
                        <a href="<?= base_url('writable/uploads/bukti_bayar/' . $pembayaran['bukti_bayar']) ?>"
                           target="_blank">
                            <img src="<?= base_url('writable/uploads/bukti_bayar/' . $pembayaran['bukti_bayar']) ?>"
                                 alt="Bukti Bayar"
                                 class="img-fluid rounded">
                        </a>
                    <?php else : ?>
                        <a href="<?= base_url('writable/uploads/bukti_bayar/' . $pembayaran['bukti_bayar']) ?>"
                           class="btn btn-outline-primary" target="_blank">
                            <i class="ti ti-file-pdf me-2"></i> Lihat PDF
                        </a>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="text-center text-muted py-4">
                        <i class="ti ti-file-off" style="font-size: 3rem;"></i>
                        <p class="mt-2 mb-0">Belum ada bukti bayar</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
```

---

### Task 17: Buat View Admin E-Book

**Files:**
- Create: `app/Views/admin/ebook/index.php`
- Create: `app/Views/admin/ebook/create.php`
- Create: `app/Views/admin/ebook/edit.php`

- [ ] **Step 1: Buat index.php**

```php
<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-book me-2"></i>
            Manajemen E-Book
        </h4>
        <p class="text-muted mb-0">Kelola koleksi e-book untuk siswa</p>
    </div>
    <a href="<?= base_url('admin/ebook/tambah') ?>" class="btn btn-primary">
        <i class="ti ti-plus me-2"></i> Tambah E-Book
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($ebooks)) : ?>
            <div class="text-center py-5">
                <i class="ti ti-book-off" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h5 class="mt-3 mb-1">Belum Ada E-Book</h5>
                <p class="text-muted">Tambahkan e-book pertama Anda.</p>
                <a href="<?= base_url('admin/ebook/tambah') ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-2"></i> Tambah E-Book
                </a>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">Cover</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Kelas</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ebooks as $e) : ?>
                            <tr>
                                <td>
                                    <?php if ($e['cover']) : ?>
                                        <img src="<?= base_url('writable/uploads/ebook/cover/' . $e['cover']) ?>"
                                             alt="<?= esc($e['judul']) ?>"
                                             class="rounded"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else : ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width: 50px; height: 50px;">
                                            <i class="ti ti-book text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= esc($e['judul']) ?></strong>
                                </td>
                                <td><?= esc($e['penulis'] ?? '-') ?></td>
                                <td>
                                    <?= $e['kategori']
                                        ? '<span class="badge bg-secondary">' . esc($e['kategori']) . '</span>'
                                        : '-'; ?>
                                </td>
                                <td><?= esc($e['kelas'] ?? '-') ?></td>
                                <td>
                                    <a href="<?= base_url('admin/ebook/edit/' . $e['id']) ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/ebook/hapus/' . $e['id']) ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Yakin hapus e-book ini?')">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
```

- [ ] **Step 2: Buat create.php**

```php
<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= base_url('admin/ebook') ?>" class="btn btn-light mb-3">
        <i class="ti ti-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="fw-bold mb-0">
            <i class="ti ti-plus me-2"></i>
            Tambah E-Book Baru
        </h5>
    </div>
    <div class="card-body">
        <?= form_open_multipart(base_url('admin/ebook/simpan')) ?>
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Judul *</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="Matematika">Matematika</option>
                                <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                                <option value="Bahasa Inggris">Bahasa Inggris</option>
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                                <option value="Seni">Seni</option>
                                <option value="Olahraga">Olahraga</option>
                                <option value="Agama">Agama</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas Target</label>
                    <input type="text" name="kelas" class="form-control"
                           placeholder="Contoh: TK A, TK B">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">File PDF *</label>
                    <input type="file" name="file_pdf" class="form-control"
                           accept=".pdf" required>
                    <div class="form-text">Maksimal 10MB</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cover (opsional)</label>
                    <input type="file" name="cover" class="form-control"
                           accept=".jpg,.jpeg,.png">
                    <div class="form-text">JPG/PNG, maksimal 2MB</div>
                </div>
            </div>
        </div>

        <hr>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-device-floppy me-2"></i> Simpan
            </button>
            <a href="<?= base_url('admin/ebook') ?>" class="btn btn-light">Batal</a>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection() ?>
```

- [ ] **Step 3: Buat edit.php**

```php
<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= base_url('admin/ebook') ?>" class="btn btn-light mb-3">
        <i class="ti ti-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="fw-bold mb-0">
            <i class="ti ti-edit me-2"></i>
            Edit E-Book
        </h5>
    </div>
    <div class="card-body">
        <?= form_open_multipart(base_url('admin/ebook/update/' . $ebook['id'])) ?>
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Judul *</label>
                    <input type="text" name="judul" class="form-control"
                           value="<?= esc($ebook['judul']) ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control"
                                   value="<?= esc($ebook['penulis'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">-- Pilih --</option>
                                <?php $kategoriOptions = ['Matematika','Bahasa Indonesia','Bahasa Inggris','IPA','IPS','Seni','Olahraga','Agama','Lainnya']; ?>
                                <?php foreach ($kategoriOptions as $opt) : ?>
                                    <option value="<?= $opt ?>" <?= $ebook['kategori'] === $opt ? 'selected' : '' ?>>
                                        <?= $opt ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas Target</label>
                    <input type="text" name="kelas" class="form-control"
                           value="<?= esc($ebook['kelas'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"><?= esc($ebook['deskripsi'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">File PDF Baru (opsional)</label>
                    <input type="file" name="file_pdf" class="form-control" accept=".pdf">
                    <div class="form-text">Kosongkan jika tidak ganti</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cover Baru (opsional)</label>
                    <input type="file" name="cover" class="form-control" accept=".jpg,.jpeg,.png">
                    <div class="form-text">JPG/PNG, maksimal 2MB</div>
                    <?php if ($ebook['cover']) : ?>
                        <div class="mt-2">
                            <small class="text-muted">Cover saat ini:</small>
                            <img src="<?= base_url('writable/uploads/ebook/cover/' . $ebook['cover']) ?>"
                                 class="rounded mt-1" style="max-height: 100px;">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-device-floppy me-2"></i> Update
            </button>
            <a href="<?= base_url('admin/ebook') ?>" class="btn btn-light">Batal</a>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection() ?>
```

---

### Task 18: Buat View Public E-Book

**Files:**
- Create: `app/Views/public_ebook/index.php`

- [ ] **Step 1: Buat view galeri e-book**

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Book - RA Perwanida</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/main.css?v=20260523a') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/orangtua-custom.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
    </style>
</head>
<body class="bg-light">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('/') ?>">
                <img src="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>" alt="Logo" width="36" height="36">
                <span>RA Perwanida</span>
            </a>
            <?php if (session()->get('orangtua_logged_in')) : ?>
                <a href="<?= base_url('orangtua/dashboard') ?>" class="btn btn-light btn-sm">
                    <i class="ti ti-dashboard me-1"></i> Dashboard
                </a>
            <?php else : ?>
                <a href="<?= base_url('orangtua/login') ?>" class="btn btn-outline-light btn-sm">
                    <i class="ti ti-login me-1"></i> Login
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Content -->
    <main class="py-5">
        <div class="container">
            <!-- Header -->
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2" style="color: var(--ot-primary);">
                    <i class="ti ti-book me-2"></i>
                    Koleksi E-Book
                </h2>
                <p class="text-muted">Kumpulan e-book pembelajaran untuk anak-anak TK</p>
            </div>

            <!-- Filter -->
            <?php if (!empty($kategoris)) : ?>
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                    <a href="<?= base_url('ebook') ?>"
                       class="btn <?= !$filter_kategori ? 'btn-primary' : 'btn-light'; ?> btn-sm">
                        Semua
                    </a>
                    <?php foreach ($kategoris as $k) : ?>
                        <?php if ($k['kategori']) : ?>
                            <a href="<?= base_url('ebook?kategori=' . urlencode($k['kategori'])) ?>"
                               class="btn <?= $filter_kategori === $k['kategori'] ? 'btn-primary' : 'btn-light'; ?> btn-sm">
                                <?= esc($k['kategori']) ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Alert -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- E-Books Grid -->
            <?php if (empty($ebooks)) : ?>
                <div class="card border-0 shadow-sm p-5 text-center">
                    <i class="ti ti-book-off" style="font-size: 4rem; color: #cbd5e1;"></i>
                    <h5 class="mt-3 mb-1">Belum Ada E-Book</h5>
                    <p class="text-muted">E-book akan segera tersedia.</p>
                </div>
            <?php else : ?>
                <div class="row g-4">
                    <?php foreach ($ebooks as $ebook) : ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="ebook-card h-100">
                                <?php if ($ebook['cover']) : ?>
                                    <img src="<?= base_url('writable/uploads/ebook/cover/' . $ebook['cover']) ?>"
                                         alt="<?= esc($ebook['judul']) ?>"
                                         class="ebook-cover">
                                <?php else : ?>
                                    <div class="ebook-placeholder">
                                        <i class="ti ti-book"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="p-3">
                                    <h6 class="mb-1 fw-bold"><?= esc($ebook['judul']) ?></h6>
                                    <?php if ($ebook['penulis']) : ?>
                                        <p class="mb-1 text-muted small"><?= esc($ebook['penulis']) ?></p>
                                    <?php endif; ?>
                                    <?php if ($ebook['kategori']) : ?>
                                        <span class="badge bg-primary mb-2"><?= esc($ebook['kategori']) ?></span>
                                    <?php endif; ?>
                                    <?php if ($ebook['kelas']) : ?>
                                        <div class="small text-muted mb-2">
                                            <i class="ti ti-users me-1"></i> <?= esc($ebook['kelas']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($ebook['deskripsi']) : ?>
                                        <p class="mb-2 small text-muted" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            <?= esc($ebook['deskripsi']) ?>
                                        </p>
                                    <?php endif; ?>
                                    <a href="<?= base_url('ebook/download/' . $ebook['id']) ?>"
                                       class="btn btn-primary btn-sm w-100">
                                        <i class="ti ti-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 text-muted border-top bg-white">
        <p class="mb-0 small">Copyright &copy; 2026 RA Perwanida</p>
    </footer>

    <script src="<?= base_url('assets/dashboard/js/main.js') ?>"></script>
</body>
</html>
```

---

## PHASE 6: Testing

### Task 19: Testing

- [ ] **Step 1: Jalankan migration**

Run: `php spark migrate`

- [ ] **Step 2: Buat data test (opsional - jangan di-commit)**

Insert manual di database untuk testing:
```sql
-- Insert user orang tua test
INSERT INTO spay_orang_tua (nama, email, password, nama_siswa, kelas, is_active, created_at)
VALUES ('Test Orang Tua', 'test@email.com', '$2y$10$...', 'Anak Test', 'TK A', 1, NOW());

-- Insert tagihan test
INSERT INTO spay_tagihan (orang_tua_id, judul, nominal, batas_bayar, created_at)
VALUES (1, 'SPP Juni 2026', 250000, '2026-06-20', NOW());
```

- [ ] **Step 3: Test login orang tua**

Visit: `http://localhost/tk/orangtua/login`

- [ ] **Step 4: Test dashboard dan navigasi**

- [ ] **Step 5: Test upload bukti bayar**

- [ ] **Step 6: Test admin verifikasi pembayaran**

Visit: `http://localhost/tk/admin/verifikasi-pembayaran`

- [ ] **Step 7: Test CRUD e-book admin**

Visit: `http://localhost/tk/admin/ebook`

- [ ] **Step 8: Test galeri e-book public**

Visit: `http://localhost/tk/ebook`

---

## Ringkasan Task

| Phase | Tasks | Keterangan |
|-------|-------|------------|
| 1 | 1-3 | Database migrations, folder upload, config |
| 2 | 4 | Models |
| 3 | 5-10 | Filter dan semua Controllers |
| 4 | 11-15 | CSS custom, Login, Dashboard, Pembayaran views |
| 5 | 16-18 | Admin dan Public E-Book views |
| 6 | 19 | Testing |

**Total: 19 Tasks**

---

**End of Implementation Plan**
