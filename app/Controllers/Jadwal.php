<?php

namespace App\Controllers;

use App\Models\JadwalKelasModel;
use App\Models\KelasModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalKelasModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $id_kelas = $this->request->getGet('kelas');

        $data = [
            'kelas_list' => $this->kelasModel->findAll(),
            'id_kelas_selected' => $id_kelas
        ];

        if ($id_kelas) {
            $data['jadwal'] = $this->jadwalModel->getJadwalByKelas($id_kelas);
        }

        return view('Jadwal/index', $data);
    }

    public function tambah()
    {
        $data = [
            'kelas_list' => $this->kelasModel->findAll(),
            'hari_list' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
        ];

        return view('Jadwal/form', $data);
    }

    public function simpan()
    {
        $data = [
            'id_kelas' => $this->request->getPost('id_kelas'),
            'hari' => $this->request->getPost('hari'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'aktivitas' => $this->request->getPost('aktivitas'),
            'ruangan' => $this->request->getPost('ruangan')
        ];

        if ($this->jadwalModel->insert($data)) {
            return redirect()->to('/jadwal')->with('success', 'Jadwal berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan jadwal');
    }

    public function edit($id)
    {
        $data = [
            'jadwal' => $this->jadwalModel->find($id),
            'kelas_list' => $this->kelasModel->findAll(),
            'hari_list' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
        ];

        if (!$data['jadwal']) {
            return redirect()->to('/jadwal')->with('error', 'Jadwal tidak ditemukan');
        }

        return view('Jadwal/form', $data);
    }

    public function update($id)
    {
        $data = [
            'id_kelas' => $this->request->getPost('id_kelas'),
            'hari' => $this->request->getPost('hari'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'aktivitas' => $this->request->getPost('aktivitas'),
            'ruangan' => $this->request->getPost('ruangan')
        ];

        if ($this->jadwalModel->update($id, $data)) {
            return redirect()->to('/jadwal')->with('success', 'Jadwal berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui jadwal');
    }

    public function hapus($id)
    {
        if ($this->jadwalModel->delete($id)) {
            return redirect()->to('/jadwal')->with('success', 'Jadwal berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus jadwal');
    }
}
