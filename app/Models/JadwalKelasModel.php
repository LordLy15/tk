<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalKelasModel extends Model
{
    protected $table = 'jadwal_kelas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_kelas', 'hari', 'jam_masuk', 'jam_keluar', 'aktivitas', 'ruangan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getJadwalByKelas($id_kelas)
    {
        return $this->where('id_kelas', $id_kelas)->orderBy('hari', 'ASC')->findAll();
    }

    public function getJadwalByHari($hari)
    {
        return $this->where('hari', $hari)->get()->getResultArray();
    }
}
