<?php

namespace App\Controllers;

use App\Models\OrangTuaModel;
use App\Models\MuridModel;
use App\Models\KelasModel;

class OrangTua extends BaseController
{
    protected $orangTuaModel;
    protected $muridModel;
    protected $kelasModel;


    public function __construct()
    {
        $this->orangTuaModel = new OrangTuaModel();
        $this->muridModel = new MuridModel();
        $this->kelasModel = new KelasModel();
    }

public function index()
{
    $id_kelas = $this->request->getGet('kelas');
    $search = $this->request->getGet('search');

    $query = $this->orangTuaModel
        ->select('orang_tua.*, murid.nama_murid, kelas.nama_kelas')
        ->join('murid','murid.id=orang_tua.id_murid')
        ->join('kelas','kelas.id_kelas=murid.id_kelas');

    // filter kelas
    if (!empty($id_kelas)) {

        $query->where('murid.id_kelas', $id_kelas);

    }

    // pencarian
    if (!empty($search)) {

        $query->groupStart()
              ->like('murid.nama_murid', $search)
              ->orLike('orang_tua.nama_ayah', $search)
              ->orLike('orang_tua.nama_ibu', $search)
              ->groupEnd();

    }

    $data = [
        'orang_tua' => $query->findAll(),
        'kelas' => $this->kelasModel->findAll(),
        'id_kelas' => $id_kelas,
        'search' => $search
    ];

    return view('OrangTua/index', $data);
}

    public function detail($id)
    {
        $orangTua = $this->orangTuaModel
            ->select('orang_tua.*, murid.nama_murid')
            ->join('murid', 'murid.id = orang_tua.id_murid', 'left')
            ->find($id);

        if (!$orangTua) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data orang tua tidak ditemukan');
        }

        return view('OrangTua/detail', ['orang_tua' => $orangTua]);
    }

    public function tambah()
    {
        $id_kelas = $this->request->getGet('kelas');
        $data['kelas'] = $this->kelasModel->findAll();

        $data['murid_list'] = [];

        if ($id_kelas) {

            $data['murid_list'] = $this->muridModel
                ->where('id_kelas', $id_kelas)
                ->findAll();
        }

        $data['id_kelas'] = $id_kelas;

        return view('OrangTua/tambah', $data);
    }

    public function simpan()
    {
        $post = $this->request->getPost();

        // Validasi no_hp harus mulai dengan +62 atau 08
        $noHpAyah = $post['no_hp_ayah'] ?? '';
        $noHpIbu = $post['no_hp_ibu'] ?? '';

        if ($noHpAyah && !preg_match('/^(\+62|08)/', $noHpAyah)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', 'Nomor HP Ayah harus dimulai dengan +62 atau 08.');
        }

        if ($noHpIbu && !preg_match('/^(\+62|08)/', $noHpIbu)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', 'Nomor HP Ibu harus dimulai dengan +62 atau 08.');
        }

        $rules = [
            'id_murid' => 'required|integer',
            'nama_ayah' => 'required|string|max_length[100]',
            'no_hp_ayah' => 'required|string|max_length[15]',
            'pekerjaan_ayah' => 'string|max_length[100]',
            'nama_ibu' => 'required|string|max_length[100]',
            'no_hp_ibu' => 'required|string|max_length[15]',
            'pekerjaan_ibu' => 'string|max_length[100]',
            'alamat' => 'required|string',
            'email' => 'valid_email|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $data = [
            'id_murid' => $post['id_murid'] ?? null,
            'nama_ayah' => $post['nama_ayah'] ?? null,
            'no_hp_ayah' => $post['no_hp_ayah'] ?? null,
            'pekerjaan_ayah' => $post['pekerjaan_ayah'] ?? null,
            'nama_ibu' => $post['nama_ibu'] ?? null,
            'no_hp_ibu' => $post['no_hp_ibu'] ?? null,
            'pekerjaan_ibu' => $post['pekerjaan_ibu'] ?? null,
            'alamat' => tk_compose_address_from_post($post),
            'email' => $post['email'] ?? null
        ];

        if ($this->orangTuaModel->insert($data)) {
            return redirect()->to('orang-tua')->with('success', 'Data orang tua berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan data orang tua');
    }

    public function edit($id)
    {
    $orangTua = $this->orangTuaModel
        ->select('orang_tua.*, murid.id_kelas')
        ->join('murid', 'murid.id = orang_tua.id_murid')
        ->where('orang_tua.id', $id)
        ->first();

    if (!$orangTua) {
        return redirect()
            ->to('orang-tua')
            ->with('error', 'Data tidak ditemukan');
    }

    // ambil id_kelas dari murid
    $id_kelas = $orangTua['id_kelas'];

    // tampilkan murid sesuai kelas
    $murid_list = $this->muridModel
        ->where('id_kelas', $id_kelas)
        ->findAll();

    $data = [
        'orang_tua' => $orangTua,
        'murid_list' => $murid_list,
        'kelas' => $this->kelasModel->findAll(),
        'id_kelas' => $id_kelas,
        'validation' => null
    ];

    return view('OrangTua/edit', $data);
    }

    public function update($id)
    {
        $orangTua = $this->orangTuaModel->find($id);
        $post = $this->request->getPost();

        if (!$orangTua) {
            return redirect()->to('orang-tua')->with('error', 'Data tidak ditemukan');
        }

        // Validasi no_hp harus mulai dengan +62 atau 08
        $noHpAyah = $post['no_hp_ayah'] ?? '';
        $noHpIbu = $post['no_hp_ibu'] ?? '';

        if ($noHpAyah && !preg_match('/^(\+62|08)/', $noHpAyah)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', 'Nomor HP Ayah harus dimulai dengan +62 atau 08.');
        }

        if ($noHpIbu && !preg_match('/^(\+62|08)/', $noHpIbu)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', 'Nomor HP Ibu harus dimulai dengan +62 atau 08.');
        }

        $rules = [
            'id_murid' => 'required|integer',
            'nama_ayah' => 'required|string|max_length[100]',
            'no_hp_ayah' => 'required|string|max_length[15]',
            'pekerjaan_ayah' => 'string|max_length[100]',
            'nama_ibu' => 'required|string|max_length[100]',
            'no_hp_ibu' => 'required|string|max_length[15]',
            'pekerjaan_ibu' => 'string|max_length[100]',
            'alamat' => 'required|string',
            'email' => 'valid_email|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $data = [
            'id_kelas' => $post['id_kelas'] ?? null,
            'id_murid' => $post['id_murid'] ?? null,
            'nama_ayah' => $post['nama_ayah'] ?? null,
            'no_hp_ayah' => $post['no_hp_ayah'] ?? null,
            'pekerjaan_ayah' => $post['pekerjaan_ayah'] ?? null,
            'nama_ibu' => $post['nama_ibu'] ?? null,
            'no_hp_ibu' => $post['no_hp_ibu'] ?? null,
            'pekerjaan_ibu' => $post['pekerjaan_ibu'] ?? null,
            'alamat' => tk_compose_address_from_post($post),
            'email' => $post['email'] ?? null
        ];

        if ($this->orangTuaModel->update($id, $data)) {
            return redirect()->to('orang-tua')->with('success', 'Data orang tua berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui data orang tua');
    }

    public function hapus($id)
    {
        $orangTua = $this->orangTuaModel->find($id);

        if (!$orangTua) {
            return redirect()->to('orang-tua')->with('error', 'Data tidak ditemukan');
        }

        if ($this->orangTuaModel->delete($id)) {
            return redirect()->to('orang-tua')->with('success', 'Data orang tua berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus data orang tua');
    }
}
