<?php

namespace App\Controllers;

use App\Models\PengumumanModel;

class Pengumuman extends BaseController
{
    protected $pengumumanModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }

    public function index()
    {
        $data = [
            'pengumuman' => $this->pengumumanModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('Pengumuman/index', $data);
    }

    public function tambah()
    {
        return view('Pengumuman/form');
    }

    public function simpan()
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'prioritas' => $this->request->getPost('prioritas'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->pengumumanModel->insert($data)) {
            return redirect()->to('/pengumuman')->with('success', 'Pengumuman berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan pengumuman');
    }

    public function edit($id)
    {
        $data = [
            'pengumuman' => $this->pengumumanModel->find($id)
        ];

        if (!$data['pengumuman']) {
            return redirect()->to('/pengumuman')->with('error', 'Pengumuman tidak ditemukan');
        }

        return view('Pengumuman/form', $data);
    }

    public function update($id)
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'prioritas' => $this->request->getPost('prioritas'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->pengumumanModel->update($id, $data)) {
            return redirect()->to('/pengumuman')->with('success', 'Pengumuman berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui pengumuman');
    }

    public function toggleStatus($id)
    {
        $pengumuman = $this->pengumumanModel->find($id);

        if (! $pengumuman) {
            return redirect()->to('/pengumuman')->with('error', 'Pengumuman tidak ditemukan');
        }

        $status = $this->request->getPost('status');

        if (! in_array($status, ['aktif', 'nonaktif'], true)) {
            $status = ($pengumuman['status'] ?? '') === 'aktif' ? 'nonaktif' : 'aktif';
        }

        if ($this->pengumumanModel->update($id, ['status' => $status])) {
            return redirect()->to('/pengumuman')->with('success', 'Status pengumuman berhasil diubah');
        }

        return redirect()->back()->with('error', 'Gagal mengubah status pengumuman');
    }

    public function hapus($id)
    {
        if ($this->pengumumanModel->delete($id)) {
            return redirect()->to('/pengumuman')->with('success', 'Pengumuman berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus pengumuman');
    }
}
