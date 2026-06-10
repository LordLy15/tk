<?php

namespace App\Controllers;

use App\Models\PendidikanModel;

class Pendidikan extends BaseController
{
    protected $pendidikan;

    public function __construct()
    {
        $this->pendidikan = new PendidikanModel();
    }

    // tampil data
    public function index()
    {
        $data['pendidikan'] = $this->pendidikan->findAll();

        return view('Pendidikan/index', $data);
    }


    // form tambah
    public function tambah()
    {
        return view('Pendidikan/tambah');
    }

    // simpan
    public function simpan()
    {
        if (! $this->validate(['nama' => 'required|max_length[100]'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama pendidikan wajib diisi.');
        }

        $this->pendidikan->save([
            'nama' => $this->request->getPost('nama'),
        ]);

        return redirect()->to('/pendidikan')->with('success', 'Data pendidikan berhasil ditambahkan.');
    }

    // form edit
    public function edit($id)
    {
        $data['pendidikan'] = $this->pendidikan->find($id);

        if (! $data['pendidikan']) {
            return redirect()->to('/pendidikan')->with('error', 'Data pendidikan tidak ditemukan.');
        }

        return view('Pendidikan/edit', $data);
    }

    // update
    public function update($id)
    {
        if (! $this->validate(['nama' => 'required|max_length[100]'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama pendidikan wajib diisi.');
        }

        $this->pendidikan->update($id, [
            'nama' => $this->request->getPost('nama'),
        ]);

        return redirect()->to('/pendidikan')->with('success', 'Data pendidikan berhasil diperbarui.');
    }

    // hapus
    public function hapus($id)
    {
        $this->pendidikan->delete($id);

        return redirect()->to('/pendidikan')->with('success', 'Data pendidikan berhasil dihapus.');
    }
}
