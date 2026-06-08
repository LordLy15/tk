<?php

namespace App\Models;

use CodeIgniter\Model;

class SeBookEbookModel extends Model
{
    protected $table      = 'sebook_ebook';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul','deskripsi','penulis','kategori','cover','file_path','kelas','is_active','created_by','created_at','updated_at'];

    public function getKategoriList()
    {
        return $this->db->table('sebook_ebook')
            ->select('kategori')->distinct()
            ->where('is_active', 1)
            ->where('kategori IS NOT NULL')
            ->get()->getResultArray();
    }

    public function getLatestEbooks($limit = 4)
    {
        return $this->where('is_active', 1)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}