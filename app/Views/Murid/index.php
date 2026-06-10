<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Data Murid</h1>
        <p>Kelola identitas murid, kelas, dan data dasar untuk laporan sekolah.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('murid/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Murid
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
                        <th>NISN</th>
                        <th>Nama Murid</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th class="action-cell text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($murid)) : ?>
                        <tr>
                            <td colspan="6" class="empty-state">Belum ada data murid.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($murid as $m) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><span class="badge badge-soft"><?= esc($m['nisn']) ?></span></td>
                                <td class="fw-semibold"><?= esc($m['nama_murid']) ?></td>
                                <td><?= esc($m['nama_kelas'] ?? '-') ?></td>
                                <td><?= ($m['jenis_kelamin'] ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                <td class="action-cell">
                                    <div class="table-actions">
                                        <a href="<?= base_url('murid/detail/' . $m['id']) ?>"
                                           class="btn btn-info btn-sm action-icon-btn"
                                           title="Detail murid"
                                           aria-label="Detail <?= esc($m['nama_murid'], 'attr') ?>">
                                            <i class="ti ti-eye"></i>
                                            <span class="visually-hidden">Detail</span>
                                        </a>
                                        <a href="<?= base_url('murid/edit/' . $m['id']) ?>"
                                           class="btn btn-warning btn-sm action-icon-btn"
                                           title="Edit murid"
                                           aria-label="Edit <?= esc($m['nama_murid'], 'attr') ?>">
                                            <i class="ti ti-edit"></i>
                                            <span class="visually-hidden">Edit</span>
                                        </a>
                                        <a href="<?= base_url('murid/hapus/' . $m['id']) ?>"
                                           class="btn btn-danger btn-sm action-icon-btn"
                                           title="Hapus murid"
                                           aria-label="Hapus <?= esc($m['nama_murid'], 'attr') ?>"
                                           onclick="return confirm('Hapus data murid ini?')">
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
