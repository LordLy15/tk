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
                        <th width="180">Aksi</th>
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
                                <td>
                                    <div class="table-actions">
                                        <a href="<?= base_url('pendidikan/edit/' . $pen['id_pendidikan']) ?>" class="btn btn-warning btn-sm">
                                            <i class="ti ti-edit"></i>
                                            Edit
                                        </a>
                                        <a href="<?= base_url('pendidikan/hapus/' . $pen['id_pendidikan']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Hapus data pendidikan ini?')">
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
