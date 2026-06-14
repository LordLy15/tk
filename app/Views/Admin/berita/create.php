<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= base_url('admin/berita') ?>" class="btn btn-light mb-3">
        <i class="ti ti-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">
            <i class="ti ti-plus me-2 text-primary"></i>
            Tambah Berita / Kegiatan Baru
        </h5>
    </div>
    <div class="card-body p-4">
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

        <form action="<?= base_url('admin/berita/simpan') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Berita / Kegiatan *</label>
                        <input type="text" name="judul" class="form-control" value="<?= old('judul') ?>" required placeholder="Ketik judul berita atau kegiatan...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konten / Isi Lengkap *</label>
                        <textarea name="konten" id="editor" class="form-control" placeholder="Tulis isi berita atau kegiatan secara lengkap..."><?= old('konten') ?></textarea>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card bg-light border-0 p-3 mb-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori *</label>
                            <select name="kategori" class="form-select" required>
                                <option value="Berita" <?= old('kategori') === 'Berita' ? 'selected' : '' ?>>Berita / Artikel</option>
                                <option value="Kegiatan" <?= old('kategori') === 'Kegiatan' ? 'selected' : '' ?>>Kegiatan / Acara</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Pelaksanaan / Rilis *</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                            <div class="form-text">Tanggal rilis berita atau pelaksanaan kegiatan.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar Sampul (Cover) *</label>
                            <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
                            <div class="form-text">Format JPG/PNG/WEBP, maksimal 5MB. Rasio landscape disarankan.</div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 py-2">
                    <i class="ti ti-device-floppy me-2"></i> Simpan
                </button>
                <a href="<?= base_url('admin/berita') ?>" class="btn btn-light px-4 py-2">Batal</a>
            </div>
        </form>
    </div>
</div>

<!-- Load CKEditor 5 from CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ]
        })
        .catch(error => {
            console.error(error);
        });
</script>

<style>
    .ck-editor__editable_inline {
        min-height: 300px;
    }
</style>
<?= $this->endSection() ?>
