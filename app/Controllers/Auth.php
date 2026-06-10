<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Events\Events;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->redirectForRole((string) session()->get('role')));
        }

        return view('auth/login', [
            'title' => 'Login Admin - RA PERWANIDA',
        ]);
    }

    public function login()
    {
        $identifier = trim((string) ($this->request->getPost('login') ?: $this->request->getPost('username')));
        $password = (string) $this->request->getPost('password');

        if ($identifier === '' || $password === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Isi username/email dan password terlebih dahulu.');
        }

        $userModel = new UserModel();
        $user = $userModel->findForLogin($identifier);

        if (! $user || ! $this->passwordMatches($password, (string) ($user['password'] ?? ''))) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username/email atau password salah.');
        }

        if (($user['status'] ?? '') !== 'aktif') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Akun ini sedang nonaktif. Hubungi Administrator.');
        }

        if ($this->passwordNeedsUpgrade((string) $user['password'])) {
            $userModel->update((int) $user['id_users'], [
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
        }

        $session = session();
        $session->regenerate(true);

        $role = (string) ($user['nama_role'] ?? 'Staff');

        $session->set([
            'isLoggedIn'  => true,
            'id'          => (int) $user['id_users'],
            'user_id'     => (int) $user['id_users'],
            'id_users'    => (int) $user['id_users'],
            'id_role'     => (int) ($user['id_role'] ?? 0),
            'id_guru'     => $user['id_guru'] ? (int) $user['id_guru'] : null,
            'username'    => $user['username'],
            'nama'        => $user['nama_lengkap'],
            'nama_lengkap' => $user['nama_lengkap'],
            'role'        => $role,
            'role_key'    => strtolower($role),
        ]);

        Events::trigger('login', $user);

        $redirectUrl = $session->get('redirect_url');
        $session->remove('redirect_url');

        if ($this->isSafeRedirect($redirectUrl)) {
            return redirect()->to($redirectUrl);
        }

        return redirect()->to($this->redirectForRole($role))
            ->with('success', 'Selamat datang, ' . $user['nama_lengkap'] . '.');
    }

    public function logout()
    {
        $userId = session()->get('user_id');

        Events::trigger('logout', $userId);
        session()->destroy();

        return redirect()->to(base_url('login'))->with('success', 'Anda berhasil logout.');
    }

    private function passwordMatches(string $plainPassword, string $storedPassword): bool
    {
        if ($storedPassword === '') {
            return false;
        }

        if ((password_get_info($storedPassword)['algo'] ?? 0) !== 0) {
            return password_verify($plainPassword, $storedPassword);
        }

        return hash_equals($storedPassword, $plainPassword);
    }

    private function passwordNeedsUpgrade(string $storedPassword): bool
    {
        if ((password_get_info($storedPassword)['algo'] ?? 0) === 0) {
            return true;
        }

        return password_needs_rehash($storedPassword, PASSWORD_DEFAULT);
    }

    private function redirectForRole(string $role): string
    {
        return base_url('admin');
    }

    private function isSafeRedirect(mixed $url): bool
    {
        if (! is_string($url) || $url === '') {
            return false;
        }

        $path = parse_url($url, PHP_URL_PATH) ?: '';
        $host = parse_url($url, PHP_URL_HOST);
        $baseHost = parse_url(base_url(), PHP_URL_HOST);

        if ($host !== null && $host !== $baseHost) {
            return false;
        }

        return ! str_contains($path, '/login') && ! str_contains($path, '/logout');
    }
}
