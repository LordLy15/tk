<?php namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\MuridModel;

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
}