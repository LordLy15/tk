# Feature Implementation Plan: Pembayaran & E-Book
**Project:** Website Sekolah — CodeIgniter 4  
**Scope:** Penambahan fitur baru tanpa mengubah database/fitur yang sudah ada  
**Tanggal:** 2026-06-08

---

## ⚠️ Prinsip Utama

- **TIDAK** mengubah tabel, kolom, atau record database yang sudah ada
- **TIDAK** mengubah controller/model/view yang sudah berjalan
- Semua tabel baru menggunakan prefix `spay_` (pembayaran) dan `sebook_` (e-book)
- Semua route baru di namespace terpisah
- Auth Orang Tua menggunakan session CI4 tersendiri (tidak mengganggu auth admin yang sudah ada)

---

## 1. Struktur Folder Baru

```
app/
├── Controllers/
│   ├── OrangTua/
│   │   ├── AuthController.php        ← Login/logout orang tua
│   │   └── PembayaranController.php  ← Lihat tagihan & upload bukti bayar
│   ├── Admin/
│   │   ├── VerifikasiPembayaranController.php
│   │   └── EbookController.php
│   └── Ebook/
│       └── PublicEbookController.php ← Lihat/download e-book (orang tua & siswa)
├── Models/
│   ├── OrangTuaModel.php
│   ├── PembayaranModel.php
│   └── EbookModel.php
├── Views/
│   ├── orangtua/
│   │   ├── auth/
│   │   │   └── login.php
│   │   ├── dashboard.php
│   │   └── pembayaran/
│   │       ├── index.php             ← Daftar tagihan
│   │       └── detail.php           ← Detail + upload bukti
│   ├── admin/
│   │   ├── pembayaran/
│   │   │   ├── index.php            ← List semua pembayaran
│   │   │   └── verifikasi.php       ← Form verifikasi
│   │   └── ebook/
│   │       ├── index.php
│   │       ├── create.php
│   │       └── edit.php
│   └── public_ebook/
│       └── index.php                ← Galeri e-book
└── Filters/
    └── OrangTuaAuthFilter.php       ← Middleware auth orang tua
```

---

## 2. Database — Tabel Baru

> Jalankan migration berikut. **Tidak menyentuh tabel lama sama sekali.**

### 2.1 `spay_orang_tua`
```sql
CREATE TABLE spay_orang_tua (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nama        VARCHAR(150) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    no_hp       VARCHAR(20),
    nama_siswa  VARCHAR(150),         -- relasi nama saja, bukan FK ke tabel siswa lama
    kelas       VARCHAR(50),
    is_active   TINYINT(1) DEFAULT 1,
    created_at  DATETIME,
    updated_at  DATETIME
);
```

### 2.2 `spay_tagihan`
```sql
CREATE TABLE spay_tagihan (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    orang_tua_id INT NOT NULL,
    judul        VARCHAR(200) NOT NULL,  -- contoh: "SPP Januari 2026"
    nominal      DECIMAL(12,2) NOT NULL,
    batas_bayar  DATE,
    keterangan   TEXT,
    created_at   DATETIME,
    updated_at   DATETIME,
    FOREIGN KEY (orang_tua_id) REFERENCES spay_orang_tua(id)
);
```

### 2.3 `spay_pembayaran`
```sql
CREATE TABLE spay_pembayaran (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    tagihan_id      INT NOT NULL,
    orang_tua_id    INT NOT NULL,
    bukti_bayar     VARCHAR(255),       -- path file upload
    tanggal_bayar   DATE,
    status          ENUM('pending','verified','rejected') DEFAULT 'pending',
    catatan_admin   TEXT,
    verified_at     DATETIME,
    created_at      DATETIME,
    updated_at      DATETIME,
    FOREIGN KEY (tagihan_id)   REFERENCES spay_tagihan(id),
    FOREIGN KEY (orang_tua_id) REFERENCES spay_orang_tua(id)
);
```

### 2.4 `sebook_ebook`
```sql
CREATE TABLE sebook_ebook (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    judul        VARCHAR(255) NOT NULL,
    deskripsi    TEXT,
    penulis      VARCHAR(150),
    kategori     VARCHAR(100),
    cover        VARCHAR(255),          -- path gambar cover
    file_path    VARCHAR(255) NOT NULL, -- path file PDF
    kelas        VARCHAR(100),          -- target kelas, bisa null = semua
    is_active    TINYINT(1) DEFAULT 1,
    created_by   INT,                   -- id user admin/guru (tidak FK ke tabel lama)
    created_at   DATETIME,
    updated_at   DATETIME
);
```

