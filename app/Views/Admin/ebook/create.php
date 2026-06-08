<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= base_url('admin/ebook') ?>" class="btn btn-light mb-3">
        <i class="ti ti-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="fw-bold mb-0">
            <i class="ti ti-plus me-2"></i>
            Tambah E-Book Baru
        </h5>
    </div>
    <div class="card-body">
        <?= form_open_multipart(base_url('admin/ebook/simpan')) ?>
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Judul *</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <div class="input-group">
                                <select name="kategori_select" id="kategori_select" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="Matematika">Matematika</option>
                                    <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                                    <option value="Bahasa Inggris">Bahasa Inggris</option>
                                    <option value="IPA">IPA</option>
                                    <option value="IPS">IPS</option>
                                    <option value="Seni">Seni</option>
                                    <option value="Olahraga">Olahraga</option>
                                    <option value="Agama">Agama</option>
                                    <option value="__other__">+ Tambah Kategori Baru</option>
                                </select>
                            </div>
                            <input type="text" name="kategori" id="kategori_input" class="form-control mt-2"
                                   placeholder="Ketik nama kategori baru..."
                                   style="display: none;">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas Target *</label>
                    <select name="kelas[]" class="form-select" multiple required size="4">
                        <?php foreach ($kelas_list as $k) : ?>
                            <option value="<?= esc($k['nama_kelas']) ?>"><?= esc($k['nama_kelas']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">Pilih satu atau lebih kelas. Tekan Ctrl/Cmd untuk memilih banyak.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">File PDF *</label>
                    <input type="file" name="file_pdf" class="form-control"
                           accept=".pdf" required>
                    <div class="form-text">Maksimal 10MB</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cover (opsional)</label>
                    <input type="file" name="cover" class="form-control"
                           accept=".jpg,.jpeg,.png">
                    <div class="form-text">JPG/PNG, maksimal 2MB</div>
                </div>
            </div>
        </div>

        <hr>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-device-floppy me-2"></i> Simpan
            </button>
            <a href="<?= base_url('admin/ebook') ?>" class="btn btn-light">Batal</a>
        </div>
        <?= form_close() ?>
    </div>
</div>

<script>
document.getElementById('kategori_select').addEventListener('change', function() {
    var input = document.getElementById('kategori_input');
    if (this.value === '__other__') {
        input.style.display = 'block';
        input.focus();
    } else {
        input.style.display = 'none';
    }
});
</script>
<?= $this->endSection() ?>