<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Inventaris Fasilitas</h1>
        <p>Kelola fasilitas sekolah, jumlah barang, kondisi, dan lokasi.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('fasilitas/laporan') ?>" class="btn btn-light">
            <i class="ti ti-report"></i>
            Laporan
        </a>
        <a href="<?= base_url('fasilitas/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Fasilitas
        </a>
    </div>
</div>

<div class="dashboard-stats-grid mb-3">
    <div class="admin-stat-card stat-primary">
        <div class="stat-icon"><i class="ti ti-building"></i></div>
        <div>
            <div class="stat-label">Total</div>
            <div class="stat-value"><?= esc($rekap['total'] ?? 0) ?></div>
        </div>
    </div>

    <div class="admin-stat-card stat-success">
        <div class="stat-icon"><i class="ti ti-circle-check"></i></div>
        <div>
            <div class="stat-label">Baik</div>
            <div class="stat-value"><?= esc($rekap['baik'] ?? 0) ?></div>
        </div>
    </div>

    <div class="admin-stat-card stat-warning">
        <div class="stat-icon"><i class="ti ti-alert-triangle"></i></div>
        <div>
            <div class="stat-label">Cukup</div>
            <div class="stat-value"><?= esc($rekap['cukup'] ?? 0) ?></div>
        </div>
    </div>

    <div class="admin-stat-card stat-danger">
        <div class="stat-icon"><i class="ti ti-tools"></i></div>
        <div>
            <div class="stat-label">Rusak</div>
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
                        <th>Nama Fasilitas</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($fasilitas)) : ?>
                        <tr>
                            <td colspan="6" class="empty-state">Belum ada data fasilitas.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($fasilitas as $f) : ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($f['nama_fasilitas']) ?></td>
                                <td><?= esc(ucfirst(str_replace('_', ' ', $f['jenis_fasilitas']))) ?></td>
                                <td><?= esc($f['jumlah']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $f['kondisi'] === 'baik' ? 'success' : ($f['kondisi'] === 'cukup' ? 'warning' : 'danger') ?>">
                                        <?= esc(ucfirst($f['kondisi'])) ?>
                                    </span>
                                </td>
                                <td><?= esc($f['lokasi'] ?? '-') ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="<?= base_url('fasilitas/edit/' . $f['id']) ?>" class="btn btn-warning btn-sm">
                                            <i class="ti ti-edit"></i>
                                            Edit
                                        </a>
                                        <a href="<?= base_url('fasilitas/hapus/' . $f['id']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Hapus fasilitas ini?')">
                                            <i class="ti ti-trash"></i>
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
