<?php

namespace App\Models;

use CodeIgniter\Model;

class LiburSekolahModel extends Model
{
    protected $table = 'libur_sekolah';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_libur', 'tanggal_mulai', 'tanggal_selesai', 'keterangan', 'jenis_libur', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getLiburAktif()
    {
        return $this->where('status', 'aktif')->orderBy('tanggal_mulai', 'ASC')->findAll();
    }

    public function cekTanggalLibur($tanggal)
    {
        return $this->where('status', 'aktif')
            ->where('tanggal_mulai <=', $tanggal)
            ->where('tanggal_selesai >=', $tanggal)
            ->first();
    }
}
