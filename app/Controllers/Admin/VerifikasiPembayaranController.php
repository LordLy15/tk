<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SpayPembayaranModel;

class VerifikasiPembayaranController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SpayPembayaranModel();
    }

    public function index()
    {
        $searchSiswa = $this->request->getGet('search_siswa');
        $searchKelas = $this->request->getGet('search_kelas');

        $data['pembayaran'] = $this->model->getAllPembayaran($searchSiswa, $searchKelas);
        $data['search_siswa'] = $searchSiswa;
        $data['search_kelas'] = $searchKelas;

        // Get distinct classes for the filter dropdown
        $db = \Config\Database::connect();
        $data['kelas_list'] = $db->table('spay_orang_tua')
            ->select('kelas')->distinct()
            ->where('kelas IS NOT NULL')
            ->where('kelas !=', '')
            ->where('is_active', 1)
            ->orderBy('kelas', 'ASC')
            ->get()->getResultArray();

        return view('Admin/pembayaran/index', $data);
    }

    public function detail($id)
    {
        $data['pembayaran'] = $this->model->getPembayaranDetail($id);
        if (!$data['pembayaran']) {
            return redirect()->to('/admin/verifikasi-pembayaran')
                ->with('error', 'Data tidak ditemukan.');
        }
        return view('Admin/pembayaran/verifikasi', $data);
    }

    public function proses($id)
    {
        $status  = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        if (!in_array($status, ['verified', 'rejected'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $this->model->updateStatus($id, $status, $catatan);

        $msg = $status === 'verified'
            ? 'Pembayaran berhasil diverifikasi.'
            : 'Pembayaran ditolak.';
        return redirect()->to('/admin/verifikasi-pembayaran')->with('success', $msg);
    }
}