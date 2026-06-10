<?php namespace App\Controllers;
use App\Models\SiswaModel;
use App\Models\GuruModel;

class Dashboard extends BaseController {
    
    public function index() {
        $siswa = new SiswaModel();
        $guru = new GuruModel();
        $data = [
            'siswa' => $siswa->findAll(),
            'guru' => $guru->findAll(),
            'title' => 'Dashboard Guru'
        ];
        return view('guru/dashboard', $data);
    }

    // CRUD SISWA
    public function saveSiswa() {
        $model = new SiswaModel();
        $model->save([
            'nama_siswa' => $this->request->getVar('nama_siswa'),
            'nisn' => $this->request->getVar('nisn'),
            'kelas' => $this->request->getVar('kelas'),
        ]);
        return redirect()->to('/dashboard');
    }

    public function deleteSiswa($id) {
        (new SiswaModel())->delete($id);
        return redirect()->to('/dashboard');
    }

    // CRUD GURU
    public function saveGuru() {
        $model = new GuruModel();
        $model->save([
            'nama_guru' => $this->request->getVar('nama_guru'),
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ]);
        return redirect()->to('/dashboard');
    }
}