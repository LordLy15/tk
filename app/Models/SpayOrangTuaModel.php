<?php

namespace App\Models;

use CodeIgniter\Model;

class SpayOrangTuaModel extends Model
{
    protected $table      = 'spay_orang_tua';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama','email','password','no_hp','nama_siswa','kelas','is_active','created_at','updated_at'];
}