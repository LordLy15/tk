<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Pengumuman</h1>
        <p>Kelola informasi sekolah berdasarkan prioritas dan periode publikasi.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('pengumuman/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Pengumuman
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Prioritas</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengumuman)) : ?>
                        <tr>
                            <td colspan="5" class="empty-state">Belum ada pengumuman.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($pengumuman as $p) : ?>
                            <?php
                            $judul = $p['judul'] ?? '-';
                            $priorityClass = $p['prioritas'] === 'tinggi' ? 'danger' : ($p['prioritas'] === 'normal' ? 'warning' : 'info');
                            ?>
                            <tr>
                                <td class="fw-semibold"><?= esc(strlen($judul) > 70 ? substr($judul, 0, 70) . '...' : $judul) ?></td>
                                <td>
                                    <span class="badge bg-<?= esc($priorityClass) ?>">
                                        <?= esc(ucfirst($p['prioritas'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= esc(date('d-m-Y', strtotime($p['tanggal_mulai']))) ?>
                                    s/d
                                    <?= esc(date('d-m-Y', strtotime($p['tanggal_selesai']))) ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= ($p['status'] ?? '') === 'aktif' ? 'success' : 'secondary' ?>">
                                        <?= esc(ucfirst($p['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="<?= base_url('pengumuman/edit/' . $p['id']) ?>" class="btn btn-warning btn-sm">
                                            <i class="ti ti-edit"></i>
                                            Edit
                                        </a>
                                        <a href="<?= base_url('pengumuman/hapus/' . $p['id']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Hapus pengumuman ini?')">
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
