<?php

namespace App\Models;

use CodeIgniter\Model;

class SpayPembayaranModel extends Model
{
    protected $table      = 'spay_pembayaran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tagihan_id','orang_tua_id','nominal_bayar','bukti_bayar','tanggal_bayar','status','catatan_admin','verified_at','created_at','updated_at'];

    public function getTagihanByOrangTua($orangTuaId, $status = null)
    {
        $builder = $this->db->table('spay_tagihan t')
            ->select('t.*')
            ->select('COALESCE((SELECT SUM(nominal_bayar) FROM spay_pembayaran WHERE tagihan_id = t.id AND status = \'verified\'), 0) as total_terbayar')
            ->select('(t.nominal - COALESCE((SELECT SUM(nominal_bayar) FROM spay_pembayaran WHERE tagihan_id = t.id AND status = \'verified\'), 0)) as sisa_tagihan')
            ->select('(SELECT COUNT(*) FROM spay_pembayaran WHERE tagihan_id = t.id AND status = \'pending\') as pending_count')
            ->select('(SELECT status FROM spay_pembayaran WHERE tagihan_id = t.id ORDER BY id DESC LIMIT 1) as last_status')
            ->select('(SELECT bukti_bayar FROM spay_pembayaran WHERE tagihan_id = t.id ORDER BY id DESC LIMIT 1) as last_bukti')
            ->where('t.orang_tua_id', $orangTuaId);

        $rows = $builder->orderBy('t.batas_bayar', 'ASC')->get()->getResultArray();
        $result = [];

        foreach ($rows as $row) {
            $sisa = (float) $row['sisa_tagihan'];
            $total_terbayar = (float) $row['total_terbayar'];
            $pending = (int) $row['pending_count'];
            $last_status = $row['last_status'];
            
            if ($sisa <= 0) {
                $computed_status = 'verified'; // Lunas
            } elseif ($total_terbayar > 0) {
                $computed_status = ($pending > 0) ? 'pending' : 'partial'; // Dicicil
            } else {
                $computed_status = ($pending > 0) ? 'pending' : (($last_status === 'rejected') ? 'rejected' : 'pending_upload');
            }
            
            $row['status'] = $computed_status;
            $row['bukti_bayar'] = $row['last_bukti']; // Compatibility
            
            if ($status) {
                if ($status === 'pending' && $computed_status !== 'pending') continue;
                if ($status === 'verified' && $computed_status !== 'verified') continue;
                if ($status === 'partial' && $computed_status !== 'partial') continue;
                if ($status === 'pending_upload' && $computed_status !== 'pending_upload') continue;
            }
            $result[] = $row;
        }
        return $result;
    }

    public function getDetailTagihan($tagihanId, $orangTuaId)
    {
        $tagihan = $this->db->table('spay_tagihan t')
            ->select('t.*')
            ->select('COALESCE((SELECT SUM(nominal_bayar) FROM spay_pembayaran WHERE tagihan_id = t.id AND status = \'verified\'), 0) as total_terbayar')
            ->select('(t.nominal - COALESCE((SELECT SUM(nominal_bayar) FROM spay_pembayaran WHERE tagihan_id = t.id AND status = \'verified\'), 0)) as sisa_tagihan')
            ->select('(SELECT COUNT(*) FROM spay_pembayaran WHERE tagihan_id = t.id AND status = \'pending\') as pending_count')
            ->select('(SELECT status FROM spay_pembayaran WHERE tagihan_id = t.id ORDER BY id DESC LIMIT 1) as last_status')
            ->select('(SELECT bukti_bayar FROM spay_pembayaran WHERE tagihan_id = t.id ORDER BY id DESC LIMIT 1) as last_bukti')
            ->select('(SELECT catatan_admin FROM spay_pembayaran WHERE tagihan_id = t.id ORDER BY id DESC LIMIT 1) as last_catatan')
            ->select('(SELECT tanggal_bayar FROM spay_pembayaran WHERE tagihan_id = t.id ORDER BY id DESC LIMIT 1) as last_tanggal_bayar')
            ->where('t.id', $tagihanId)
            ->where('t.orang_tua_id', $orangTuaId)
            ->get()->getRowArray();
            
        if ($tagihan) {
            $sisa = (float) $tagihan['sisa_tagihan'];
            $total_terbayar = (float) $tagihan['total_terbayar'];
            $pending = (int) $tagihan['pending_count'];
            $last_status = $tagihan['last_status'];
            
            if ($sisa <= 0) {
                $computed_status = 'verified'; // Lunas
            } elseif ($total_terbayar > 0) {
                $computed_status = ($pending > 0) ? 'pending' : 'partial'; // Dicicil
            } else {
                $computed_status = ($pending > 0) ? 'pending' : (($last_status === 'rejected') ? 'rejected' : 'pending_upload');
            }
            
            $tagihan['status'] = $computed_status;
            $tagihan['bukti_bayar'] = $tagihan['last_bukti']; // Compatibility
            $tagihan['catatan_admin'] = $tagihan['last_catatan']; // Compatibility
            $tagihan['tanggal_bayar'] = $tagihan['last_tanggal_bayar']; // Compatibility
        }
        return $tagihan;
    }

    public function getAllPembayaran($searchSiswa = null, $searchKelas = null)
    {
        $builder = $this->db->table('spay_pembayaran p')
            ->select('p.*, t.judul, t.nominal, ot.nama as nama_ortu, ot.nama_siswa, ot.kelas')
            ->join('spay_tagihan t', 't.id = p.tagihan_id')
            ->join('spay_orang_tua ot', 'ot.id = p.orang_tua_id');

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
        $pembayaran = $this->db->table('spay_pembayaran p')
            ->select('p.*, t.judul, t.nominal, t.nominal as nominal_tagihan, t.keterangan, ot.nama as nama_ortu, ot.nama_siswa, ot.kelas, ot.no_hp')
            ->join('spay_tagihan t', 't.id = p.tagihan_id')
            ->join('spay_orang_tua ot', 'ot.id = p.orang_tua_id')
            ->where('p.id', $id)
            ->get()->getRowArray();

        if ($pembayaran) {
            $sumVerified = (float) $this->db->table('spay_pembayaran')
                ->where('tagihan_id', $pembayaran['tagihan_id'])
                ->where('status', 'verified')
                ->where('id !=', $pembayaran['id'])
                ->selectSum('nominal_bayar')
                ->get()->getRow()->nominal_bayar;
            
            $pembayaran['total_terbayar_sebelumnya'] = $sumVerified;
            $pembayaran['sisa_tagihan_sebelumnya'] = (float)$pembayaran['nominal_tagihan'] - $sumVerified;
            $pembayaran['sisa_tagihan_setelahnya'] = (float)$pembayaran['nominal_tagihan'] - ($sumVerified + (float)$pembayaran['nominal_bayar']);
        }
        return $pembayaran;
    }

    public function getPaymentHistory($tagihanId)
    {
        return $this->db->table('spay_pembayaran')
            ->where('tagihan_id', $tagihanId)
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
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
            $nominal = (float) $t['nominal'];
            $total += $nominal;
            
            $sumVerified = (float) $this->db->table('spay_pembayaran')
                ->where('tagihan_id', $t['id'])
                ->where('status', 'verified')
                ->selectSum('nominal_bayar')
                ->get()->getRow()->nominal_bayar;
                
            $lunas += $sumVerified;
            $sisa = $nominal - $sumVerified;
            $pending += ($sisa > 0 ? $sisa : 0);
            
            if ($sisa <= 0) {
                $lunasCount++;
            } else {
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