---

## 3. Migration Files

### File: `app/Database/Migrations/2026-06-08-000001_CreateSpayOrangTua.php`
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

*(Buat file migration serupa untuk `spay_tagihan`, `spay_pembayaran`, dan `sebook_ebook` mengikuti struktur di atas.)*

---

## 4. Routes — `app/Config/Routes.php`

Tambahkan di bagian **paling bawah** file routes yang sudah ada:

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
$routes->group('admin', ['filter' => 'adminauth'], function($routes) {
    // Verifikasi Pembayaran
    $routes->get('verifikasi-pembayaran',              'Admin\VerifikasiPembayaranController::index');
    $routes->get('verifikasi-pembayaran/(:num)',       'Admin\VerifikasiPembayaranController::detail/$1');
    $routes->post('verifikasi-pembayaran/proses/(:num)', 'Admin\VerifikasiPembayaranController::proses/$1');

    // CRUD E-Book
    $routes->get('ebook',              'Admin\EbookController::index');
    $routes->get('ebook/tambah',       'Admin\EbookController::tambah');
    $routes->post('ebook/simpan',      'Admin\EbookController::simpan');
    $routes->get('ebook/edit/(:num)',   'Admin\EbookController::edit/$1');
    $routes->post('ebook/update/(:num)','Admin\EbookController::update/$1');
    $routes->get('ebook/hapus/(:num)', 'Admin\EbookController::hapus/$1');
});

// ============================================================
// PUBLIC E-BOOK — Orang Tua & Siswa (bisa pakai filter login jika diperlukan)
// ============================================================
$routes->get('ebook',              'Ebook\PublicEbookController::index');
$routes->get('ebook/download/(:num)', 'Ebook\PublicEbookController::download/$1');
```

---

## 5. Filter Auth Orang Tua

**`app/Filters/OrangTuaAuthFilter.php`**
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

Daftarkan di **`app/Config/Filters.php`**:
```php
public array $aliases = [
    // ... filter yang sudah ada tetap di sini ...
    'orangtuaauth' => \App\Filters\OrangTuaAuthFilter::class,
];
```

---

## 6. Controllers

### 6.1 `OrangTua/AuthController.php`
```php
<?php
namespace App\Controllers\OrangTua;
use App\Controllers\BaseController;
use App\Models\OrangTuaModel;

class AuthController extends BaseController {
    public function login() {
        if (session()->get('orangtua_logged_in')) return redirect()->to('/orangtua/dashboard');
        return view('orangtua/auth/login');
    }

    public function loginProses() {
        $model = new OrangTuaModel();
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $model->where('email', $email)->where('is_active', 1)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'orangtua_logged_in' => true,
                'orangtua_id'        => $user['id'],
                'orangtua_nama'      => $user['nama'],
            ]);
            return redirect()->to('/orangtua/dashboard');
        }
        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    public function logout() {
        session()->remove(['orangtua_logged_in', 'orangtua_id', 'orangtua_nama']);
        return redirect()->to('/orangtua/login');
    }
}
```

### 6.2 `OrangTua/PembayaranController.php`
```php
<?php
namespace App\Controllers\OrangTua;
use App\Controllers\BaseController;
use App\Models\PembayaranModel;

class PembayaranController extends BaseController {
    protected $model;

    public function __construct() {
        $this->model = new PembayaranModel();
    }

    public function dashboard() {
        $id = session()->get('orangtua_id');
        $data['tagihan_pending'] = $this->model->getTagihanByOrangTua($id, 'pending');
        $data['tagihan_lunas']   = $this->model->getTagihanByOrangTua($id, 'verified');
        return view('orangtua/dashboard', $data);
    }

    public function index() {
        $id = session()->get('orangtua_id');
        $data['tagihan'] = $this->model->getTagihanByOrangTua($id);
        return view('orangtua/pembayaran/index', $data);
    }

    public function detail($id) {
        $data['tagihan'] = $this->model->getDetailTagihan($id, session()->get('orangtua_id'));
        if (!$data['tagihan']) return redirect()->to('/orangtua/pembayaran');
        return view('orangtua/pembayaran/detail', $data);
    }

