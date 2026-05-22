<?php

namespace App\Controllers;

use App\Models\GuruModel;

class Guru extends BaseController
{
    protected $guru;

    public function __construct()
    {
        $this->guru = new GuruModel();
    }

    // tampil data
    public function index()
    {
        $data['guru'] = $this->guru->findAll();

        return view('Guru/index', $data);
    }

    public function detail($id)
    {
        $data['guru'] = $this->guru->find($id);

        if (!$data['guru']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Data guru tidak ditemukan'
            );
        }

        return view('Guru/detail', $data);
    }

    // form tambah
    public function tambah()
    {
        return view('Guru/tambah');
    }

    // simpan
    public function simpan()
    {
        $rules = [
            'nama_guru' => 'required|max_length[100]',
            'nip_nik' => 'required|numeric|max_length[18]',
            'jabatan' => 'required|max_length[100]',
            'pendidikan' => 'required|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lengkapi data guru dengan benar.');
        }

        $post = $this->request->getPost();

        $this->guru->save([
            'nama_guru' => $post['nama_guru'] ?? null,
            'nip_nik' => $post['nip_nik'] ?? null,
            'jabatan' => $post['jabatan'] ?? null,
            'pendidikan' => $post['pendidikan'] ?? null,
        ]);

        return redirect()->to('/guru')->with('success', 'Data guru berhasil ditambahkan.');
    }

    // form edit
    public function edit($id)
    {
        $data['guru'] = $this->guru->find($id);

        if (! $data['guru']) {
            return redirect()->to('/guru')->with('error', 'Data guru tidak ditemukan.');
        }

        return view('Guru/edit', $data);
    }

    // update
    public function update($id)
    {
        $rules = [
            'nama_guru' => 'required|max_length[100]',
            'nip_nik' => 'required|numeric|max_length[18]',
            'jabatan' => 'required|max_length[100]',
            'pendidikan' => 'required|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lengkapi data guru dengan benar.');
        }

        $post = $this->request->getPost();

        $this->guru->update($id, [
            'nama_guru' => $post['nama_guru'] ?? null,
            'nip_nik' => $post['nip_nik'] ?? null,
            'jabatan' => $post['jabatan'] ?? null,
            'pendidikan' => $post['pendidikan'] ?? null,
        ]);

        return redirect()->to('/guru')->with('success', 'Data guru berhasil diperbarui.');
    }

    // hapus
    public function hapus($id)
    {
        $this->guru->delete($id);

        return redirect()->to('/guru')->with('success', 'Data guru berhasil dihapus.');
    }
}
