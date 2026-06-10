<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SpayOrangTuaModel;
use App\Models\SpayPembayaranModel;

class SpayTagihanController extends BaseController
{
    protected $model;
    protected $orangTuaModel;

    public function __construct()
    {
        $this->model = new SpayPembayaranModel();
        $this->orangTuaModel = new SpayOrangTuaModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        // Get all tagihan with orang tua info
        $data['tagihan'] = $db->table('spay_tagihan st')
            ->select('st.*, ot.nama as nama_ortu, ot.email, ot.nama_siswa, ot.kelas')
            ->join('spay_orang_tua ot', 'ot.id = st.orang_tua_id', 'left')
            ->orderBy('st.created_at', 'DESC')
            ->get()->getResultArray();

        return view('Admin/spay_tagihan/index', $data);
    }

    public function tambah()
    {
        $data['orang_tua_list'] = $this->orangTuaModel
            ->where('is_active', 1)
            ->orderBy('nama', 'ASC')
            ->findAll();

        // Get existing categories for dropdown
        $db = \Config\Database::connect();
        $data['kategori_list'] = $db->table('spay_tagihan')
            ->select('kategori')->distinct()
            ->where('kategori IS NOT NULL')
            ->where('kategori !=', '')
            ->get()->getResultArray();

        return view('Admin/spay_tagihan/create', $data);
    }

    public function simpan()
    {
        $orangTuaId = $this->request->getPost('orang_tua_id');
        $kategoriInput = $this->request->getPost('kategori_input');
        $kategoriSelect = $this->request->getPost('kategori_select');

        // Determine final kategori
        $kategori = '';
        if (!empty($kategoriSelect) && $kategoriSelect !== '__other__') {
            $kategori = $kategoriSelect;
        } elseif (!empty($kategoriInput)) {
            $kategori = $kategoriInput;
        }

        $db = \Config\Database::connect();
        $db->table('spay_tagihan')->insert([
            'orang_tua_id' => $orangTuaId,
            'judul'        => $this->request->getPost('judul'),
            'nominal'      => str_replace(['.', ','], '', $this->request->getPost('nominal')),
            'batas_bayar'  => $this->request->getPost('batas_bayar') ?: null,
            'keterangan'   => $this->request->getPost('keterangan'),
            'kategori'     => $kategori,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/spay-tagihan')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $db = \Config\Database::connect();
        $data['tagihan'] = $db->table('spay_tagihan')->where('id', $id)->get()->getRowArray();

        if (!$data['tagihan']) {
            return redirect()->to('/admin/spay-tagihan')->with('error', 'Tagihan tidak ditemukan.');
        }

        $data['orang_tua_list'] = $this->orangTuaModel
            ->where('is_active', 1)
            ->orderBy('nama', 'ASC')
            ->findAll();

        $data['kategori_list'] = $db->table('spay_tagihan')
            ->select('kategori')->distinct()
            ->where('kategori IS NOT NULL')
            ->where('kategori !=', '')
            ->get()->getResultArray();

        return view('Admin/spay_tagihan/edit', $data);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        $tagihan = $db->table('spay_tagihan')->where('id', $id)->get()->getRowArray();

        if (!$tagihan) {
            return redirect()->to('/admin/spay-tagihan')->with('error', 'Tagihan tidak ditemukan.');
        }

        $kategoriInput = $this->request->getPost('kategori_input');
        $kategoriSelect = $this->request->getPost('kategori_select');

        $kategori = '';
        if (!empty($kategoriSelect) && $kategoriSelect !== '__other__') {
            $kategori = $kategoriSelect;
        } elseif (!empty($kategoriInput)) {
            $kategori = $kategoriInput;
        }

        $db->table('spay_tagihan')->where('id', $id)->update([
            'orang_tua_id' => $this->request->getPost('orang_tua_id'),
            'judul'        => $this->request->getPost('judul'),
            'nominal'      => str_replace(['.', ','], '', $this->request->getPost('nominal')),
            'batas_bayar'  => $this->request->getPost('batas_bayar') ?: null,
            'keterangan'   => $this->request->getPost('keterangan'),
            'kategori'     => $kategori,
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/spay-tagihan')->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $db = \Config\Database::connect();
        $db->table('spay_tagihan')->where('id', $id)->delete();

        return redirect()->to('/admin/spay-tagihan')->with('success', 'Tagihan berhasil dihapus.');
    }
}