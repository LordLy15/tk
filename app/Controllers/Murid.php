<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\MuridModel;
use App\Models\PendidikanModel;

class Murid extends BaseController
{
    private const FOTO_FIELD = 'foto_murid';
    private const FOTO_DIRECTORY = 'foto_murid';

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

        if ($this->hasUploadedFile(self::FOTO_FIELD)) {
            $rules[self::FOTO_FIELD] = $this->profilePhotoValidationRule(self::FOTO_FIELD, 'Foto murid');
        }

        if (! $this->validate($rules)) {
            $errors = implode('<br>', $this->validator->getErrors());
            return redirect()->back()
                ->withInput()
                ->with('error', $errors ?: 'Lengkapi data murid dengan benar.');
        }

        $post = $this->request->getPost();
        $fotoMurid = $this->storeUploadedProfilePhoto(self::FOTO_FIELD, self::FOTO_DIRECTORY);

        $data = [
            'id_kelas' => $post['id_kelas'] ?? null,
            'nisn' => $post['nisn'] ?? null,
            'nama_murid' => $post['nama_murid'] ?? null,
            'jenis_kelamin' => $post['jenis_kelamin'] ?? null,
            'tempat_lahir' => $post['tempat_lahir'] ?? null,
            'tanggal_lahir' => $post['tanggal_lahir'] ?? null,
            'alamat' => tk_compose_address_from_post($post),
        ];

        if ($fotoMurid !== null) {
            $data[self::FOTO_FIELD] = $fotoMurid;
        }

        $this->murid->save($data);

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
        $murid = $this->murid->find($id_murid);

        if (! $murid) {
            return redirect()->to('/murid')->with('error', 'Data murid tidak ditemukan.');
        }

        $rules = [
            'id_kelas' => 'required|integer',
            'nisn' => 'required|numeric|max_length[20]',
            'nama_murid' => 'required|max_length[100]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'tempat_lahir' => 'required|max_length[100]',
            'tanggal_lahir' => 'required|valid_date',
            'alamat' => 'required',
        ];

        if ($this->hasUploadedFile(self::FOTO_FIELD)) {
            $rules[self::FOTO_FIELD] = $this->profilePhotoValidationRule(self::FOTO_FIELD, 'Foto murid');
        }

        if (! $this->validate($rules)) {
            $errors = implode('<br>', $this->validator->getErrors());
            return redirect()->back()
                ->withInput()
                ->with('error', $errors ?: 'Lengkapi data murid dengan benar.');
        }

        $post = $this->request->getPost();
        $fotoMurid = $this->storeUploadedProfilePhoto(self::FOTO_FIELD, self::FOTO_DIRECTORY);

        $data = [
            'id_kelas' => $post['id_kelas'] ?? null,
            'nisn' => $post['nisn'] ?? null,
            'nama_murid' => $post['nama_murid'] ?? null,
            'jenis_kelamin' => $post['jenis_kelamin'] ?? null,
            'tempat_lahir' => $post['tempat_lahir'] ?? null,
            'tanggal_lahir' => $post['tanggal_lahir'] ?? null,
            'alamat' => tk_compose_address_from_post($post),
        ];

        if ($fotoMurid !== null) {
            $this->deleteUploadedProfilePhoto($murid[self::FOTO_FIELD] ?? null, self::FOTO_DIRECTORY);
            $data[self::FOTO_FIELD] = $fotoMurid;
        }

        $this->murid->update($id_murid, $data);

        return redirect()->to('/murid')->with('success', 'Data murid berhasil diperbarui.');
    }

    // hapus
    public function hapus($id)
    {
        $murid = $this->murid->find($id);

        if (! $murid) {
            return redirect()->to('/murid')->with('error', 'Data murid tidak ditemukan.');
        }

        $this->deleteUploadedProfilePhoto($murid[self::FOTO_FIELD] ?? null, self::FOTO_DIRECTORY);
        $this->murid->delete($id);

        return redirect()->to('/murid')->with('success', 'Data murid berhasil dihapus.');
    }
}
