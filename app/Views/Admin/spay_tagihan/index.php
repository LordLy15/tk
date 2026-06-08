<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-receipt me-2"></i>
            Manajemen Tagihan
        </h4>
        <p class="text-muted mb-0">Kelola tagihan untuk akun orang tua</p>
    </div>
    <a href="<?= base_url('admin/spay-tagihan/tambah') ?>" class="btn btn-primary">
        <i class="ti ti-plus me-2"></i> Tambah Tagihan
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
        <?php if (empty($tagihan)) : ?>
            <div class="text-center py-5">
                <i class="ti ti-receipt" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h5 class="mt-3 mb-1">Belum Ada Tagihan</h5>
                <p class="text-muted">Tambahkan tagihan pertama Anda.</p>
                <a href="<?= base_url('admin/spay-tagihan/tambah') ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-2"></i> Tambah Tagihan
                </a>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul Tagihan</th>
                            <th>Kategori</th>
                            <th>Orang Tua</th>
                            <th>Siswa</th>
                            <th>Nominal</th>
                            <th>Batas Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tagihan as $i => $t) : ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><strong><?= esc($t['judul']) ?></strong></td>
                                <td>
                                    <?php if (!empty($t['kategori'])) : ?>
                                        <span class="badge bg-info"><?= esc($t['kategori']) ?></span>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($t['nama_ortu'] ?? '-') ?></td>
                                <td><?= esc($t['nama_siswa'] ?? '-') ?></td>
                                <td><strong>Rp <?= number_format($t['nominal'], 0, ',', '.') ?></strong></td>
                                <td>
                                    <?= $t['batas_bayar'] ? date('d M Y', strtotime($t['batas_bayar'])) : '-' ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/spay-tagihan/edit/' . $t['id']) ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/spay-tagihan/hapus/' . $t['id']) ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Yakin hapus tagihan ini?')">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>