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
        return view('OrangTua/auth/login');
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

    public function ubahPassword()
    {
        return view('OrangTua/auth/ubah-password');
    }

    public function simpanPassword()
    {
        $model = new SpayOrangTuaModel();
        $id = session()->get('orangtua_id');

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');
        $konfirmasi = $this->request->getPost('konfirmasi_password');

        // Validasi
        if (strlen($passwordBaru) < 6) {
            return redirect()->back()->with('error', 'Password baru minimal 6 karakter.');
        }

        if ($passwordBaru !== $konfirmasi) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        // Cek password lama
        $user = $model->find($id);
        if (!$user || !password_verify($passwordLama, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        // Update password
        $model->update($id, [
            'password'   => password_hash($passwordBaru, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/orangtua/dashboard')->with('success', 'Password berhasil diubah.');
    }
}