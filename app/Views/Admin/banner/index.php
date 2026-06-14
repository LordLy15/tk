<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-photo me-2"></i>
            Manajemen Banner Berita
        </h4>
        <p class="text-muted mb-0">Kelola banner berita otomatis untuk halaman depan</p>
    </div>
    <a href="<?= base_url('admin/banner/tambah') ?>" class="btn btn-primary">
        <i class="ti ti-plus me-2"></i> Tambah Banner
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($banners)) : ?>
            <div class="text-center py-5">
                <i class="ti ti-photo-off" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h5 class="mt-3 mb-1">Belum Ada Banner</h5>
                <p class="text-muted">Tambahkan banner berita pertama Anda untuk ditampilkan di homepage.</p>
                <a href="<?= base_url('admin/banner/tambah') ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-2"></i> Tambah Banner
                </a>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 120px;">Gambar</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Tautan URL</th>
                            <th style="width: 100px;">Status</th>
                             <th class="action-cell text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($banners as $b) : ?>
                            <tr>
                                <td>
                                    <?php if ($b['gambar']) : ?>
                                        <img src="<?= base_url('uploads/banners/' . esc($b['gambar'])) ?>"
                                             alt="<?= esc($b['judul']) ?>"
                                             class="rounded shadow-sm"
                                             style="width: 100px; height: 60px; object-fit: cover;">
                                    <?php else : ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width: 100px; height: 60px;">
                                            <i class="ti ti-photo text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= esc($b['judul']) ?></strong>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 250px;">
                                        <?= esc($b['deskripsi'] ?? '-') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($b['link_url']) : ?>
                                        <a href="<?= esc($b['link_url']) ?>" target="_blank" class="text-decoration-none text-truncate d-inline-block" style="max-width: 200px;">
                                            <i class="ti ti-link me-1"></i><?= esc($b['link_url']) ?>
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($b['is_active'] == 1) : ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-cell">
                                    <div class="table-actions">
                                        <?php if ($b['gambar']) : ?>
                                            <a href="<?= base_url('uploads/banners/' . esc($b['gambar'])) ?>"
                                               target="_blank"
                                               class="btn btn-info btn-sm action-icon-btn"
                                               title="Lihat Gambar">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('admin/banner/edit/' . $b['id']) ?>"
                                           class="btn btn-warning btn-sm action-icon-btn"
                                           title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/banner/hapus/' . $b['id']) ?>"
                                           class="btn btn-danger btn-sm action-icon-btn"
                                           onclick="return confirm('Yakin hapus banner ini?')"
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
