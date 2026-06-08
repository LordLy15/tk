<?php

namespace App\Controllers\OrangTua;

use App\Controllers\BaseController;
use App\Models\SpayPembayaranModel;
use App\Models\SeBookEbookModel;

class PembayaranController extends BaseController
{
    protected $pembayaranModel;
    protected $ebookModel;

    public function __construct()
    {
        $this->pembayaranModel = new SpayPembayaranModel();
        $this->ebookModel = new SeBookEbookModel();
    }

    public function dashboard()
    {
        $id = session()->get('orangtua_id');
        $data['stats'] = $this->pembayaranModel->getStatsByOrangTua($id);
        $data['tagihan_aktif'] = $this->pembayaranModel->getTagihanByOrangTua($id, 'pending');
        $data['tagihan_terbaru'] = array_slice($this->pembayaranModel->getTagihanByOrangTua($id), 0, 3);
        $data['ebooks'] = $this->ebookModel->getLatestEbooks(4);
        return view('orangtua/dashboard', $data);
    }

    public function index()
    {
        $id = session()->get('orangtua_id');
        $status = $this->request->getGet('status');
        $data['tagihan'] = $this->pembayaranModel->getTagihanByOrangTua($id, $status ?: null);
        $data['filter_status'] = $status;
        return view('orangtua/pembayaran/index', $data);
    }

    public function detail($id)
    {
        $orangTuaId = session()->get('orangtua_id');
        $data['tagihan'] = $this->pembayaranModel->getDetailTagihan($id, $orangTuaId);

        if (!$data['tagihan']) {
            return redirect()->to('/orangtua/pembayaran')
                ->with('error', 'Tagihan tidak ditemukan.');
        }
        return view('orangtua/pembayaran/detail', $data);
    }

    public function uploadBukti($tagihanId)
    {
        $file = $this->request->getFile('bukti_bayar');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Format file harus JPG, PNG, atau PDF.');
        }

        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file->getSize() > $maxSize) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 5MB.');
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/bukti_bayar', $newName);

        $this->pembayaranModel->simpanPembayaran([
            'tagihan_id'    => $tagihanId,
            'orang_tua_id'  => session()->get('orangtua_id'),
            'bukti_bayar'   => $newName,
            'tanggal_bayar' => date('Y-m-d'),
            'status'        => 'pending',
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/orangtua/pembayaran')
            ->with('success', 'Bukti pembayaran berhasil dikirim, menunggu verifikasi admin.');
    }
}