    public function uploadBukti($tagihanId) {
        $file = $this->request->getFile('bukti_bayar');
        if (!$file->isValid()) return redirect()->back()->with('error', 'File tidak valid.');

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/bukti_bayar', $newName);

        $this->model->simpanPembayaran([
            'tagihan_id'    => $tagihanId,
            'orang_tua_id'  => session()->get('orangtua_id'),
            'bukti_bayar'   => $newName,
            'tanggal_bayar' => date('Y-m-d'),
            'status'        => 'pending',
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/orangtua/pembayaran')->with('success', 'Bukti pembayaran berhasil dikirim, menunggu verifikasi.');
    }
}
```

### 6.3 `Admin/VerifikasiPembayaranController.php`
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
        return view('admin/pembayaran/verifikasi', $data);
    }

    public function proses($id) {
        $status  = $this->request->getPost('status');  // 'verified' atau 'rejected'
        $catatan = $this->request->getPost('catatan');
        $this->model->updateStatus($id, $status, $catatan);
        return redirect()->to('/admin/verifikasi-pembayaran')->with('success', 'Status pembayaran diperbarui.');
    }
}
```

### 6.4 `Admin/EbookController.php`
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
        $coverName = $cover->isValid() ? $cover->getRandomName() : null;
        $fileName  = $file->getRandomName();
        if ($coverName) $cover->move(WRITEPATH . 'uploads/ebook/cover', $coverName);
        $file->move(WRITEPATH . 'uploads/ebook/file', $fileName);

        $this->model->insert([
            'judul'      => $this->request->getPost('judul'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'penulis'    => $this->request->getPost('penulis'),
            'kategori'   => $this->request->getPost('kategori'),
            'kelas'      => $this->request->getPost('kelas'),
            'cover'      => $coverName,
            'file_path'  => $fileName,
            'is_active'  => 1,
            'created_by' => session()->get('user_id'), // session admin yang ada
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/admin/ebook')->with('success', 'E-Book berhasil ditambahkan.');
    }

    public function edit($id) {
        $data['ebook'] = $this->model->find($id);
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
        // Update file hanya jika ada upload baru
        $file = $this->request->getFile('file_pdf');
        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/ebook/file', $fileName);
            $updateData['file_path'] = $fileName;
        }
        $this->model->update($id, $updateData);
        return redirect()->to('/admin/ebook')->with('success', 'E-Book berhasil diperbarui.');
    }

    public function hapus($id) {
        $this->model->update($id, ['is_active' => 0]); // soft delete
        return redirect()->to('/admin/ebook')->with('success', 'E-Book berhasil dihapus.');
    }
}
```

### 6.5 `Ebook/PublicEbookController.php`
```php
<?php
namespace App\Controllers\Ebook;
use App\Controllers\BaseController;
use App\Models\EbookModel;

class PublicEbookController extends BaseController {
    public function index() {
        $model = new EbookModel();
        $data['ebooks']     = $model->where('is_active', 1)->findAll();
        $data['kategoris']  = $model->getKategoriList();
        return view('public_ebook/index', $data);
    }

    public function download($id) {
        // Bisa ditambahkan cek login orang tua jika diperlukan
        $model = new EbookModel();
        $ebook = $model->find($id);
        if (!$ebook) return redirect()->to('/ebook');
        $path = WRITEPATH . 'uploads/ebook/file/' . $ebook['file_path'];
        return $this->response->download($path, null)->setFileName($ebook['judul'] . '.pdf');
    }
}
```

---

## 7. Models

### `app/Models/OrangTuaModel.php`
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

### `app/Models/PembayaranModel.php`
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
            ->select('t.*, p.status, p.bukti_bayar, p.id as pembayaran_id')
            ->join('spay_pembayaran p', 'p.tagihan_id = t.id AND p.orang_tua_id = t.orang_tua_id', 'left')
            ->where('t.orang_tua_id', $orangTuaId);
        if ($status) $builder->where('p.status', $status);
        return $builder->get()->getResultArray();
    }

    public function getDetailTagihan($tagihanId, $orangTuaId) {
        return $this->db->table('spay_tagihan t')
            ->select('t.*, p.status, p.bukti_bayar, p.catatan_admin, p.id as pembayaran_id')
            ->join('spay_pembayaran p', 'p.tagihan_id = t.id', 'left')
            ->where('t.id', $tagihanId)
            ->where('t.orang_tua_id', $orangTuaId)
            ->get()->getRowArray();
    }

    public function getAllPembayaran() {
        return $this->db->table('spay_pembayaran p')
            ->select('p.*, t.judul, t.nominal, ot.nama as nama_ortu, ot.nama_siswa, ot.kelas')
            ->join('spay_tagihan t',      't.id = p.tagihan_id')
            ->join('spay_orang_tua ot',   'ot.id = p.orang_tua_id')
            ->orderBy('p.created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function getPembayaranDetail($id) {
        return $this->db->table('spay_pembayaran p')
            ->select('p.*, t.judul, t.nominal, t.keterangan, ot.nama as nama_ortu, ot.nama_siswa, ot.kelas, ot.no_hp')
            ->join('spay_tagihan t',    't.id = p.tagihan_id')
            ->join('spay_orang_tua ot', 'ot.id = p.orang_tua_id')
            ->where('p.id', $id)
            ->get()->getRowArray();
    }

    public function simpanPembayaran($data) {
        return $this->db->table('spay_pembayaran')->insert($data);
    }

    public function updateStatus($id, $status, $catatan) {
        return $this->db->table('spay_pembayaran')->where('id', $id)->update([
            'status'       => $status,
            'catatan_admin'=> $catatan,
            'verified_at'  => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);
    }
}
```

### `app/Models/EbookModel.php`
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
            ->where('is_active', 1)->where('kategori IS NOT NULL')
            ->get()->getResultArray();
    }
}
```

---

## 8. Urutan Upload File

```
writable/
└── uploads/
    ├── bukti_bayar/     ← bukti transfer orang tua
    └── ebook/
        ├── cover/       ← gambar sampul e-book
        └── file/        ← file PDF e-book
