<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-users me-2"></i>
            Akun Orang Tua (Pembayaran)
        </h4>
        <p class="text-muted mb-0">Kelola akun orang tua untuk sistem pembayaran</p>
    </div>
    <a href="<?= base_url('admin/spay-orang-tua/tambah') ?>" class="btn btn-primary">
        <i class="ti ti-plus me-2"></i> Tambah Akun
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($orang_tua)) : ?>
            <div class="text-center py-5">
                <i class="ti ti-users" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h5 class="mt-3 mb-1">Belum Ada Akun</h5>
                <p class="text-muted">Tambahkan akun orang tua pertama Anda.</p>
                <a href="<?= base_url('admin/spay-orang-tua/tambah') ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-2"></i> Tambah Akun
                </a>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Orang Tua</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Status</th>
                             <th class="action-cell text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orang_tua as $i => $ot) : ?>
                            <?php if ($ot['is_active']) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><strong><?= esc($ot['nama']) ?></strong></td>
                                    <td><?= esc($ot['email']) ?></td>
                                    <td><?= esc($ot['no_hp'] ?? '-') ?></td>
                                    <td><?= esc($ot['nama_siswa'] ?? '-') ?></td>
                                    <td><?= esc($ot['kelas'] ?? '-') ?></td>
                                    <td>
                                        <?php if ($ot['is_active']) : ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else : ?>
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="action-cell">
                                        <div class="table-actions">
                                            <a href="<?= base_url('admin/spay-orang-tua/edit/' . $ot['id']) ?>"
                                               class="btn btn-warning btn-sm action-icon-btn"
                                               title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="<?= base_url('admin/spay-orang-tua/hapus/' . $ot['id']) ?>"
                                               class="btn btn-danger btn-sm action-icon-btn"
                                               onclick="return confirm('Yakin nonaktifkan akun ini?')"
                                               title="Hapus">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>