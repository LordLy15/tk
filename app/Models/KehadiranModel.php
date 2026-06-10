<?php

namespace App\Models;

use CodeIgniter\Model;

class KehadiranModel extends Model
{
    protected $table = 'kehadiran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_murid', 'id_kelas', 'tanggal', 'status', 'keterangan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getKehadiranByKelas($id_kelas, $tanggal)
    {
        return $this->select('kehadiran.*, murid.nama_murid')
            ->where('kehadiran.id_kelas', $id_kelas)
            ->where('kehadiran.tanggal', $tanggal)
            ->join('murid', 'murid.id = kehadiran.id_murid')
            ->get()->getResultArray();
    }

    public function getKehadiranByMurid($id_murid, $bulan = null, $tahun = null)
    {
        $query = $this->where('id_murid', $id_murid);
        
        if ($bulan && $tahun) {
            $query->where('MONTH(tanggal)', $bulan)
                  ->where('YEAR(tanggal)', $tahun);
        }
        
        return $query->orderBy('tanggal', 'DESC')->get()->getResultArray();
    }
}
