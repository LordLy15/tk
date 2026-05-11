<?php namespace App\Controllers;
use App\Models\GuruModel;

class Auth extends BaseController {
    public function index() { return view('auth/login'); }

    public function login() {
        $session = session();
        $model = new GuruModel();
        $user = $model->where('username', $this->request->getVar('username'))->first();
        
        if($user && password_verify($this->request->getVar('password'), $user['password'])) {
            $session->set(['id' => $user['id'], 'nama' => $user['nama_guru'], 'isLoggedIn' => true]);
            return redirect()->to('/dashboard');
        }
        return redirect()->back()->with('error', 'Login Gagal!');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}