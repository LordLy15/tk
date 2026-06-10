<?php

namespace App\Models;

use CodeIgniter\Model;

class OrangTuaModel extends Model
{
    protected $table = 'orang_tua';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_murid',
        'nama_ayah',
        'no_hp_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'no_hp_ibu',
        'pekerjaan_ibu',
        'alamat',
        'email'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'id_murid' => 'required|integer',
        'nama_ayah' => 'required|string|max_length[100]',
        'no_hp_ayah' => 'required|string|max_length[15]',
        'pekerjaan_ayah' => 'string|max_length[100]',
        'nama_ibu' => 'required|string|max_length[100]',
        'no_hp_ibu' => 'required|string|max_length[15]',
        'pekerjaan_ibu' => 'string|max_length[100]',
        'alamat' => 'required|string',
        'email' => 'valid_email|max_length[100]'
    ];
    protected $validationMessages = [
        'id_murid' => [
            'required' => 'Pilih siswa terlebih dahulu',
            'integer' => 'ID siswa harus berupa angka'
        ],
        'nama_ayah' => [
            'required' => 'Nama ayah tidak boleh kosong',
            'max_length' => 'Nama ayah maksimal 100 karakter'
        ],
        'no_hp_ayah' => [
            'required' => 'Nomor HP ayah tidak boleh kosong',
            'max_length' => 'Nomor HP ayah maksimal 15 karakter'
        ],
        'nama_ibu' => [
            'required' => 'Nama ibu tidak boleh kosong',
            'max_length' => 'Nama ibu maksimal 100 karakter'
        ],
        'no_hp_ibu' => [
            'required' => 'Nomor HP ibu tidak boleh kosong',
            'max_length' => 'Nomor HP ibu maksimal 15 karakter'
        ],
        'alamat' => [
            'required' => 'Alamat tidak boleh kosong'
        ],
        'email' => [
            'valid_email' => 'Email tidak valid',
            'max_length' => 'Email maksimal 100 karakter'
        ]
    ];

    public function getMuridWithOrangTua()
    {
        return $this->select('orang_tua.*, murid.nama_murid')
            ->join('murid', 'murid.id = orang_tua.id_murid')
            ->orderBy('orang_tua.created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function getOrangTuaByMurid($muridId)
    {
        return $this->where('id_murid', $muridId)->first();
    }
}
