<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<?php
$bulanList = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember',
];
?>

<div class="crud-page-header">
    <div>
        <h1>Laporan Kehadiran</h1>
        <p>Rekap kehadiran murid berdasarkan bulan dan tahun.</p>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="murid" class="form-label">Murid</label>
                <select id="murid" name="murid" class="form-select" onchange="this.form.submit()">
                    <option value="">Pilih Murid</option>
                    <?php foreach ($murid_list ?? [] as $m) : ?>
                        <option value="<?= esc($m['id']) ?>" <?= $m['id'] == $id_murid_selected ? 'selected' : '' ?>>
                            <?= esc($m['nama_murid']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="bulan" class="form-label">Bulan</label>
                <select id="bulan" name="bulan" class="form-select" onchange="this.form.submit()">
                    <?php foreach ($bulanList as $number => $name) : ?>
                        <option value="<?= $number ?>" <?= (int) $number === (int) $bulan ? 'selected' : '' ?>>
                            <?= esc($name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input id="tahun"
                       type="number"
                       name="tahun"
                       class="form-control"
                       value="<?= esc($tahun) ?>"
                       onchange="this.form.submit()">
            </div>
        </form>
    </div>
</div>

<?php if ($id_murid_selected && isset($murid)) : ?>
    <div class="mb-3">
        <h2 class="fs-5 mb-1"><?= esc($murid['nama_murid']) ?></h2>
        <p class="text-secondary mb-0">Periode <?= esc($bulanList[(int) $bulan] ?? $bulan) ?> <?= esc($tahun) ?></p>
    </div>

    <div class="dashboard-stats-grid mb-3">
        <div class="admin-stat-card stat-success">
            <div class="stat-icon"><i class="ti ti-user-check"></i></div>
            <div>
                <div class="stat-label">Hadir</div>
                <div class="stat-value"><?= esc($rekap['hadir'] ?? 0) ?></div>
            </div>
        </div>

        <div class="admin-stat-card stat-warning">
            <div class="stat-icon"><i class="ti ti-first-aid-kit"></i></div>
            <div>
                <div class="stat-label">Sakit</div>
                <div class="stat-value"><?= esc($rekap['sakit'] ?? 0) ?></div>
            </div>
        </div>

        <div class="admin-stat-card stat-info">
            <div class="stat-icon"><i class="ti ti-mail"></i></div>
            <div>
                <div class="stat-label">Izin</div>
                <div class="stat-value"><?= esc($rekap['izin'] ?? 0) ?></div>
            </div>
        </div>

        <div class="admin-stat-card stat-danger">
            <div class="stat-icon"><i class="ti ti-user-x"></i></div>
            <div>
                <div class="stat-label">Alpha</div>
                <div class="stat-value"><?= esc($rekap['alpha'] ?? 0) ?></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kehadiran)) : ?>
                            <tr>
                                <td colspan="3" class="empty-state">Tidak ada data kehadiran pada periode ini.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($kehadiran as $k) : ?>
                                <?php
                                $statusClass = [
                                    'hadir' => 'success',
                                    'sakit' => 'warning',
                                    'izin' => 'info',
                                    'alpha' => 'danger',
                                ][$k['status']] ?? 'secondary';
                                ?>
                                <tr>
                                    <td><?= esc(date('d-m-Y', strtotime($k['tanggal']))) ?></td>
                                    <td><span class="badge bg-<?= esc($statusClass) ?>"><?= esc(ucfirst($k['status'])) ?></span></td>
                                    <td><?= esc($k['keterangan'] ?? '-') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="card">
        <div class="card-body">
            <div class="empty-state">Pilih murid untuk melihat laporan kehadiran.</div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
