<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Data Guru</h1>
        <p>Kelola pengajar, wali kelas, dan kualifikasi pendidikan.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('guru/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Guru
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
                        <th>Nama Guru</th>
                        <th>NIP/NIK</th>
                        <th>Jabatan</th>
                        <th>Pendidikan</th>
                        <th class="action-cell text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($guru)) : ?>
                        <tr>
                            <td colspan="6" class="empty-state">Belum ada data guru.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($guru as $g) : ?>
                            <tr>
                                <td><?= $no++ ?></td>

                                <td class="fw-semibold"><?= esc($g['nama_guru']) ?></td>
                                <td><span class="badge badge-soft"><?= esc($g['nip_nik']) ?></span></td>
                                <td><?= esc($g['jabatan']) ?></td>
                                <td><?= esc($g['pendidikan']) ?></td>
                                <td class="action-cell">
                                    <div class="table-actions">
                                        <a href="<?= base_url('guru/detail/' . $g['id']) ?>"
                                           class="btn btn-info btn-sm action-icon-btn"
                                           title="Detail guru"
                                           aria-label="Detail <?= esc($g['nama_guru'], 'attr') ?>">
                                            <i class="ti ti-eye"></i>
                                            <span class="visually-hidden">Detail</span>
                                        </a>
                                        <a href="<?= base_url('guru/edit/' . $g['id']) ?>"
                                           class="btn btn-warning btn-sm action-icon-btn"
                                           title="Edit guru"
                                           aria-label="Edit <?= esc($g['nama_guru'], 'attr') ?>">
                                            <i class="ti ti-edit"></i>
                                            <span class="visually-hidden">Edit</span>
                                        </a>
                                        <a href="<?= base_url('guru/hapus/' . $g['id']) ?>"
                                           class="btn btn-danger btn-sm action-icon-btn"
                                           title="Hapus guru"
                                           aria-label="Hapus <?= esc($g['nama_guru'], 'attr') ?>"
                                           onclick="return confirm('Hapus data guru ini?')">
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
