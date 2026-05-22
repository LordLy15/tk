<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Laporan Fasilitas</h1>
        <p>Rekap kondisi fasilitas sekolah dan daftar inventaris lengkap.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('fasilitas') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="dashboard-stats-grid mb-3">
    <div class="admin-stat-card stat-primary">
        <div class="stat-icon"><i class="ti ti-building"></i></div>
        <div>
            <div class="stat-label">Total Fasilitas</div>
            <div class="stat-value"><?= esc($rekap['total'] ?? 0) ?></div>
        </div>
    </div>

    <div class="admin-stat-card stat-success">
        <div class="stat-icon"><i class="ti ti-circle-check"></i></div>
        <div>
            <div class="stat-label">Kondisi Baik</div>
            <div class="stat-value"><?= esc($rekap['baik'] ?? 0) ?></div>
        </div>
    </div>

    <div class="admin-stat-card stat-warning">
        <div class="stat-icon"><i class="ti ti-alert-triangle"></i></div>
        <div>
            <div class="stat-label">Kondisi Cukup</div>
            <div class="stat-value"><?= esc($rekap['cukup'] ?? 0) ?></div>
        </div>
    </div>

    <div class="admin-stat-card stat-danger">
        <div class="stat-icon"><i class="ti ti-tools"></i></div>
        <div>
            <div class="stat-label">Kondisi Rusak</div>
            <div class="stat-value"><?= esc($rekap['rusak'] ?? 0) ?></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Fasilitas</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($fasilitas)) : ?>
                        <tr>
                            <td colspan="7" class="empty-state">Belum ada data fasilitas.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($fasilitas as $f) : ?>
                            <?php $catatan = $f['catatan'] ?? '-'; ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-semibold"><?= esc($f['nama_fasilitas']) ?></td>
                                <td><?= esc(ucfirst(str_replace('_', ' ', $f['jenis_fasilitas']))) ?></td>
                                <td><?= esc($f['jumlah']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $f['kondisi'] === 'baik' ? 'success' : ($f['kondisi'] === 'cukup' ? 'warning' : 'danger') ?>">
                                        <?= esc(ucfirst($f['kondisi'])) ?>
                                    </span>
                                </td>
                                <td><?= esc($f['lokasi'] ?? '-') ?></td>
                                <td><?= esc(strlen($catatan) > 80 ? substr($catatan, 0, 80) . '...' : $catatan) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
