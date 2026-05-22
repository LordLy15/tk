<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\MuridModel;
use App\Models\PendidikanModel;

class Murid extends BaseController
{
    protected $murid;
    protected $kelas;
    protected $pendidikan;

    public function __construct()
    {
        $this->murid = new MuridModel();
        $this->kelas = new KelasModel();
        $this->pendidikan = new PendidikanModel();
    }

    // tampil data
    public function index()
    {
        $data['murid'] = $this->murid
            ->select('murid.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id_kelas = murid.id_kelas')
            ->findAll();

        return view('Murid/index', $data);
    }

    public function detail($id)
    {
        $data['murid'] = $this->murid
            ->select('murid.*, kelas.nama_kelas')
            ->join('kelas', 'kelas.id_kelas = murid.id_kelas', 'left')
            ->find($id);

        if (!$data['murid']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Data murid tidak ditemukan'
            );
        }

        return view('Murid/detail', $data);
    }

    // form tambah
    public function tambah()
    {
        $data['kelas'] = $this->kelas->findAll();

        return view('Murid/tambah', $data);
    }

    // simpan
    public function simpan()
    {
        $rules = [
            'id_kelas' => 'required|integer',
            'nisn' => 'required|numeric|max_length[20]',
            'nama_murid' => 'required|max_length[100]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tempat_lahir' => 'required|max_length[100]',
            'tanggal_lahir' => 'required|valid_date',
            'alamat' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lengkapi data murid dengan benar.');
        }

        $post = $this->request->getPost();

        $this->murid->save([
            'id_kelas' => $post['id_kelas'] ?? null,
            'nisn' => $post['nisn'] ?? null,
            'nama_murid' => $post['nama_murid'] ?? null,
            'jenis_kelamin' => $post['jenis_kelamin'] ?? null,
            'tempat_lahir' => $post['tempat_lahir'] ?? null,
            'tanggal_lahir' => $post['tanggal_lahir'] ?? null,
            'alamat' => tk_compose_address_from_post($post),
        ]);

        return redirect()->to('/murid')->with('success', 'Data murid berhasil ditambahkan.');
    }

    // form edit
    public function edit($id_murid)
    {
        $data['murid'] = $this->murid->find($id_murid);
        $data['kelas'] = $this->kelas->findAll();

        if (! $data['murid']) {
            return redirect()->to('/murid')->with('error', 'Data murid tidak ditemukan.');
        }

        return view('Murid/edit', $data);
    }

    // update
    public function update($id_murid)
    {
        $rules = [
            'id_kelas' => 'required|integer',
            'nisn' => 'required|numeric|max_length[20]',
            'nama_murid' => 'required|max_length[100]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tempat_lahir' => 'required|max_length[100]',
            'tanggal_lahir' => 'required|valid_date',
            'alamat' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lengkapi data murid dengan benar.');
        }

        $post = $this->request->getPost();

        $this->murid->update($id_murid, [
            'id_kelas' => $post['id_kelas'] ?? null,
            'nisn' => $post['nisn'] ?? null,
            'nama_murid' => $post['nama_murid'] ?? null,
            'jenis_kelamin' => $post['jenis_kelamin'] ?? null,
            'tempat_lahir' => $post['tempat_lahir'] ?? null,
            'tanggal_lahir' => $post['tanggal_lahir'] ?? null,
            'alamat' => tk_compose_address_from_post($post),
        ]);

        return redirect()->to('/murid')->with('success', 'Data murid berhasil diperbarui.');
    }

    // hapus
    public function hapus($id)
    {
        $this->murid->delete($id);

        return redirect()->to('/murid')->with('success', 'Data murid berhasil dihapus.');
    }
}
