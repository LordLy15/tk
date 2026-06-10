<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Daftar Pendidikan</h1>
        <p>Kelola jenjang atau program pendidikan yang tersedia.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('pendidikan/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Pendidikan
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
                        <th>Nama Pendidikan</th>
                        <th class="action-cell text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendidikan)) : ?>
                        <tr>
                            <td colspan="3" class="empty-state">Belum ada data pendidikan.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($pendidikan as $pen) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-semibold"><?= esc($pen['nama']) ?></td>
                                <td class="action-cell">
                                    <div class="table-actions">
                                        <a href="<?= base_url('pendidikan/edit/' . $pen['id_pendidikan']) ?>"
                                           class="btn btn-warning btn-sm action-icon-btn"
                                           title="Edit pendidikan"
                                           aria-label="Edit <?= esc($pen['nama'], 'attr') ?>">
                                            <i class="ti ti-edit"></i>
                                            <span class="visually-hidden">Edit</span>
                                        </a>
                                        <a href="<?= base_url('pendidikan/hapus/' . $pen['id_pendidikan']) ?>"
                                           class="btn btn-danger btn-sm action-icon-btn"
                                           title="Hapus pendidikan"
                                           aria-label="Hapus <?= esc($pen['nama'], 'attr') ?>"
                                           onclick="return confirm('Hapus data pendidikan ini?')">
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
