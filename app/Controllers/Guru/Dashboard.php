<?php namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class Dashboard extends BaseController {
    public function index() {
        $siswaModel = new SiswaModel();
        $data['siswa'] = $siswaModel->findAll(); // Mengambil data siswa
        return view('guru/dashboard', $data);
    }
}