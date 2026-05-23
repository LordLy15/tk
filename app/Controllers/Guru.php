<?php

namespace App\Controllers;

use App\Models\GuruModel;

class Guru extends BaseController
{
    private const FOTO_FIELD = 'foto_guru';
    private const FOTO_DIRECTORY = 'foto_guru';

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

        if ($this->hasUploadedFile(self::FOTO_FIELD)) {
            $rules[self::FOTO_FIELD] = $this->profilePhotoValidationRule(self::FOTO_FIELD, 'Foto guru');
        }

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lengkapi data guru dengan benar.');
        }

        $post = $this->request->getPost();
        $fotoGuru = $this->storeUploadedProfilePhoto(self::FOTO_FIELD, self::FOTO_DIRECTORY);

        $data = [
            'nama_guru' => $post['nama_guru'] ?? null,
            'nip_nik' => $post['nip_nik'] ?? null,
            'jabatan' => $post['jabatan'] ?? null,
            'pendidikan' => $post['pendidikan'] ?? null,
        ];

        if ($fotoGuru !== null) {
            $data[self::FOTO_FIELD] = $fotoGuru;
        }

        $this->guru->save($data);

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
        $guru = $this->guru->find($id);

        if (! $guru) {
            return redirect()->to('/guru')->with('error', 'Data guru tidak ditemukan.');
        }

        $rules = [
            'nama_guru' => 'required|max_length[100]',
            'nip_nik' => 'required|numeric|max_length[18]',
            'jabatan' => 'required|max_length[100]',
            'pendidikan' => 'required|max_length[100]',
        ];

        if ($this->hasUploadedFile(self::FOTO_FIELD)) {
            $rules[self::FOTO_FIELD] = $this->profilePhotoValidationRule(self::FOTO_FIELD, 'Foto guru');
        }

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lengkapi data guru dengan benar.');
        }

        $post = $this->request->getPost();
        $fotoGuru = $this->storeUploadedProfilePhoto(self::FOTO_FIELD, self::FOTO_DIRECTORY);

        $data = [
            'nama_guru' => $post['nama_guru'] ?? null,
            'nip_nik' => $post['nip_nik'] ?? null,
            'jabatan' => $post['jabatan'] ?? null,
            'pendidikan' => $post['pendidikan'] ?? null,
        ];

        if ($fotoGuru !== null) {
            $this->deleteUploadedProfilePhoto($guru[self::FOTO_FIELD] ?? null, self::FOTO_DIRECTORY);
            $data[self::FOTO_FIELD] = $fotoGuru;
        }

        $this->guru->update($id, $data);

        return redirect()->to('/guru')->with('success', 'Data guru berhasil diperbarui.');
    }

    // hapus
    public function hapus($id)
    {
        $guru = $this->guru->find($id);

        if (! $guru) {
            return redirect()->to('/guru')->with('error', 'Data guru tidak ditemukan.');
        }

        $this->deleteUploadedProfilePhoto($guru[self::FOTO_FIELD] ?? null, self::FOTO_DIRECTORY);
        $this->guru->delete($id);

        return redirect()->to('/guru')->with('success', 'Data guru berhasil dihapus.');
    }
}
