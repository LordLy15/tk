<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;

class BeritaController extends BaseController
{
    protected $model;

    public function __construct()
    {
        // Guard to ensure only users with 'Staff' or 'Administrator' role can access
        $role = strtolower((string) session()->get('role'));
        if ($role !== 'staff' && $role !== 'administrator') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->model = new BeritaModel();
    }

    public function index()
    {
        $data['berita'] = $this->model->orderBy('tanggal', 'DESC')->orderBy('id', 'DESC')->findAll();
        $data['title'] = 'Manajemen Berita & Kegiatan';
        return view('Admin/berita/index', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Berita / Kegiatan';
        return view('Admin/berita/create', $data);
    }

    public function simpan()
    {
        helper('url');

        $validationRules = [
            'judul'    => 'required|min_length[3]|max_length[255]',
            'kategori' => 'required|in_list[Berita,Kegiatan]',
            'tanggal'  => 'required|valid_date',
            'konten'   => 'required',
        ];

        // Validate image file using base helper
        $photoRules = $this->profilePhotoValidationRule('gambar', 'Gambar Utama');
        
        $validation = $this->validate(array_merge($validationRules, [
            'gambar' => $photoRules['rules']
        ]));

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambarName = $this->storeUploadedProfilePhoto('gambar', 'berita');

        if (!$gambarName) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar berita/kegiatan.');
        }

        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true);

        // Check if slug exists, append random if needed
        $existing = $this->model->where('slug', $slug)->first();
        if ($existing) {
            $slug .= '-' . rand(100, 999);
        }

        $this->model->insert([
            'judul'    => $judul,
            'slug'     => $slug,
            'kategori' => $this->request->getPost('kategori'),
            'tanggal'  => $this->request->getPost('tanggal'),
            'konten'   => $this->request->getPost('konten'),
            'gambar'   => $gambarName,
            'penulis'  => session()->get('nama') ?? 'Staf Sekolah',
        ]);

        return redirect()->to(base_url('admin/berita'))->with('success', 'Berita/Kegiatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $berita = $this->model->find($id);
        if (!$berita) {
            return redirect()->to(base_url('admin/berita'))->with('error', 'Berita/Kegiatan tidak ditemukan.');
        }

        $data['berita'] = $berita;
        $data['title'] = 'Edit Berita / Kegiatan';
        return view('Admin/berita/edit', $data);
    }

    public function update($id)
    {
        helper('url');

        $berita = $this->model->find($id);
        if (!$berita) {
            return redirect()->to(base_url('admin/berita'))->with('error', 'Berita/Kegiatan tidak ditemukan.');
        }

        $validationRules = [
            'judul'    => 'required|min_length[3]|max_length[255]',
            'kategori' => 'required|in_list[Berita,Kegiatan]',
            'tanggal'  => 'required|valid_date',
            'konten'   => 'required',
        ];

        // If a new image is uploaded, validate it
        $file = $this->request->getFile('gambar');
        $hasNewFile = $file && $file->isValid();

        if ($hasNewFile) {
            $photoRules = $this->profilePhotoValidationRule('gambar', 'Gambar Utama');
            $validationRules['gambar'] = $photoRules['rules'];
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true);

        // Check if slug exists, append random if needed (excluding current record)
        $existing = $this->model->where('slug', $slug)->where('id !=', $id)->first();
        if ($existing) {
            $slug .= '-' . rand(100, 999);
        }

        $updateData = [
            'judul'    => $judul,
            'slug'     => $slug,
            'kategori' => $this->request->getPost('kategori'),
            'tanggal'  => $this->request->getPost('tanggal'),
            'konten'   => $this->request->getPost('konten'),
        ];

        if ($hasNewFile) {
            $gambarName = $this->storeUploadedProfilePhoto('gambar', 'berita');
            if ($gambarName) {
                // Delete old photo
                $this->deleteUploadedProfilePhoto($berita['gambar'], 'berita');
                $updateData['gambar'] = $gambarName;
            }
        }

        $this->model->update($id, $updateData);

        return redirect()->to(base_url('admin/berita'))->with('success', 'Berita/Kegiatan berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $berita = $this->model->find($id);
        if (!$berita) {
            return redirect()->to(base_url('admin/berita'))->with('error', 'Berita/Kegiatan tidak ditemukan.');
        }

        // Delete photo
        if ($berita['gambar']) {
            $this->deleteUploadedProfilePhoto($berita['gambar'], 'berita');
        }
        
        $this->model->delete($id);

        return redirect()->to(base_url('admin/berita'))->with('success', 'Berita/Kegiatan berhasil dihapus.');
    }
}
