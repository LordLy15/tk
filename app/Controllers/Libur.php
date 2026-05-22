<?php

namespace App\Controllers;

use App\Models\LiburSekolahModel;

class Libur extends BaseController
{
    protected $liburModel;

    public function __construct()
    {
        $this->liburModel = new LiburSekolahModel();
    }

    public function index()
    {
        $data = [
            'libur' => $this->liburModel->orderBy('tanggal_mulai', 'ASC')->findAll()
        ];

        return view('Libur/index', $data);
    }

    public function tambah()
    {
        return view('Libur/form');
    }

    public function simpan()
    {
        $data = [
            'nama_libur' => $this->request->getPost('nama_libur'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'keterangan' => $this->request->getPost('keterangan'),
            'jenis_libur' => $this->request->getPost('jenis_libur'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->liburModel->insert($data)) {
            return redirect()->to('/libur')->with('success', 'Libur berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan libur');
    }

    public function edit($id)
    {
        $data = [
            'libur' => $this->liburModel->find($id)
        ];

        if (!$data['libur']) {
            return redirect()->to('/libur')->with('error', 'Data libur tidak ditemukan');
        }

        return view('Libur/form', $data);
    }

    public function update($id)
    {
        $data = [
            'nama_libur' => $this->request->getPost('nama_libur'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'keterangan' => $this->request->getPost('keterangan'),
            'jenis_libur' => $this->request->getPost('jenis_libur'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->liburModel->update($id, $data)) {
            return redirect()->to('/libur')->with('success', 'Libur berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui libur');
    }

    public function hapus($id)
    {
        if ($this->liburModel->delete($id)) {
            return redirect()->to('/libur')->with('success', 'Libur berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus libur');
    }
}
