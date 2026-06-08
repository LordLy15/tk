<?php

namespace App\Controllers\OrangTua;

use App\Controllers\BaseController;
use App\Models\SpayOrangTuaModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('orangtua_logged_in')) {
            return redirect()->to('/orangtua/dashboard');
        }
        return view('orangtua/auth/login');
    }

    public function loginProses()
    {
        $model = new SpayOrangTuaModel();
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)
                      ->where('is_active', 1)
                      ->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'orangtua_logged_in' => true,
                'orangtua_id'        => $user['id'],
                'orangtua_nama'      => $user['nama'],
                'orangtua_nama_siswa'=> $user['nama_siswa'] ?? '',
            ]);
            return redirect()->to('/orangtua/dashboard');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Email atau password salah.');
    }

    public function logout()
    {
        session()->remove(['orangtua_logged_in', 'orangtua_id', 'orangtua_nama', 'orangtua_nama_siswa']);
        return redirect()->to('/orangtua/login');
    }
}