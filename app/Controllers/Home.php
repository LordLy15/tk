<?php namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\SiswaModel;

class Home extends BaseController {
    public function index() {
        $guru = new GuruModel();
        $siswa = new SiswaModel();
        
        $data = [
            'total_guru' => $guru->findAll(),
            'total_siswa' => $siswa->findAll(),
            'title' => 'Beranda - Dashboard Publik'
        ];
        
        return view('home', $data);
    }
}