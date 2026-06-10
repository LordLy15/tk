<?php

namespace App\Models;

use CodeIgniter\Model;

class AktivitasModel extends Model
{
    protected $table = 'aktivitas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul_aktivitas', 'deskripsi', 'jenis_aktivitas', 'kategori', 'tujuan', 'metode', 'durasi_menit', 'bahan_alat'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAktivitasByKategori($kategori)
    {
        return $this->where('kategori', $kategori)->findAll();
    }

    public function getAktivitasByJenis($jenis)
    {
        return $this->where('jenis_aktivitas', $jenis)->findAll();
    }
}
