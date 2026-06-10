<?php namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\MuridModel;
use App\Models\PendaftaranModel; // <-- WAJIB DITAMBAHKAN UNTUK MEMANGGIL MODEL

class Home extends BaseController {
    
    public function index() {
        $guru  = new GuruModel();
        $murid = new MuridModel();
        
        $data = [
            'total_guru'  => $guru->findAll(),
            'total_murid' => $murid->findAll(), // Ubah $siswa menjadi $murid
            'title'       => 'Beranda - Dashboard Publik'
        ];
        
        return view('home', $data);
    }

    public function pendaftaran()
    {
        return view('pendaftaran');
    }

    // ==========================================================
    // LOGIKA PENYIMPANAN DATA KE DATABASE
    // ==========================================================
    public function simpanPendaftaran()
    {
        $pendaftaranModel = new PendaftaranModel();

        // Validasi no_hp harus mulai dengan +62 atau 08
        $noHp = $this->request->getPost('no_hp');
        if ($noHp && !preg_match('/^(\+62|08)/', $noHp)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor HP harus dimulai dengan +62 atau 08.');
        }

        // 1. Mengurus Upload File Akta
        $fileAkta = $this->request->getFile('akta_kelahiran');
        $namaFile = NULL;

        if ($fileAkta && $fileAkta->isValid() && ! $fileAkta->hasMoved()) {
            // Generate nama file random agar tidak bentrok
            $namaFile = $fileAkta->getRandomName();
            // Pindahkan ke folder public/uploads/akta
            $fileAkta->move('uploads/akta', $namaFile);
        }

        // 2. Mengambil data dari form sesuai field di database
        $dataSimpan = [
            'nama_siswa'    => $this->request->getPost('nama_siswa'),
            'tempat_lahir'  => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'nama_ayah'     => $this->request->getPost('nama_ayah'),
            'nama_ibu'      => $this->request->getPost('nama_ibu'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'alamat'        => $this->request->getPost('alamat'),
            'akta_kelahiran'=> $namaFile
        ];

        // 3. Simpan ke database
        $pendaftaranModel->insert($dataSimpan);

        // 4. Kembali ke halaman pendaftaran dengan pesan sukses
        return redirect()->to('/pendaftaran')->with('pesan', 'Formulir pendaftaran berhasil dikirim!');
    }
}