```

Buat folder-folder ini secara manual atau tambahkan di deployment script:
```bash
mkdir -p writable/uploads/bukti_bayar
mkdir -p writable/uploads/ebook/cover
mkdir -p writable/uploads/ebook/file
```

---

## 9. Checklist Implementasi

### Phase 1 — Database & Setup
- [ ] Jalankan 4 migration (`spay_orang_tua`, `spay_tagihan`, `spay_pembayaran`, `sebook_ebook`)
- [ ] Buat folder upload di `writable/`
- [ ] Daftarkan `OrangTuaAuthFilter` di `app/Config/Filters.php`
- [ ] Tambahkan routes baru di bagian bawah `app/Config/Routes.php`

### Phase 2 — Fitur Pembayaran
- [ ] Buat `OrangTuaModel`, `PembayaranModel`
- [ ] Buat `AuthController` (login/logout orang tua)
- [ ] Buat view `orangtua/auth/login.php` (tampilan menarik, mobile-friendly)
- [ ] Buat `PembayaranController` (dashboard, list, detail, upload)
- [ ] Buat views pembayaran orang tua (card tagihan, status badge, form upload)
- [ ] Buat `VerifikasiPembayaranController` untuk admin
- [ ] Buat views verifikasi admin (tabel + modal approve/reject)

### Phase 3 — Fitur E-Book
- [ ] Buat `EbookModel`
- [ ] Buat `Admin/EbookController` (CRUD lengkap)
- [ ] Buat views admin e-book (tabel, form tambah, form edit)
- [ ] Buat `Ebook/PublicEbookController` (galeri + download)
- [ ] Buat view galeri e-book publik (card grid dengan cover, filter kategori)

### Phase 4 — Testing
- [ ] Test login orang tua → redirect jika belum login
- [ ] Test upload bukti bayar → status pending
- [ ] Test verifikasi admin → status berubah ke verified/rejected
- [ ] Test CRUD e-book admin (tambah, edit, soft delete)
- [ ] Test download e-book publik
- [ ] Pastikan tidak ada pengaruh ke fitur/route lama

---

## 10. Catatan Penting

| Hal | Keterangan |
|-----|-----------|
| Auth Orang Tua | Session key: `orangtua_logged_in`, `orangtua_id`, `orangtua_nama` — beda dengan session admin |
| Auth Admin | Tetap menggunakan filter/session admin yang sudah ada, tidak diubah |
| Hapus E-Book | Soft delete (`is_active = 0`), file PDF tidak dihapus dari disk |
| Upload Bukti | Disimpan di `writable/uploads/bukti_bayar/`, bukan `public/` |
| Session Guru/Staff | Untuk CRUD e-book, pastikan filter admin yang ada sudah mencakup role guru & staff, atau buat filter terpisah sesuai sistem role yang sudah berjalan |
