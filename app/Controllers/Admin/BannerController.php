<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BannerModel;

class BannerController extends BaseController
{
    protected $model;

    public function __construct()
    {
        // Guard to ensure only users with 'Staff' or 'Administrator' role can access
        $role = strtolower((string) session()->get('role'));
        if ($role !== 'staff' && $role !== 'administrator') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->model = new BannerModel();
    }

    public function index()
    {
        $data['banners'] = $this->model->orderBy('id', 'DESC')->findAll();
        $data['title'] = 'Manajemen Banner Berita';
        return view('Admin/banner/index', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Banner Berita';
        return view('Admin/banner/create', $data);
    }

    public function simpan()
    {
        $validationRules = [
            'judul'     => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'permit_empty|string',
            'link_url'  => 'permit_empty|valid_url',
        ];

        // Validate image file using base helper
        $photoRules = $this->profilePhotoValidationRule('gambar', 'Banner');
        
        $validation = $this->validate(array_merge($validationRules, [
            'gambar' => $photoRules['rules']
        ]));

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambarName = $this->storeUploadedProfilePhoto('gambar', 'banners');

        if (!$gambarName) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar banner.');
        }

        $this->model->insert([
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar'    => $gambarName,
            'link_url'  => $this->request->getPost('link_url'),
            'is_active' => $this->request->getPost('is_active') !== null ? (int)$this->request->getPost('is_active') : 1,
        ]);

        return redirect()->to(base_url('admin/banner'))->with('success', 'Banner berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $banner = $this->model->find($id);
        if (!$banner) {
            return redirect()->to(base_url('admin/banner'))->with('error', 'Banner tidak ditemukan.');
        }

        $data['banner'] = $banner;
        $data['title'] = 'Edit Banner Berita';
        return view('Admin/banner/edit', $data);
    }

    public function update($id)
    {
        $banner = $this->model->find($id);
        if (!$banner) {
            return redirect()->to(base_url('admin/banner'))->with('error', 'Banner tidak ditemukan.');
        }

        $validationRules = [
            'judul'     => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'permit_empty|string',
            'link_url'  => 'permit_empty|valid_url',
        ];

        // If a new image is uploaded, validate it
        $file = $this->request->getFile('gambar');
        $hasNewFile = $file && $file->isValid();

        if ($hasNewFile) {
            $photoRules = $this->profilePhotoValidationRule('gambar', 'Banner');
            $validationRules['gambar'] = $photoRules['rules'];
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'link_url'  => $this->request->getPost('link_url'),
            'is_active' => $this->request->getPost('is_active') !== null ? (int)$this->request->getPost('is_active') : 1,
        ];

        if ($hasNewFile) {
            $gambarName = $this->storeUploadedProfilePhoto('gambar', 'banners');
            if ($gambarName) {
                // Delete old photo
                $this->deleteUploadedProfilePhoto($banner['gambar'], 'banners');
                $updateData['gambar'] = $gambarName;
            }
        }

        $this->model->update($id, $updateData);

        return redirect()->to(base_url('admin/banner'))->with('success', 'Banner berita berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $banner = $this->model->find($id);
        if (!$banner) {
            return redirect()->to(base_url('admin/banner'))->with('error', 'Banner tidak ditemukan.');
        }

        // Delete photo
        $this->deleteUploadedProfilePhoto($banner['gambar'], 'banners');
        
        $this->model->delete($id);

        return redirect()->to(base_url('admin/banner'))->with('success', 'Banner berita berhasil dihapus.');
    }
}
