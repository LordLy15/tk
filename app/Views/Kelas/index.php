<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Data Kelas</h1>
        <p>Daftar kelas aktif, jenjang pendidikan, dan wali kelas.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('kelas/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Kelas
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
                        <th>Nama Kelas</th>
                        <th>Pendidikan</th>
                        <th>Wali Kelas</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kelas)) : ?>
                        <tr>
                            <td colspan="5" class="empty-state">Belum ada data kelas.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($kelas as $k) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-semibold"><?= esc($k['nama_kelas']) ?></td>
                                <td><?= esc($k['nama'] ?? '-') ?></td>
                                <td><?= esc($k['nama_guru'] ?? '-') ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="<?= base_url('kelas/edit/' . $k['id_kelas']) ?>" class="btn btn-warning btn-sm">
                                            <i class="ti ti-edit"></i>
                                            Edit
                                        </a>
                                        <a href="<?= base_url('kelas/hapus/' . $k['id_kelas']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Hapus data kelas ini?')">
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
