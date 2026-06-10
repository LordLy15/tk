<?php

namespace App\Models;

use CodeIgniter\Model;

class AktivitasKelasModel extends Model
{
    protected $table = 'aktivitas_kelas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_aktivitas', 'id_kelas', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'hasil_pembelajaran', 'catatan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAktivitasKelasWithDetail($id_kelas, $tanggal = null)
    {
        $query = $this->select('aktivitas_kelas.*, aktivitas.judul_aktivitas')
            ->where('id_kelas', $id_kelas)
            ->join('aktivitas', 'aktivitas.id = aktivitas_kelas.id_aktivitas');
        
        if ($tanggal) {
            $query->where('aktivitas_kelas.tanggal', $tanggal);
        }
        
        return $query->get()->getResultArray();
    }
}
