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
            <i class="ti ti-edit me-2"></i>
            Edit E-Book
        </h5>
    </div>
    <div class="card-body">
        <?= form_open_multipart(base_url('admin/ebook/update/' . $ebook['id'])) ?>
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Judul *</label>
                    <input type="text" name="judul" class="form-control"
                           value="<?= esc($ebook['judul']) ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control"
                                   value="<?= esc($ebook['penulis'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <?php
                            $kategoriOptions = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'Seni', 'Olahraga', 'Agama', 'Lainnya'];
                            $existingKategori = $ebook['kategori'] ?? '';
                            $isCustomKategori = !empty($existingKategori) && !in_array($existingKategori, $kategoriOptions);
                            ?>
                            <div class="input-group">
                                <select name="kategori_select" id="kategori_select" class="form-select" onchange="toggleKategoriInput()">
                                    <option value="">-- Pilih --</option>
                                    <?php foreach ($kategoriOptions as $opt) : ?>
                                        <option value="<?= $opt ?>" <?= $existingKategori === $opt ? 'selected' : '' ?>>
                                            <?= $opt ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <option value="__other__" <?= $isCustomKategori ? 'selected' : '' ?>>+ Tambah Kategori Baru</option>
                                </select>
                            </div>
                            <input type="text" name="kategori" id="kategori_input" class="form-control mt-2"
                                   placeholder="Ketik nama kategori baru..."
                                   value="<?= $isCustomKategori ? esc($existingKategori) : '' ?>"
                                   style="<?= $isCustomKategori ? '' : 'display: none;' ?>">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas Target *</label>
                    <?php
                    $selectedKelas = !empty($ebook['kelas']) ? array_map('trim', explode(',', $ebook['kelas'])) : [];
                    ?>
                    <select name="kelas[]" class="form-select" multiple required size="4">
                        <?php foreach ($kelas_list as $k) : ?>
                            <option value="<?= esc($k['nama_kelas']) ?>" <?= in_array($k['nama_kelas'], $selectedKelas) ? 'selected' : '' ?>>
                                <?= esc($k['nama_kelas']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">Pilih satu atau lebih kelas. Tekan Ctrl/Cmd untuk memilih banyak.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"><?= esc($ebook['deskripsi'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">File PDF Baru (opsional)</label>
                    <input type="file" name="file_pdf" class="form-control" accept=".pdf">
                    <div class="form-text">Kosongkan jika tidak ganti</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cover Baru (opsional)</label>
                    <input type="file" name="cover" class="form-control" accept=".jpg,.jpeg,.png">
                    <div class="form-text">JPG/PNG, maksimal 2MB</div>
                    <?php if ($ebook['cover']) : ?>
                        <div class="mt-2">
                            <small class="text-muted">Cover saat ini:</small>
                            <img src="<?= base_url('writable/uploads/ebook/cover/' . $ebook['cover']) ?>"
                                 class="rounded mt-1" style="max-height: 100px;">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-device-floppy me-2"></i> Update
            </button>
            <a href="<?= base_url('admin/ebook') ?>" class="btn btn-light">Batal</a>
        </div>
        <?= form_close() ?>
    </div>
</div>

<script>
function toggleKategoriInput() {
    var select = document.getElementById('kategori_select');
    var input = document.getElementById('kategori_input');
    if (select.value === '__other__') {
        input.style.display = 'block';
        input.focus();
    } else {
        input.style.display = 'none';
    }
}

// Initial check
toggleKategoriInput();
</script>
<?= $this->endSection() ?>