<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-book me-2"></i>
            Manajemen E-Book
        </h4>
        <p class="text-muted mb-0">Kelola koleksi e-book untuk siswa</p>
    </div>
    <a href="<?= base_url('admin/ebook/tambah') ?>" class="btn btn-primary">
        <i class="ti ti-plus me-2"></i> Tambah E-Book
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($ebooks)) : ?>
            <div class="text-center py-5">
                <i class="ti ti-book-off" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h5 class="mt-3 mb-1">Belum Ada E-Book</h5>
                <p class="text-muted">Tambahkan e-book pertama Anda.</p>
                <a href="<?= base_url('admin/ebook/tambah') ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-2"></i> Tambah E-Book
                </a>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">Cover</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Kelas</th>
                             <th class="action-cell text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ebooks as $e) : ?>
                            <tr>
                                <td>
                                    <?php if ($e['cover']) : ?>
                                        <img src="<?= base_url('writable/uploads/ebook/cover/' . $e['cover']) ?>"
                                             alt="<?= esc($e['judul']) ?>"
                                             class="rounded"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else : ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width: 50px; height: 50px;">
                                            <i class="ti ti-book text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= esc($e['judul']) ?></strong>
                                </td>
                                <td><?= esc($e['penulis'] ?? '-') ?></td>
                                <td>
                                    <?= $e['kategori']
                                        ? '<span class="badge bg-secondary">' . esc($e['kategori']) . '</span>'
                                        : '-'; ?>
                                </td>
                                <td><?= esc($e['kelas'] ?? '-') ?></td>
                                <td class="action-cell">
                                    <div class="table-actions">
                                        <?php if ($e['file_path']) : ?>
                                            <a href="<?= base_url('ebook/download/' . $e['id']) ?>"
                                               target="_blank"
                                               class="btn btn-info btn-sm action-icon-btn"
                                               title="Unduh E-Book">
                                                <i class="ti ti-download"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('admin/ebook/edit/' . $e['id']) ?>"
                                           class="btn btn-warning btn-sm action-icon-btn"
                                           title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/ebook/hapus/' . $e['id']) ?>"
                                           class="btn btn-danger btn-sm action-icon-btn"
                                           onclick="return confirm('Yakin hapus e-book ini?')"
                                           title="Hapus">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </div>
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