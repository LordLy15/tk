<?php namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table      = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    
    // Field yang diizinkan untuk diisi
    protected $allowedFields = [
        'nama_siswa', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 
        'nama_ayah', 'nama_ibu', 'no_hp', 'alamat', 'akta_kelahiran'
    ];
    
    protected $useTimestamps = false; 
}