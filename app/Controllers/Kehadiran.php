<?php

namespace App\Controllers;

use App\Models\KehadiranModel;
use App\Models\MuridModel;
use App\Models\KelasModel;
use App\Models\LiburSekolahModel;

class Kehadiran extends BaseController
{
    protected $kehadiranModel;
    protected $muridModel;
    protected $kelasModel;
    protected $liburModel;

    public function __construct()
    {
        $this->kehadiranModel = new KehadiranModel();
        $this->muridModel = new MuridModel();
        $this->kelasModel = new KelasModel();
        $this->liburModel = new LiburSekolahModel();
    }

    public function index()
    {
        $tanggal = $this->resolveTanggal(
            $this->request->getGet('tanggal'),
            $this->request->getGet('bulan'),
            $this->request->getGet('tahun')
        );
        $id_kelas = $this->request->getGet('kelas');

        if (strtolower((string) session('role')) === 'guru') {
            $assignedKelas = $this->kelasModel->where('id_guru', session('id_guru'))->first();
            $id_kelas = $assignedKelas ? (int) $assignedKelas['id_kelas'] : 0;
        }

        $kelasList = $this->getKelasList();

        $data = [
            'tanggal' => $tanggal,
            'kelas_list' => $kelasList,
            'id_kelas_selected' => $id_kelas,
            'selected_kelas' => null,
            'kehadiran' => [],
            'rekap' => $this->emptyRekap(),
            'murid_count' => 0,
            'max_tanggal' => $this->todayDate(),
            'cek_libur' => $this->liburModel->cekTanggalLibur($tanggal),
        ];

        if ($id_kelas) {
            $murid = $this->muridModel
                ->where('id_kelas', $id_kelas)
                ->orderBy('nama_murid', 'ASC')
                ->findAll();
            $kehadiran = $this->kehadiranModel->getKehadiranByKelas($id_kelas, $tanggal);

            $data['selected_kelas'] = $this->findSelectedKelas($kelasList, $id_kelas);
            $data['kehadiran'] = $this->buildDaftarKehadiran($murid, $kehadiran, $tanggal);
            $data['rekap'] = $this->hitungRekapHarian($data['kehadiran']);
            $data['murid_count'] = count($murid);
        }

        return view('Kehadiran/index', $data);
    }

    public function input()
    {
        $tanggal = $this->resolveTanggal($this->request->getGet('tanggal'));
        $id_kelas = $this->request->getGet('kelas') ?? 0;

        if (strtolower((string) session('role')) === 'guru') {
            $assignedKelas = $this->kelasModel->where('id_guru', session('id_guru'))->first();
            $id_kelas = $assignedKelas ? (int) $assignedKelas['id_kelas'] : 0;
        }

        $kehadiranByMurid = [];
        $kelasList = $this->getKelasList();

        if ($id_kelas) {
            $murid = $this->muridModel
                ->where('id_kelas', $id_kelas)
                ->orderBy('nama_murid', 'ASC')
                ->findAll();
            $kehadiranByMurid = $this->indexKehadiranByMurid(
                $this->kehadiranModel->getKehadiranByKelas($id_kelas, $tanggal)
            );
        } else {
            $murid = [];
        }

        $data = [
            'tanggal' => $tanggal,
            'id_kelas' => $id_kelas,
            'kelas_list' => $kelasList,
            'selected_kelas' => $this->findSelectedKelas($kelasList, $id_kelas),
            'murid' => $murid,
            'kehadiran_by_murid' => $kehadiranByMurid,
            'max_tanggal' => $this->todayDate(),
            'cek_libur' => $this->liburModel->cekTanggalLibur($tanggal)
        ];

        return view('Kehadiran/input', $data);
    }

