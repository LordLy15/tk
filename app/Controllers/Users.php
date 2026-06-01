<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GuruModel;
use Config\Database;

class Users extends BaseController
{
    protected $userModel;
    protected $guruModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $db = Database::connect();
        
        $users = $this->userModel
            ->select('users.*, role.nama_role, guru.nama_guru')
            ->join('role', 'role.id_role = users.id_role', 'left')
            ->join('guru', 'guru.id = users.id_guru', 'left')
            ->orderBy('users.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Manajemen Pengguna & Hak Akses',
            'users' => $users
        ];

        return view('Users/index', $data);
    }

    public function tambah()
    {
        $db = Database::connect();
        $roles = $db->table('role')->get()->getResultArray();
        $gurus = $this->guruModel->orderBy('nama_guru', 'ASC')->findAll();

        $data = [
            'title' => 'Tambah Pengguna Baru',
            'roles' => $roles,
            'gurus' => $gurus,
            'user'  => null
        ];

        return view('Users/form', $data);
    }

    public function simpan()
    {
        $rules = [
            'username'     => 'required|alpha_numeric_space|min_length[3]|max_length[25]|is_unique[users.username]',
            'email'        => 'required|valid_email|max_length[30]|is_unique[users.email]',
            'nama_lengkap' => 'required|max_length[100]',
            'id_role'      => 'required|integer',
            'password'     => 'required|min_length[4]|max_length[255]',
            'status'       => 'required|in_list[aktif,nonaktif]'
        ];

        if (! $this->validate($rules)) {
        $errors = $this->validator->getErrors();
        $errorMsg = implode(' | ', $errors);
        return redirect()->back()->withInput()->with('error', $errorMsg);
    }

        $post = $this->request->getPost();
        
        // Validation: If role is Guru (4), id_guru is required and must be unique
        $id_role = (int) $post['id_role'];
        $id_guru = !empty($post['id_guru']) ? (int) $post['id_guru'] : null;

            // Deteksi role Guru berdasarkan nama, bukan hardcode ID
        $db = Database::connect();
        $roleData = $db->table('role')->where('id_role', $id_role)->get()->getRowArray();
        $isGuru = $roleData && strtolower(trim($roleData['nama_role'])) === 'guru';

        if ($isGuru) {
            if (!$id_guru) {
                return redirect()->back()->withInput()
                    ->with('error', 'Untuk peran Guru, Anda wajib memilih data Guru terkait.');
            }
            // Cek apakah guru sudah terhubung ke akun lain (pada insert cukup cek keberadaan saja)
            $existing = $this->userModel->where('id_guru', $id_guru)->first();
            if ($existing) {
                return redirect()->back()->withInput()
                    ->with('error', 'Guru yang dipilih sudah terhubung dengan akun pengguna lain.');
            }
        } else {
            $id_guru = null;
        }

        $dataSave = [
            'id_role'      => $id_role,
            'id_guru'      => $id_guru,
            'username'     => trim($post['username']),
            'email'        => trim($post['email']),
            'nama_lengkap' => trim($post['nama_lengkap']),
            'password'     => password_hash($post['password'], PASSWORD_DEFAULT),
            'status'       => $post['status']
        ];

        if ($this->userModel->insert($dataSave)) {
            $this->logActivity('Menambahkan akun pengguna baru: ' . $post['username'], 'Manajemen Pengguna');
            return redirect()->to('/admin/users')->with('success', 'Akun pengguna berhasil ditambahkan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan akun pengguna.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Akun pengguna tidak ditemukan.');
        }

        $db = Database::connect();
        $roles = $db->table('role')->get()->getResultArray();
        $gurus = $this->guruModel->orderBy('nama_guru', 'ASC')->findAll();

        $data = [
            'title' => 'Edit Akun Pengguna',
            'roles' => $roles,
            'gurus' => $gurus,
            'user'  => $user
        ];

        return view('Users/form', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Akun pengguna tidak ditemukan.');
        }

        $rules = [
            'username'     => "required|alpha_numeric_space|min_length[3]|max_length[25]|is_unique[users.username,id_users,{$id}]",
            'email'        => "required|valid_email|max_length[30]|is_unique[users.email,id_users,{$id}]",
            'nama_lengkap' => 'required|max_length[100]',
            'id_role'      => 'required|integer',
            'status'       => 'required|in_list[aktif,nonaktif]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Lengkapi data formulir dengan benar.');
        }

        $post = $this->request->getPost();
        
        // Validation: If role is Guru (4), id_guru is required and must be unique
        $id_role = (int) $post['id_role'];
        $id_guru = !empty($post['id_guru']) ? (int) $post['id_guru'] : null;

                // Deteksi role Guru berdasarkan nama, bukan hardcode ID
        $db = Database::connect();
        $roleData = $db->table('role')->where('id_role', $id_role)->get()->getRowArray();
        $isGuru = $roleData && strtolower(trim($roleData['nama_role'])) === 'guru';

        if ($isGuru) {
            if (!$id_guru) {
                return redirect()->back()->withInput()
                    ->with('error', 'Untuk peran Guru, Anda wajib memilih data Guru terkait.');
            }
            // Cek apakah guru sudah terhubung ke akun lain
            $existing = $this->userModel->where('id_guru', $id_guru)
                             ->where('id_users !=', $id)
                             ->first();
            if ($existing) {
                return redirect()->back()->withInput()
                    ->with('error', 'Guru yang dipilih sudah terhubung dengan akun pengguna lain.');
            }
        } else {
            $id_guru = null;
        }

        $dataUpdate = [
            'id_role'      => $id_role,
            'id_guru'      => $id_guru,
            'username'     => trim($post['username']),
            'email'        => trim($post['email']),
            'nama_lengkap' => trim($post['nama_lengkap']),
            'status'       => $post['status']
        ];

        // If password is filled, update password
        if (!empty($post['password'])) {
            if (strlen($post['password']) < 4) {
                return redirect()->back()->withInput()->with('error', 'Password minimal terdiri dari 4 karakter.');
            }
            $dataUpdate['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }

        if ($this->userModel->update($id, $dataUpdate)) {
            $this->logActivity('Memperbarui akun pengguna: ' . $post['username'], 'Manajemen Pengguna');
            
            // If the user updated their own account, update session!
            if ((int)session('id_users') === (int)$id) {
                $db = Database::connect();
                $updatedUser = $this->userModel->findForLogin($post['username']);
                if ($updatedUser) {
                    session()->set([
                        'nama'         => $updatedUser['nama_lengkap'],
                        'nama_lengkap' => $updatedUser['nama_lengkap'],
                        'id_guru'      => $updatedUser['id_guru'] ? (int) $updatedUser['id_guru'] : null,
                        'role'         => $updatedUser['nama_role'],
                        'role_key'     => strtolower($updatedUser['nama_role']),
                    ]);
                }
            }

            return redirect()->to('/admin/users')->with('success', 'Akun pengguna berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui akun pengguna.');
    }

    public function hapus($id)
    {
        // Cannot delete own account
        if ((int)session('id_users') === (int)$id) {
            return redirect()->to('/admin/users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Akun pengguna tidak ditemukan.');
        }

        if ($this->userModel->delete($id)) {
            $this->logActivity('Menghapus akun pengguna: ' . $user['username'], 'Manajemen Pengguna');
            return redirect()->to('/admin/users')->with('success', 'Akun pengguna berhasil dihapus.');
        }

        return redirect()->to('/admin/users')->with('error', 'Gagal menghapus akun pengguna.');
    }
}
