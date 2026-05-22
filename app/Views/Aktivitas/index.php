<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Aktivitas Pembelajaran</h1>
        <p>Kelola template aktivitas yang dapat dipakai pada jadwal kelas.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('aktivitas/jadwal-kelas') ?>" class="btn btn-light">
            <i class="ti ti-calendar"></i>
            Jadwal Aktivitas
        </a>
        <a href="<?= base_url('aktivitas/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Aktivitas
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Judul Aktivitas</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Durasi</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($aktivitas)) : ?>
                        <tr>
                            <td colspan="5" class="empty-state">Belum ada aktivitas pembelajaran.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($aktivitas as $a) : ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($a['judul_aktivitas']) ?></td>
                                <td><span class="badge badge-soft"><?= esc(ucfirst($a['jenis_aktivitas'])) ?></span></td>
                                <td><?= esc($a['kategori']) ?></td>
                                <td><?= ! empty($a['durasi_menit']) ? esc($a['durasi_menit']) . ' menit' : '-' ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="<?= base_url('aktivitas/edit/' . $a['id']) ?>" class="btn btn-warning btn-sm">
                                            <i class="ti ti-edit"></i>
                                            Edit
                                        </a>
                                        <a href="<?= base_url('aktivitas/hapus/' . $a['id']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Hapus aktivitas ini?')">
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