    public function simpan()
    {
        $tanggal = $this->request->getPost('tanggal');
        $id_kelas = $this->request->getPost('id_kelas');
        $kehadiran_data = $this->request->getPost('kehadiran');
        $keterangan = $this->request->getPost('keterangan') ?? [];

        if (!$tanggal || !$id_kelas || !$kehadiran_data) {
            return redirect()->back()->with('error', 'Data tidak lengkap');
        }

        if (strtolower((string) session('role')) === 'guru') {
            $assignedKelas = $this->kelasModel->where('id_guru', session('id_guru'))->first();
            $myKelasId = $assignedKelas ? (int) $assignedKelas['id_kelas'] : 0;
            if ((int)$id_kelas !== $myKelasId) {
                return redirect()->back()->with('error', 'Anda tidak diperbolehkan memasukkan kehadiran untuk kelas lain.');
            }
        }

        if ($this->isFutureDate($tanggal)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tanggal kehadiran tidak boleh melebihi hari ini.');
        }

        try {
            foreach ($kehadiran_data as $id_murid => $status) {
                $existing = $this->kehadiranModel
                    ->where('id_murid', $id_murid)
                    ->where('tanggal', $tanggal)
                    ->first();

                $data_simpan = [
                    'id_murid' => $id_murid,
                    'id_kelas' => $id_kelas,
                    'tanggal' => $tanggal,
                    'status' => $status,
                    'keterangan' => $keterangan[$id_murid] ?? null
                ];

                if ($existing) {
                    $this->kehadiranModel->update($existing['id'], $data_simpan);
                } else {
                    $this->kehadiranModel->insert($data_simpan);
                }
            }

            return redirect()
                ->to('/kehadiran?kelas=' . $id_kelas . '&tanggal=' . $tanggal)
                ->with('success', 'Data kehadiran berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function laporan()
    {
        $id_murid = $this->request->getGet('murid');
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        if (strtolower((string) session('role')) === 'guru') {
            $assignedKelas = $this->kelasModel->where('id_guru', session('id_guru'))->first();
            $myKelasId = $assignedKelas ? (int) $assignedKelas['id_kelas'] : 0;
            
            $muridList = $this->muridModel->where('id_kelas', $myKelasId)->orderBy('nama_murid', 'ASC')->findAll();
        } else {
            $muridList = $this->muridModel->orderBy('nama_murid', 'ASC')->findAll();
        }

        if ($id_murid) {
            $muridObj = $this->muridModel->find($id_murid);
            if (strtolower((string) session('role')) === 'guru') {
                $assignedKelas = $this->kelasModel->where('id_guru', session('id_guru'))->first();
                $myKelasId = $assignedKelas ? (int) $assignedKelas['id_kelas'] : 0;
                
                if (!$muridObj || (int)$muridObj['id_kelas'] !== $myKelasId) {
                    return redirect()->to(base_url('kehadiran/laporan'))->with('error', 'Anda tidak memiliki akses ke laporan murid kelas lain.');
                }
            }
        }

        $data = [
            'murid_list' => $muridList,
            'id_murid_selected' => $id_murid,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        if ($id_murid) {
            $data['kehadiran'] = $this->kehadiranModel->getKehadiranByMurid($id_murid, $bulan, $tahun);
            $data['murid'] = $this->muridModel->find($id_murid);
            
            // Hitung rekap
            $kehadiran = $data['kehadiran'];
            $data['rekap'] = [
                'hadir' => count(array_filter($kehadiran, fn($x) => $x['status'] == 'hadir')),
                'sakit' => count(array_filter($kehadiran, fn($x) => $x['status'] == 'sakit')),
                'izin' => count(array_filter($kehadiran, fn($x) => $x['status'] == 'izin')),
                'alpha' => count(array_filter($kehadiran, fn($x) => $x['status'] == 'alpha')),
            ];
        }

        return view('Kehadiran/laporan', $data);
    }

    private function getKelasList(): array
    {
        $builder = $this->kelasModel
            ->select('kelas.*, guru.nama_guru')
            ->join('guru', 'guru.id = kelas.id_guru', 'left');

        if (strtolower((string) session('role')) === 'guru') {
            $builder->where('kelas.id_guru', session('id_guru'));
        }

        return $builder->orderBy('kelas.nama_kelas', 'ASC')
            ->findAll();
    }

    private function resolveTanggal(?string $tanggal, ?string $bulan = null, ?string $tahun = null): string
    {
        if ($tanggal && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            return $this->isFutureDate($tanggal) ? $this->todayDate() : $tanggal;
        }

        if ($tanggal && $bulan && $tahun && checkdate((int) $bulan, (int) $tanggal, (int) $tahun)) {
            $resolvedTanggal = sprintf('%04d-%02d-%02d', (int) $tahun, (int) $bulan, (int) $tanggal);

            return $this->isFutureDate($resolvedTanggal) ? $this->todayDate() : $resolvedTanggal;
        }

        return $this->todayDate();
    }

    private function isFutureDate(string $tanggal): bool
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal) && $tanggal > $this->todayDate();
    }

    private function todayDate(): string
    {
        return date('Y-m-d');
    }

    private function findSelectedKelas(array $kelasList, $idKelas): ?array
    {
        foreach ($kelasList as $kelas) {
            if ((int) $kelas['id_kelas'] === (int) $idKelas) {
                return $kelas;
            }
        }

        return null;
    }

    private function buildDaftarKehadiran(array $murid, array $kehadiran, string $tanggal): array
    {
        $kehadiranByMurid = $this->indexKehadiranByMurid($kehadiran);

        return array_map(static function (array $m) use ($kehadiranByMurid, $tanggal): array {
            $absensi = $kehadiranByMurid[$m['id']] ?? null;

            return [
                'id_murid' => $m['id'],
                'nisn' => $m['nisn'] ?? '-',
                'nama_murid' => $m['nama_murid'],
                'tanggal' => $tanggal,
                'status' => $absensi['status'] ?? null,
                'keterangan' => $absensi['keterangan'] ?? null,
            ];
        }, $murid);
    }

    private function indexKehadiranByMurid(array $kehadiran): array
    {
        $indexed = [];

        foreach ($kehadiran as $item) {
            $indexed[$item['id_murid']] = $item;
        }

        return $indexed;
    }

    private function hitungRekapHarian(array $kehadiran): array
    {
        $rekap = $this->emptyRekap();
        $rekap['total'] = count($kehadiran);

        foreach ($kehadiran as $item) {
            $status = $item['status'] ?: 'belum';

            if (array_key_exists($status, $rekap)) {
                $rekap[$status]++;
            }
        }

        return $rekap;
    }

    private function emptyRekap(): array
    {
        return [
            'total' => 0,
            'hadir' => 0,
            'sakit' => 0,
            'izin' => 0,
            'alpha' => 0,
            'belum' => 0,
        ];
    }
}
