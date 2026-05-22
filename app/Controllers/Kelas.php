<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\GuruModel;
use App\Models\PendidikanModel;

class Kelas extends BaseController
{
    protected $kelas;
    protected $guru;
    protected $pendidikan;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->guru  = new GuruModel();
        $this->pendidikan = new PendidikanModel();
    }

    // tampil data
    public function index()
    {
        $data['kelas'] = $this->kelas
            ->select('kelas.*, guru.nama_guru, pendidikan.nama')
            ->join('guru', 'guru.id = kelas.id_guru', 'left')
            ->join('pendidikan', 'pendidikan.id_pendidikan = kelas.id_pendidikan', 'left')
            ->findAll();

        return view('Kelas/index', $data);
    }

    // form tambah
    public function tambah()
    {
        $data['guru'] = $this->guru->findAll();
        $data['pendidikan'] = $this->pendidikan->findAll();

        return view('Kelas/tambah', $data);
    }

    // simpan
    public function simpan()
    {
        $rules = [
            'nama_kelas' => 'required|max_length[50]',
            'id_pendidikan' => 'required|integer',
            'id_guru' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lengkapi data kelas dengan benar.');
        }

        $post = $this->request->getPost();

        $this->kelas->save([
            'id_guru' => $post['id_guru'] ?? null,
            'id_pendidikan' => $post['id_pendidikan'] ?? null,
            'nama_kelas' => $post['nama_kelas'] ?? null,
        ]);

        return redirect()->to('/kelas')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    // form edit
    public function edit($id)
    {
        $data['kelas'] = $this->kelas->find($id);

        $data['guru'] = $this->guru->findAll();
        $data['pendidikan'] = $this->pendidikan->findAll();

        if (! $data['kelas']) {
            return redirect()->to('/kelas')->with('error', 'Data kelas tidak ditemukan.');
        }

        return view('Kelas/edit', $data);
    }

    // update
    public function update($id)
    {
        $rules = [
            'nama_kelas' => 'required|max_length[50]',
            'id_pendidikan' => 'required|integer',
            'id_guru' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lengkapi data kelas dengan benar.');
        }

        $post = $this->request->getPost();

        $this->kelas->update($id, [
            'nama_kelas' => $post['nama_kelas'] ?? null,
            'id_pendidikan' => $post['id_pendidikan'] ?? null,
            'id_guru' => $post['id_guru'] ?? null,
        ]);

        return redirect()->to('/kelas')->with('success', 'Data kelas berhasil diperbarui.');
    }

    // hapus
    public function hapus($id)
    {
        $this->kelas->delete($id);

        return redirect()->to('/kelas')->with('success', 'Data kelas berhasil dihapus.');
    }

    public function getGuru($id_kelas)
    {
        $guru = $this->kelas
            ->select('guru.id, guru.nama_guru')
            ->join('guru', 'guru.id = kelas.id_guru')
            ->where('kelas.id_kelas', $id_kelas)
            ->first();

        return $this->response->setJSON($guru);
    }
}
