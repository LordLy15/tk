<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<?php
$statusMeta = [
    'hadir' => ['label' => 'Hadir', 'stat' => 'success', 'icon' => 'ti-user-check'],
    'sakit' => ['label' => 'Sakit', 'stat' => 'warning', 'icon' => 'ti-thermometer'],
    'izin' => ['label' => 'Izin', 'stat' => 'info', 'icon' => 'ti-message-circle'],
    'alpha' => ['label' => 'Alpha', 'stat' => 'danger', 'icon' => 'ti-user-x'],
    'belum' => ['label' => 'Belum Diinput', 'stat' => 'secondary', 'icon' => 'ti-clock'],
];

$selectedParams = [
    'tanggal' => $tanggal,
];

if (!empty($id_kelas_selected)) {
    $selectedParams['kelas'] = $id_kelas_selected;
}

$inputUrl = base_url('kehadiran/input') . (!empty($selectedParams) ? '?' . http_build_query($selectedParams) : '');
$todayParams = ['tanggal' => date('Y-m-d')];

if (!empty($id_kelas_selected)) {
    $todayParams['kelas'] = $id_kelas_selected;
}

$todayUrl = base_url('kehadiran') . '?' . http_build_query($todayParams);
?>

<div class="crud-page-header">
    <div>
        <h1>Daftar Kehadiran</h1>
        <p>Absensi harian per kelas.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('kehadiran/laporan') ?>" class="btn btn-light">
            <i class="ti ti-report"></i>
            Laporan
        </a>
        <a href="<?= esc($inputUrl) ?>" class="btn btn-primary">
            <i class="ti ti-clipboard-check"></i>
            Input/Edit Kehadiran
        </a>
    </div>
</div>

<?php if ($cek_libur) : ?>
    <div class="alert alert-warning border-warning-subtle" role="alert">
        <strong><?= esc(date('d-m-Y', strtotime($tanggal))) ?> libur sekolah.</strong>
        <?= esc($cek_libur['nama_libur']) ?>
    </div>
<?php endif; ?>

<div class="card mb-3">
    <div class="card-body">
        <form method="get" action="<?= base_url('kehadiran') ?>" class="row g-3 align-items-end">
            <div class="col-md-4 col-lg-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input id="tanggal"
                       type="date"
                       name="tanggal"
                       class="form-control"
                       value="<?= esc($tanggal) ?>"
                       max="<?= esc($max_tanggal ?? date('Y-m-d')) ?>"
                       onchange="this.form.submit()"
                       required>
            </div>

            <div class="col-md-5 col-lg-4">
                <label for="kelas" class="form-label">Kelas</label>
                <select id="kelas" name="kelas" class="form-select" onchange="this.form.submit()" required>
                    <option value="">Pilih Kelas</option>
                    <?php foreach ($kelas_list ?? [] as $k) : ?>
                        <option value="<?= esc($k['id_kelas']) ?>" <?= (int) $k['id_kelas'] === (int) $id_kelas_selected ? 'selected' : '' ?>>
                            <?= esc($k['nama_kelas']) ?>
                            <?php if (!empty($k['nama_guru'])) : ?>
                                - <?= esc($k['nama_guru']) ?>
                            <?php endif; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3 col-lg-2">
                <a href="<?= esc($todayUrl) ?>" class="btn btn-outline-primary w-100">
                    <i class="ti ti-calendar"></i>
                    Hari Ini
                </a>
            </div>
        </form>
    </div>
</div>

<?php if ($id_kelas_selected) : ?>
    <div class="dashboard-stats-grid mb-3">
        <div class="admin-stat-card stat-primary">
            <span class="stat-icon"><i class="ti ti-users"></i></span>
            <div>
                <div class="stat-label">Total Murid</div>
                <div class="stat-value"><?= esc($rekap['total']) ?></div>
            </div>
        </div>

        <?php foreach (['hadir', 'sakit', 'izin', 'alpha', 'belum'] as $status) : ?>
            <?php $meta = $statusMeta[$status]; ?>
            <div class="admin-stat-card stat-<?= esc($meta['stat']) ?>">
                <span class="stat-icon"><i class="ti <?= esc($meta['icon']) ?>"></i></span>
                <div>
                    <div class="stat-label"><?= esc($meta['label']) ?></div>
                    <div class="stat-value"><?= esc($rekap[$status]) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h5 class="mb-1">Absensi <?= esc($selected_kelas['nama_kelas'] ?? 'Kelas') ?></h5>
                <p class="mb-0 text-secondary">
                    <?= esc(date('d-m-Y', strtotime($tanggal))) ?>
                    <?php if (!empty($selected_kelas['nama_guru'])) : ?>
                        &middot; <?= esc($selected_kelas['nama_guru']) ?>
                    <?php endif; ?>
                </p>
            </div>

            <a href="<?= esc($inputUrl) ?>" class="btn btn-outline-primary btn-sm">
                <i class="ti ti-edit"></i>
                Ubah Absensi
            </a>
        </div>

        <div class="card-body">
            <?php if (empty($kehadiran)) : ?>
                <div class="empty-state">Belum ada murid di kelas ini.</div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 64px;">No</th>
                                <th style="width: 160px;">NISN</th>
                                <th>Nama Murid</th>
                                <th style="width: 170px;">Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kehadiran as $index => $k) : ?>
                                <?php
                                $status = $k['status'] ?: 'belum';
                                $meta = $statusMeta[$status] ?? $statusMeta['belum'];
                                ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($k['nisn']) ?></td>
                                    <td class="fw-semibold"><?= esc($k['nama_murid']) ?></td>
                                    <td>
                                        <span class="attendance-status-badge attendance-status-<?= esc($status) ?>">
                                            <?= esc($meta['label']) ?>
                                        </span>
                                    </td>
                                    <td><?= esc($k['keterangan'] ?: '-') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php else : ?>
    <div class="card">
        <div class="card-body">
            <div class="empty-state">Pilih tanggal dan kelas untuk melihat daftar kehadiran.</div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
