<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Libur Sekolah</h1>
        <p>Kelola tanggal libur, cuti bersama, dan agenda nonaktif sekolah.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('libur/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Libur
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Libur</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th class="action-cell text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($libur)) : ?>
                        <tr>
                            <td colspan="7" class="empty-state">Belum ada data libur.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($libur as $l) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-semibold"><?= esc($l['nama_libur']) ?></td>
                                <td><?= esc(date('d-m-Y', strtotime($l['tanggal_mulai']))) ?></td>
                                <td><?= esc(date('d-m-Y', strtotime($l['tanggal_selesai']))) ?></td>
                                <td><span class="badge badge-soft"><?= esc(ucfirst(str_replace('_', ' ', $l['jenis_libur']))) ?></span></td>
                                <td>
                                    <span class="badge bg-<?= ($l['status'] ?? '') === 'aktif' ? 'success' : 'secondary' ?>">
                                        <?= esc(ucfirst($l['status'])) ?>
                                    </span>
                                </td>
                                <td class="action-cell">
                                    <div class="table-actions">
                                        <a href="<?= base_url('libur/edit/' . $l['id']) ?>"
                                           class="btn btn-warning btn-sm action-icon-btn"
                                           title="Edit libur"
                                           aria-label="Edit <?= esc($l['nama_libur'], 'attr') ?>">
                                            <i class="ti ti-edit"></i>
                                            <span class="visually-hidden">Edit</span>
                                        </a>
                                        <a href="<?= base_url('libur/hapus/' . $l['id']) ?>"
                                           class="btn btn-danger btn-sm action-icon-btn"
                                           title="Hapus libur"
                                           aria-label="Hapus <?= esc($l['nama_libur'], 'attr') ?>"
                                           onclick="return confirm('Hapus data libur ini?')">
                                            <i class="ti ti-trash"></i>
                                            <span class="visually-hidden">Hapus</span>
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
