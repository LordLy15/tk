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

        if (strtolower((string) session('role')) === 'guru') {
            $assignedKelas = $this->kelasModel->where('id_guru', session('id_guru'))->first();
            $myKelasId = $assignedKelas ? (int) $assignedKelas['id_kelas'] : 0;
            $id_kelas = $myKelasId;
            $kelasList = $this->kelasModel->where('id_kelas', $myKelasId)->findAll();
        } else {
            $kelasList = $this->kelasModel->findAll();
        }

        $data = [
            'kelas_list' => $kelasList,
            'id_kelas_selected' => $id_kelas
        ];

        if ($id_kelas) {
            $data['jadwal'] = $this->jadwalModel->getJadwalByKelas($id_kelas);
        }

        return view('Jadwal/index', $data);
    }

    public function tambah()
    {
        if (strtolower((string) session('role')) === 'guru') {
            $assignedKelas = $this->kelasModel->where('id_guru', session('id_guru'))->first();
            $myKelasId = $assignedKelas ? (int) $assignedKelas['id_kelas'] : 0;
            $kelasList = $this->kelasModel->where('id_kelas', $myKelasId)->findAll();
        } else {
            $kelasList = $this->kelasModel->findAll();
        }

        $data = [
            'kelas_list' => $kelasList,
            'hari_list' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
        ];

        return view('Jadwal/form', $data);
    }

    public function simpan()
    {
        $id_kelas = $this->request->getPost('id_kelas');

        if (strtolower((string) session('role')) === 'guru') {
            $assignedKelas = $this->kelasModel->where('id_guru', session('id_guru'))->first();
            $myKelasId = $assignedKelas ? (int) $assignedKelas['id_kelas'] : 0;
            if ((int)$id_kelas !== $myKelasId) {
                return redirect()->back()->with('error', 'Anda tidak diperbolehkan menambah jadwal untuk kelas lain.');
            }
        }

        $data = [
            'id_kelas' => $id_kelas,
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
        $jadwal = $this->jadwalModel->find($id);

        if (strtolower((string) session('role')) === 'guru') {
            $assignedKelas = $this->kelasModel->where('id_guru', session('id_guru'))->first();
            $myKelasId = $assignedKelas ? (int) $assignedKelas['id_kelas'] : 0;

            if (!$jadwal || (int)$jadwal['id_kelas'] !== $myKelasId) {
                return redirect()->to('/jadwal')->with('error', 'Anda tidak memiliki akses ke jadwal kelas ini.');
            }
            $kelasList = $this->kelasModel->where('id_kelas', $myKelasId)->findAll();
        } else {
            $kelasList = $this->kelasModel->findAll();
        }

        $data = [
            'jadwal' => $jadwal,
            'kelas_list' => $kelasList,
            'hari_list' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
        ];

        if (!$data['jadwal']) {
            return redirect()->to('/jadwal')->with('error', 'Jadwal tidak ditemukan');
        }

        return view('Jadwal/form', $data);
    }

    public function update($id)
    {
        $jadwal = $this->jadwalModel->find($id);

        if (strtolower((string) session('role')) === 'guru') {
            $assignedKelas = $this->kelasModel->where('id_guru', session('id_guru'))->first();
            $myKelasId = $assignedKelas ? (int) $assignedKelas['id_kelas'] : 0;

            if (!$jadwal || (int)$jadwal['id_kelas'] !== $myKelasId) {
                return redirect()->to('/jadwal')->with('error', 'Anda tidak memiliki akses ke jadwal kelas ini.');
            }
            $id_kelas = $myKelasId;
        } else {
            $id_kelas = $this->request->getPost('id_kelas');
        }

        $data = [
            'id_kelas' => $id_kelas,
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
        $jadwal = $this->jadwalModel->find($id);

        if (strtolower((string) session('role')) === 'guru') {
            $assignedKelas = $this->kelasModel->where('id_guru', session('id_guru'))->first();
            $myKelasId = $assignedKelas ? (int) $assignedKelas['id_kelas'] : 0;

            if (!$jadwal || (int)$jadwal['id_kelas'] !== $myKelasId) {
                return redirect()->to('/jadwal')->with('error', 'Anda tidak memiliki akses ke jadwal kelas ini.');
            }
        }

        if ($this->jadwalModel->delete($id)) {
            return redirect()->to('/jadwal')->with('success', 'Jadwal berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus jadwal');
    }
}
