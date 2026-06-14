<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= base_url('admin/banner') ?>" class="btn btn-light mb-3">
        <i class="ti ti-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="fw-bold mb-0">
            <i class="ti ti-edit me-2"></i>
            Edit Banner Berita
        </h5>
    </div>
    <div class="card-body">


        <?php if (session('errors')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/banner/update/' . $banner['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Judul Berita / Banner *</label>
                        <input type="text" name="judul" class="form-control" value="<?= old('judul', $banner['judul']) ?>" required placeholder="Ketik judul banner...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Singkat</label>
                        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Ketik deskripsi singkat banner berita..."><?= old('deskripsi', $banner['deskripsi']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tautan URL Berita (opsional)</label>
                        <input type="url" name="link_url" class="form-control" value="<?= old('link_url', $banner['link_url']) ?>" placeholder="https://example.com/berita-lengkap">
                        <div class="form-text">Tautan opsional jika pengguna ingin membaca berita selengkapnya.</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Gambar Banner</label>
                        <?php if ($banner['gambar']) : ?>
                            <div class="mb-2">
                                <img src="<?= base_url('uploads/banners/' . esc($banner['gambar'])) ?>" alt="Banner Saat Ini" class="img-fluid rounded border shadow-sm" style="max-height: 150px; object-fit: cover;">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengganti gambar. JPG/PNG/WEBP, maksimal 5MB.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Banner</label>
                        <select name="is_active" class="form-select">
                            <option value="1" <?= old('is_active', $banner['is_active']) == 1 ? 'selected' : '' ?>>Aktif (Tampilkan)</option>
                            <option value="0" <?= old('is_active', $banner['is_active']) == 0 ? 'selected' : '' ?>>Nonaktif (Sembunyikan)</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-2"></i> Perbarui Banner
                </button>
                <a href="<?= base_url('admin/banner') ?>" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
