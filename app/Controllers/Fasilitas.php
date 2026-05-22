<?php

namespace App\Controllers;

use App\Models\FasilitasSekolahModel;

class Fasilitas extends BaseController
{
    protected $fasilitasModel;

    public function __construct()
    {
        $this->fasilitasModel = new FasilitasSekolahModel();
    }

    public function index()
    {
        $data = [
            'fasilitas' => $this->fasilitasModel->findAll(),
            'rekap' => $this->fasilitasModel->getRekapFasilitas()
        ];

        return view('Fasilitas/index', $data);
    }

    public function tambah()
    {
        return view('Fasilitas/form');
    }

    public function simpan()
    {
        $data = [
            'nama_fasilitas' => $this->request->getPost('nama_fasilitas'),
            'jenis_fasilitas' => $this->request->getPost('jenis_fasilitas'),
            'jumlah' => $this->request->getPost('jumlah'),
            'kondisi' => $this->request->getPost('kondisi'),
            'lokasi' => $this->request->getPost('lokasi'),
            'catatan' => $this->request->getPost('catatan')
        ];

        if ($this->fasilitasModel->insert($data)) {
            return redirect()->to('/fasilitas')->with('success', 'Fasilitas berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan fasilitas');
    }

    public function edit($id)
    {
        $data = [
            'fasilitas' => $this->fasilitasModel->find($id)
        ];

        if (!$data['fasilitas']) {
            return redirect()->to('/fasilitas')->with('error', 'Fasilitas tidak ditemukan');
        }

        return view('Fasilitas/form', $data);
    }

    public function update($id)
    {
        $data = [
            'nama_fasilitas' => $this->request->getPost('nama_fasilitas'),
            'jenis_fasilitas' => $this->request->getPost('jenis_fasilitas'),
            'jumlah' => $this->request->getPost('jumlah'),
            'kondisi' => $this->request->getPost('kondisi'),
            'lokasi' => $this->request->getPost('lokasi'),
            'catatan' => $this->request->getPost('catatan')
        ];

        if ($this->fasilitasModel->update($id, $data)) {
            return redirect()->to('/fasilitas')->with('success', 'Fasilitas berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui fasilitas');
    }

    public function hapus($id)
    {
        if ($this->fasilitasModel->delete($id)) {
            return redirect()->to('/fasilitas')->with('success', 'Fasilitas berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus fasilitas');
    }

    public function laporan()
    {
        $data = [
            'fasilitas' => $this->fasilitasModel->findAll(),
            'rekap' => $this->fasilitasModel->getRekapFasilitas()
        ];

        return view('Fasilitas/laporan', $data);
    }
}
