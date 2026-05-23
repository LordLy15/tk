<?php

namespace App\Models;

use CodeIgniter\Model;

class MuridModel extends Model
{
    protected $table = 'murid';

    protected $primaryKey = 'id';

    protected $allowedFields = [

        'id_kelas',
        'nisn',
        'nama_murid',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'foto_murid',

    ];
}
