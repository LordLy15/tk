<?php

namespace App\Models;

use CodeIgniter\Model;

class SpayPembayaranModel extends Model
{
    protected $table      = 'spay_pembayaran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tagihan_id','orang_tua_id','bukti_bayar','tanggal_bayar','status','catatan_admin','verified_at','created_at','updated_at'];

    public function getTagihanByOrangTua($orangTuaId, $status = null)
    {
        $builder = $this->db->table('spay_tagihan t')
            ->select('t.*, p.status, p.bukti_bayar, p.id as pembayaran_id, p.created_at as bayar_created_at')
            ->join('spay_pembayaran p', 'p.id = (SELECT MAX(id) FROM spay_pembayaran WHERE tagihan_id = t.id AND orang_tua_id = t.orang_tua_id)', 'left')
            ->where('t.orang_tua_id', $orangTuaId);
        if ($status) $builder->where('p.status', $status);
        return $builder->orderBy('t.batas_bayar', 'ASC')->get()->getResultArray();
    }

    public function getDetailTagihan($tagihanId, $orangTuaId)
    {
        return $this->db->table('spay_tagihan t')
            ->select('t.*, p.status, p.bukti_bayar, p.catatan_admin, p.id as pembayaran_id, p.tanggal_bayar, p.verified_at')
            ->join('spay_pembayaran p', 'p.id = (SELECT MAX(id) FROM spay_pembayaran WHERE tagihan_id = t.id)', 'left')
            ->where('t.id', $tagihanId)
            ->where('t.orang_tua_id', $orangTuaId)
            ->get()->getRowArray();
    }

    public function getAllPembayaran($searchSiswa = null, $searchKelas = null)
    {
        $builder = $this->db->table('spay_pembayaran p')
            ->select('p.*, t.judul, t.nominal, ot.nama as nama_ortu, ot.nama_siswa, ot.kelas')
            ->join('spay_tagihan t', 't.id = p.tagihan_id')
            ->join('spay_orang_tua ot', 'ot.id = p.orang_tua_id')
            ->where('p.id = (SELECT MAX(id) FROM spay_pembayaran WHERE tagihan_id = p.tagihan_id)');

        if (!empty($searchSiswa)) {
            $builder->like('ot.nama_siswa', $searchSiswa);
        }

        if (!empty($searchKelas)) {
            $builder->where('ot.kelas', $searchKelas);
        }

        return $builder->orderBy('p.created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function getPembayaranDetail($id)
    {
        return $this->db->table('spay_pembayaran p')
            ->select('p.*, t.judul, t.nominal, t.keterangan, ot.nama as nama_ortu, ot.nama_siswa, ot.kelas, ot.no_hp')
            ->join('spay_tagihan t', 't.id = p.tagihan_id')
            ->join('spay_orang_tua ot', 'ot.id = p.orang_tua_id')
            ->where('p.id', $id)
            ->get()->getRowArray();
    }

    public function simpanPembayaran($data)
    {
        return $this->db->table('spay_pembayaran')->insert($data);
    }

    public function updateStatus($id, $status, $catatan = null)
    {
        $updateData = [
            'status'      => $status,
            'verified_at' => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];
        if ($catatan) $updateData['catatan_admin'] = $catatan;
        return $this->db->table('spay_pembayaran')->where('id', $id)->update($updateData);
    }

    public function getStatsByOrangTua($orangTuaId)
    {
        $tagihan = $this->db->table('spay_tagihan')
            ->where('orang_tua_id', $orangTuaId)
            ->get()->getResultArray();

        $total = 0;
        $pending = 0;
        $lunas = 0;
        $pendingCount = 0;
        $lunasCount = 0;

        foreach ($tagihan as $t) {
            $total += (float) $t['nominal'];
            $pembayaran = $this->db->table('spay_pembayaran')
                ->where('tagihan_id', $t['id'])
                ->where('status', 'verified')
                ->get()->getRowArray();
            if ($pembayaran) {
                $lunas += (float) $t['nominal'];
                $lunasCount++;
            } else {
                $pending += (float) $t['nominal'];
                $pendingCount++;
            }
        }

        return [
            'total' => $total,
            'pending' => $pending,
            'lunas' => $lunas,
            'pending_count' => $pendingCount,
            'lunas_count' => $lunasCount,
        ];
    }
}