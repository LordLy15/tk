<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SpayOrangTuaModel;
use App\Models\MuridModel;
use App\Models\KelasModel;

class SpayOrangTuaController extends BaseController
{
    protected $model;
    protected $muridModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->model = new SpayOrangTuaModel();
        $this->muridModel = new MuridModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $data['orang_tua'] = $this->model->orderBy('created_at', 'DESC')->findAll();
        return view('Admin/spay_orang_tua/index', $data);
    }

    public function tambah()
    {
        $data['murid_list'] = $this->muridModel
            ->select('murid.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id_kelas = murid.id_kelas', 'left')
            ->orderBy('murid.nama_murid', 'ASC')
            ->findAll();
        return view('Admin/spay_orang_tua/create', $data);
    }

    public function simpan()
    {
        $email = $this->request->getPost('email');
        $muridId = $this->request->getPost('murid_id');
        $noHp = $this->request->getPost('no_hp');

        // Validasi no_hp harus mulai dengan +62 atau 08
        if ($noHp && !preg_match('/^(\+62|08)/', $noHp)) {
            return redirect()->back()->withInput()->with('error', 'Nomor HP harus dimulai dengan +62 atau 08.');
        }

        // Check if email already exists
        $existing = $this->model->where('email', $email)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar.');
        }

        // Get student info if selected
        $namaSiswa = '';
        $kelas = '';
        if ($muridId) {
            $murid = $this->muridModel->find($muridId);
            if ($murid) {
                $namaSiswa = $murid['nama_murid'];
                $kelasData = $this->kelasModel->find($murid['id_kelas']);
                $kelas = $kelasData ? $kelasData['nama_kelas'] : '';
            }
        }

        $this->model->insert([
            'nama'       => $this->request->getPost('nama'),
            'email'      => $email,
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'no_hp'      => $noHp,
            'nama_siswa' => $namaSiswa,
            'kelas'      => $kelas,
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/spay-orang-tua')->with('success', 'Akun orang tua berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['orang_tua'] = $this->model->find($id);
        if (!$data['orang_tua']) {
            return redirect()->to('/admin/spay-orang-tua')->with('error', 'Data tidak ditemukan.');
        }
        $data['murid_list'] = $this->muridModel
            ->select('murid.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id_kelas = murid.id_kelas', 'left')
            ->orderBy('murid.nama_murid', 'ASC')
            ->findAll();
        return view('Admin/spay_orang_tua/edit', $data);
    }

    public function update($id)
    {
        $orangTua = $this->model->find($id);
        if (!$orangTua) {
            return redirect()->to('/admin/spay-orang-tua')->with('error', 'Data tidak ditemukan.');
        }

        $email = $this->request->getPost('email');
        $noHp = $this->request->getPost('no_hp');

        // Validasi no_hp harus mulai dengan +62 atau 08
        if ($noHp && !preg_match('/^(\+62|08)/', $noHp)) {
            return redirect()->back()->withInput()->with('error', 'Nomor HP harus dimulai dengan +62 atau 08.');
        }

        // Check if email already exists for other users
        $existing = $this->model->where('email', $email)->where('id !=', $id)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Email sudah terdaftar.');
        }

        $updateData = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $email,
            'no_hp' => $noHp,
        ];

        // If password is provided, update it
        $password = $this->request->getPost('password');
        if ($password) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // If student is selected, update student info
        $muridId = $this->request->getPost('murid_id');
        if ($muridId) {
            $murid = $this->muridModel->find($muridId);
            if ($murid) {
                $updateData['nama_siswa'] = $murid['nama_murid'];
                $kelasData = $this->kelasModel->find($murid['id_kelas']);
                $updateData['kelas'] = $kelasData ? $kelasData['nama_kelas'] : '';
            }
        }

        $updateData['updated_at'] = date('Y-m-d H:i:s');
        $this->model->update($id, $updateData);

        return redirect()->to('/admin/spay-orang-tua')->with('success', 'Akun orang tua berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $this->model->update($id, ['is_active' => 0]);
        return redirect()->to('/admin/spay-orang-tua')->with('success', 'Akun orang tua berhasil dihapus.');
    }
}