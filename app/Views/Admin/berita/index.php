<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-news me-2"></i>
            Manajemen Berita & Kegiatan
        </h4>
        <p class="text-muted mb-0">Kelola informasi berita dan kegiatan sekolah untuk konsumsi publik</p>
    </div>
    <a href="<?= base_url('admin/berita/tambah') ?>" class="btn btn-primary">
        <i class="ti ti-plus me-2"></i> Tambah Berita / Kegiatan
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($berita)) : ?>
            <div class="text-center py-5">
                <i class="ti ti-news-off" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h5 class="mt-3 mb-1">Belum Ada Berita atau Kegiatan</h5>
                <p class="text-muted">Tambahkan pengumuman, artikel berita, atau dokumentasi kegiatan pertama Anda.</p>
                <a href="<?= base_url('admin/berita/tambah') ?>" class="btn btn-primary">
                    <i class="ti ti-plus me-2"></i> Tambah Pertama
                </a>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 120px;">Gambar</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Penulis</th>
                             <th class="action-cell text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($berita as $b) : ?>
                            <tr>
                                <td>
                                    <?php if ($b['gambar']) : ?>
                                        <img src="<?= base_url('uploads/berita/' . esc($b['gambar'])) ?>"
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
                                    <strong class="d-block"><?= esc($b['judul']) ?></strong>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 300px;">
                                        <?php
                                            $clean_content = preg_replace('/<[^>]+>/', ' ', $b['konten']);
                                            $clean_content = html_entity_decode($clean_content);
                                            $clean_content = preg_replace('/\s+/', ' ', $clean_content);
                                            $clean_content = trim($clean_content);
                                            echo esc(substr($clean_content, 0, 80)) . (strlen($clean_content) > 80 ? '...' : '');
                                        ?>
                                    </small>
                                </td>
                                <td>
                                    <?php if ($b['kategori'] === 'Berita') : ?>
                                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                            <i class="ti ti-article me-1"></i> Berita
                                        </span>
                                    <?php else : ?>
                                        <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">
                                            <i class="ti ti-calendar-event me-1"></i> Kegiatan
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="fw-semibold">
                                        <?= date('d M Y', strtotime($b['tanggal'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted"><i class="ti ti-user me-1"></i><?= esc($b['penulis']) ?></span>
                                </td>
                                <td class="action-cell">
                                    <div class="table-actions">
                                        <a href="<?= base_url('berita/' . $b['slug']) ?>"
                                           target="_blank"
                                           class="btn btn-info btn-sm action-icon-btn"
                                           title="Lihat Halaman Publik">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/berita/edit/' . $b['id']) ?>"
                                           class="btn btn-warning btn-sm action-icon-btn"
                                           title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/berita/hapus/' . $b['id']) ?>"
                                           class="btn btn-danger btn-sm action-icon-btn"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus berita/kegiatan ini?')"
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
