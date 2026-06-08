<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SeBookEbookModel;
use App\Models\KelasModel;

class EbookController extends BaseController
{
    protected $model;
    protected $kelasModel;

    public function __construct()
    {
        $this->model = new SeBookEbookModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $data['ebooks'] = $this->model->findAll();
        return view('admin/ebook/index', $data);
    }

    public function tambah()
    {
        $data['kelas_list'] = $this->kelasModel->findAll();
        return view('admin/ebook/create', $data);
    }

    public function simpan()
    {
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

        // Handle multi-select kelas
        $kelasSelected = $this->request->getPost('kelas');
        $kelasValue = is_array($kelasSelected) ? implode(', ', $kelasSelected) : ($kelasSelected ?? '');

        $this->model->insert([
            'judul'      => $this->request->getPost('judul'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'penulis'    => $this->request->getPost('penulis'),
            'kategori'   => $this->request->getPost('kategori'),
            'kelas'      => $kelasValue,
            'cover'      => $coverName,
            'file_path'  => $fileName,
            'is_active'  => 1,
            'created_by' => session()->get('user_id'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/ebook')->with('success', 'E-Book berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['ebook'] = $this->model->find($id);
        if (!$data['ebook']) {
            return redirect()->to('/admin/ebook')->with('error', 'E-Book tidak ditemukan.');
        }
        $data['kelas_list'] = $this->kelasModel->findAll();
        return view('admin/ebook/edit', $data);
    }

    public function update($id)
    {
        $updateData = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'penulis'   => $this->request->getPost('penulis'),
            'kategori'  => $this->request->getPost('kategori'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ];

        // Handle multi-select kelas
        $kelasSelected = $this->request->getPost('kelas');
        $kelasValue = is_array($kelasSelected) ? implode(', ', $kelasSelected) : ($kelasSelected ?? '');
        $updateData['kelas'] = $kelasValue;

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

    public function hapus($id)
    {
        $this->model->update($id, ['is_active' => 0]);
        return redirect()->to('/admin/ebook')->with('success', 'E-Book berhasil dihapus.');
    }
}