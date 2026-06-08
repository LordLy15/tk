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

        $builder = $model->where('is_active', 1);
        if ($kategori) {
            $builder = $builder->where('kategori', $kategori);
        }
        $data['ebooks'] = $builder->orderBy('created_at', 'DESC')->findAll();
        $data['kategoris'] = $model->getKategoriList();
        $data['filter_kategori'] = $kategori;

        return view('public_ebook/index', $data);
    }

    public function download($id)
    {
        $model = new SeBookEbookModel();
        $ebook = $model->find($id);

        if (!$ebook || !$ebook['is_active']) {
            return redirect()->to('/ebook')->with('error', 'E-Book tidak ditemukan.');
        }

        $path = WRITEPATH . 'uploads/ebook/file/' . $ebook['file_path'];
        if (!file_exists($path)) {
            return redirect()->to('/ebook')->with('error', 'File tidak ditemukan.');
        }

        return $this->response->download($path, null)
            ->setFileName($ebook['judul'] . '.pdf');
    }
}