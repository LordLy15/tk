<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_users';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_role',
        'username',
        'email',
        'password',
        'nama_lengkap',
        'status',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function findForLogin(string $identifier): ?array
    {
        return $this->select('users.*, role.nama_role')
            ->join('role', 'role.id_role = users.id_role', 'left')
            ->groupStart()
                ->where('users.username', $identifier)
                ->orWhere('users.email', $identifier)
            ->groupEnd()
            ->first();
    }
}
