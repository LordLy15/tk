<?php

namespace App\Models;

use CodeIgniter\Model;

class PengumumanModel extends Model
{
    protected $table = 'pengumuman';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'konten', 'tanggal_mulai', 'tanggal_selesai', 'prioritas', 'status', 'created_by'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPengumumanAktif()
    {
        $today = date('Y-m-d');
        return $this->where('status', 'aktif')
            ->where('tanggal_mulai <=', $today)
            ->where('tanggal_selesai >=', $today)
            ->orderBy('prioritas', 'DESC')
            ->findAll();
    }

    public function getPengumumanByPrioritas($prioritas)
    {
        return $this->where('prioritas', $prioritas)->findAll();
    }
}
