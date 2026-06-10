<?php

namespace App\Controllers;

use App\Models\AktivitasModel;
use App\Models\AktivitasKelasModel;
use App\Models\KelasModel;

class Aktivitas extends BaseController
{
    protected $aktivitasModel;
    protected $aktivitasKelasModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->aktivitasModel = new AktivitasModel();
        $this->aktivitasKelasModel = new AktivitasKelasModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $data = [
            'aktivitas' => $this->aktivitasModel->findAll()
        ];

        return view('Aktivitas/index', $data);
    }

    public function tambah()
    {
        return view('Aktivitas/form');
    }

    public function simpan()
    {
        $data = [
            'judul_aktivitas' => $this->request->getPost('judul_aktivitas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jenis_aktivitas' => $this->request->getPost('jenis_aktivitas'),
            'kategori' => $this->request->getPost('kategori'),
            'tujuan' => $this->request->getPost('tujuan'),
            'metode' => $this->request->getPost('metode'),
            'durasi_menit' => $this->request->getPost('durasi_menit'),
            'bahan_alat' => $this->request->getPost('bahan_alat')
        ];

        if ($this->aktivitasModel->insert($data)) {
            return redirect()->to('/aktivitas')->with('success', 'Aktivitas berhasil ditambahkan');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan aktivitas');
    }

    public function edit($id)
    {
        $data = [
            'aktivitas' => $this->aktivitasModel->find($id)
        ];

        if (!$data['aktivitas']) {
            return redirect()->to('/aktivitas')->with('error', 'Aktivitas tidak ditemukan');
        }

        return view('Aktivitas/form', $data);
    }

    public function update($id)
    {
        $data = [
            'judul_aktivitas' => $this->request->getPost('judul_aktivitas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jenis_aktivitas' => $this->request->getPost('jenis_aktivitas'),
            'kategori' => $this->request->getPost('kategori'),
            'tujuan' => $this->request->getPost('tujuan'),
            'metode' => $this->request->getPost('metode'),
            'durasi_menit' => $this->request->getPost('durasi_menit'),
            'bahan_alat' => $this->request->getPost('bahan_alat')
        ];

        if ($this->aktivitasModel->update($id, $data)) {
            return redirect()->to('/aktivitas')->with('success', 'Aktivitas berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui aktivitas');
    }

    public function hapus($id)
    {
        if ($this->aktivitasModel->delete($id)) {
            return redirect()->to('/aktivitas')->with('success', 'Aktivitas berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus aktivitas');
    }

    public function jadwalKelas()
    {
        $id_kelas = $this->request->getGet('kelas');
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

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
            'id_kelas_selected' => $id_kelas,
            'tanggal' => $tanggal
        ];

        if ($id_kelas) {
            $data['aktivitas_kelas'] = $this->aktivitasKelasModel->getAktivitasKelasWithDetail($id_kelas, $tanggal);
        }

        return view('Aktivitas/jadwal_kelas', $data);
    }

    public function tambahJadwalKelas()
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
            'aktivitas_list' => $this->aktivitasModel->findAll()
        ];

        return view('Aktivitas/form_jadwal_kelas', $data);
    }

    public function simpanJadwalKelas()
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
            'id_aktivitas' => $this->request->getPost('id_aktivitas'),
            'id_kelas' => $id_kelas,
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'hasil_pembelajaran' => $this->request->getPost('hasil_pembelajaran'),
            'catatan' => $this->request->getPost('catatan')
        ];

        if ($this->aktivitasKelasModel->insert($data)) {
            return redirect()->to('/aktivitas/jadwal-kelas')->with('success', 'Jadwal aktivitas berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan jadwal aktivitas');
    }
}
