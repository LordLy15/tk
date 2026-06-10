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
                        <th class="action-cell text-center">Aksi</th>
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
                            $status = $p['status'] ?? 'nonaktif';
                            $isActive = $status === 'aktif';
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
                                    <span class="badge bg-<?= $isActive ? 'success' : 'secondary' ?>">
                                        <?= esc(ucfirst($status)) ?>
                                    </span>
                                </td>
                                <td class="action-cell">
                                    <div class="table-actions compact-actions">
                                        <form action="<?= base_url('pengumuman/toggle-status/' . $p['id']) ?>"
                                              method="post"
                                              class="status-toggle-form">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="status" value="nonaktif">
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       role="switch"
                                                       id="status-pengumuman-<?= esc($p['id'], 'attr') ?>"
                                                       name="status"
                                                       value="aktif"
                                                       title="Ubah status pengumuman"
                                                       aria-label="Ubah status <?= esc($judul, 'attr') ?>"
                                                       onchange="this.form.submit()"
                                                       <?= $isActive ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="status-pengumuman-<?= esc($p['id'], 'attr') ?>">
                                                    <span class="visually-hidden">Ubah status pengumuman</span>
                                                </label>
                                            </div>
                                        </form>
                                        <a href="<?= base_url('pengumuman/edit/' . $p['id']) ?>"
                                           class="btn btn-warning btn-sm action-icon-btn"
                                           title="Edit pengumuman"
                                           aria-label="Edit <?= esc($judul, 'attr') ?>">
                                            <i class="ti ti-edit"></i>
                                            <span class="visually-hidden">Edit</span>
                                        </a>
                                        <a href="<?= base_url('pengumuman/hapus/' . $p['id']) ?>"
                                           class="btn btn-danger btn-sm action-icon-btn"
                                           title="Hapus pengumuman"
                                           aria-label="Hapus <?= esc($judul, 'attr') ?>"
                                           onclick="return confirm('Hapus pengumuman ini?')">
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
