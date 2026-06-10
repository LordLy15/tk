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
        $data['pembayaran'] = $this->model->getAllPembayaran();
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