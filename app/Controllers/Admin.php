<?php

namespace App\Controllers;

use Config\Database;

class Admin extends BaseController
{
    public function index()
    {
        $today = date('Y-m-d');
        $requiredTables = [
            'aktivitas',
            'fasilitas_sekolah',
            'kehadiran',
            'pengumuman',
            'pendaftaran', // <-- Ditambahkan ke pengecekan tabel
        ];

        $data = [
            'total_murid' => $this->countRows('murid'),
            'total_guru' => $this->countRows('guru'),
            'total_kelas' => $this->countRows('kelas'),
            'total_aktivitas' => $this->countRows('aktivitas'),
            'total_fasilitas' => $this->countRows('fasilitas_sekolah'),
            'total_pendaftar' => $this->countRows('pendaftaran'), // <-- Ditambahkan untuk Dashboard
            'pengumuman_aktif' => $this->getPengumumanAktif($today),
            'fasilitas_status' => $this->getRekapFasilitas(),
            'kehadiran_hari_ini' => $this->countRows('kehadiran', ['tanggal' => $today]),
            'missing_tables' => array_values(array_filter(
                $requiredTables,
                fn ($table) => ! $this->tableExists($table)
            )),
        ];

        return view('Admin/home', $data);
    }

    // ==========================================
    // FUNGSI UNTUK HALAMAN DATA PENDAFTARAN
    // ==========================================
    public function pendaftaran()
    {
        $pendaftaranModel = new \App\Models\PendaftaranModel();
        $data = [
            'title'       => 'Data Pendaftaran - Admin RA Perwanida',
            'pendaftaran' => $pendaftaranModel->orderBy('created_at', 'DESC')->findAll()
        ];

        
        return view('Admin/Pendaftaran/index', $data); 
    }

    // ==========================================
    // PRIVATE METHODS (FUNGSI BANTUAN)
    // ==========================================
    private function countRows(string $table, array $where = []): int
    {
        if (! $this->tableExists($table)) {
            return 0;
        }

        $builder = Database::connect()->table($table);

        foreach ($where as $field => $value) {
            $builder->where($field, $value);
        }

        return (int) $builder->countAllResults();
    }

    private function getPengumumanAktif(string $today): array
    {
        if (! $this->tableExists('pengumuman')) {
            return [];
        }

        return Database::connect()
            ->table('pengumuman')
            ->where('status', 'aktif')
            ->where('tanggal_mulai <=', $today)
            ->where('tanggal_selesai >=', $today)
            ->orderBy('prioritas', 'DESC')
            ->get()
            ->getResultArray();
    }

    private function getRekapFasilitas(): array
    {
        return [
            'total' => $this->countRows('fasilitas_sekolah'),
            'baik' => $this->countRows('fasilitas_sekolah', ['kondisi' => 'baik']),
            'cukup' => $this->countRows('fasilitas_sekolah', ['kondisi' => 'cukup']),
            'rusak' => $this->countRows('fasilitas_sekolah', ['kondisi' => 'rusak']),
        ];
    }
    
    private function tableExists(string $table): bool
    {
        return Database::connect()->tableExists($table);
    }
}