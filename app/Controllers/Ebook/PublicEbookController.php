<?php

namespace App\Controllers\Ebook;

use App\Controllers\BaseController;
use App\Models\SeBookEbookModel;

class PublicEbookController extends BaseController
{
    public function index()
    {
        $model = new SeBookEbookModel();
        $kategori = $this->request->getGet('kategori');

        $kelasAnak = null;
        if (session()->get('orangtua_logged_in')) {
            $kelasAnak = session()->get('orangtua_kelas');
        }

        $data['ebooks'] = [];
        $data['kategoris'] = [];

        $kelasMapping = $this->getKelasMapping();

        $allEbooks = $model->where('is_active', 1)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        if ($kelasAnak) {
            $jenjangAnak = [];
            if (isset($kelasMapping[$kelasAnak])) {
                $jenjangAnak[] = $kelasMapping[$kelasAnak];
            }

            if (empty($jenjangAnak)) {
                $data['ebooks'] = $allEbooks;
            } else {
                $filteredEbooks = [];
                foreach ($allEbooks as $ebook) {
                    $ebookJenjang = array_map('trim', explode(',', $ebook['kelas'] ?? ''));
                    $ebookJenjang = array_filter($ebookJenjang);
                    $intersect = array_intersect($jenjangAnak, $ebookJenjang);
                    if (!empty($intersect)) {
                        $filteredEbooks[] = $ebook;
                    }
                }
                $data['ebooks'] = $filteredEbooks;
            }
        } else {
            $data['ebooks'] = $allEbooks;
        }

        $usedKategoris = array_unique(array_column($data['ebooks'], 'kategori'));
        $usedKategoris = array_filter($usedKategoris, function($k) {
            return !empty($k);
        });
        sort($usedKategoris);
        $data['kategoris'] = array_map(function($k) {
            return ['kategori' => $k];
        }, $usedKategoris);

        $data['filter_kategori'] = $kategori;
        $data['kelasAnak'] = $kelasAnak;

        return view('public_ebook/index', $data);
    }

    private function getKelasMapping()
    {
        $db = \Config\Database::connect();
        $kelas = $db->table('kelas')->get()->getResultArray();

        $mapping = [];
        foreach ($kelas as $k) {
            $pendidikan = $db->table('pendidikan')
                ->where('id_pendidikan', $k['id_pendidikan'])
                ->get()->getRowArray();
            if ($pendidikan) {
                $mapping[$k['nama_kelas']] = $pendidikan['nama'] ?? '';
            }
        }

        return $mapping;
    }

    public function download($id)
    {
        $model = new SeBookEbookModel();
        $ebook = $model->find($id);

        if (!$ebook || !$ebook['is_active']) {
            return redirect()->to('/ebook')->with('error', 'E-Book tidak ditemukan.');
        }

        $kelasAnak = session()->get('orangtua_logged_in') ? session()->get('orangtua_kelas') : null;
        if ($kelasAnak) {
            $kelasMapping = $this->getKelasMapping();
            $jenjangAnak = isset($kelasMapping[$kelasAnak]) ? [$kelasMapping[$kelasAnak]] : [];
            $ebookJenjang = array_map('trim', explode(',', $ebook['kelas'] ?? ''));

            $intersect = array_intersect($jenjangAnak, $ebookJenjang);
            if (empty($intersect)) {
                return redirect()->to('/ebook')->with('error', 'E-Book ini tidak untuk kelas anak Anda.');
            }
        }

        $path = WRITEPATH . 'uploads/ebook/file/' . $ebook['file_path'];
        if (!file_exists($path)) {
            return redirect()->to('/ebook')->with('error', 'File tidak ditemukan.');
        }

        return $this->response->download($path, null)
            ->setFileName($ebook['judul'] . '.pdf');
    }
}