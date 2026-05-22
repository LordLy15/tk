<?php

namespace App\Models;

use CodeIgniter\Model;

class FasilitasSekolahModel extends Model
{
    protected $table = 'fasilitas_sekolah';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_fasilitas', 'jenis_fasilitas', 'jumlah', 'kondisi', 'lokasi', 'catatan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getFasilitasByJenis($jenis)
    {
        return $this->where('jenis_fasilitas', $jenis)->findAll();
    }

    public function getFasilitasByKondisi($kondisi)
    {
        return $this->where('kondisi', $kondisi)->findAll();
    }

    public function getRekapFasilitas()
    {
        return [
            'total' => $this->countAll(),
            'baik' => $this->where('kondisi', 'baik')->countAllResults(),
            'cukup' => $this->where('kondisi', 'cukup')->countAllResults(),
            'rusak' => $this->where('kondisi', 'rusak')->countAllResults()
        ];
    }
}
