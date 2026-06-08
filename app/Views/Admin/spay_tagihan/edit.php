<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= base_url('admin/spay-tagihan') ?>" class="btn btn-light mb-3">
        <i class="ti ti-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="fw-bold mb-0">
            <i class="ti ti-edit me-2"></i>
            Edit Tagihan
        </h5>
    </div>
    <div class="card-body">
        <?= form_open(base_url('admin/spay-tagihan/update/' . $tagihan['id'])) ?>
        <?= csrf_field() ?>

        <?php
        $kategoriOptions = ['SPP', 'Seragam', 'Kegiatan', 'Buku', 'Ujian', 'Lainnya'];
        $existingKategori = $tagihan['kategori'] ?? '';
        $isCustomKategori = !empty($existingKategori) && !in_array($existingKategori, $kategoriOptions);
        ?>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Orang Tua *</label>
                    <select name="orang_tua_id" class="form-select" required>
                        <option value="">-- Pilih Orang Tua --</option>
                        <?php foreach ($orang_tua_list as $ot) : ?>
                            <option value="<?= $ot['id'] ?>" <?= $ot['id'] == $tagihan['orang_tua_id'] ? 'selected' : '' ?>>
                                <?= esc($ot['nama']) ?>
                                <?php if (!empty($ot['nama_siswa'])) : ?>
                                    (<?= esc($ot['nama_siswa']) ?><?= !empty($ot['kelas']) ? ' - ' . esc($ot['kelas']) : '' ?>)
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Tagihan *</label>
                    <input type="text" name="judul" class="form-control"
                           value="<?= esc($tagihan['judul']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nominal *</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" name="nominal" class="form-control"
                               value="<?= number_format($tagihan['nominal'], 0, ',', '.') ?>" required id="nominal-input">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Batas Pembayaran</label>
                    <input type="date" name="batas_bayar" class="form-control"
                           value="<?= $tagihan['batas_bayar'] ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <div class="input-group">
                        <select name="kategori_select" id="kategori_select" class="form-select" onchange="toggleKategoriInput()">
                            <option value="">-- Pilih --</option>
                            <?php foreach ($kategoriOptions as $opt) : ?>
                                <option value="<?= $opt ?>" <?= $existingKategori === $opt ? 'selected' : '' ?>>
                                    <?= $opt ?>
                                </option>
                            <?php endforeach; ?>
                            <option value="__other__" <?= $isCustomKategori ? 'selected' : '' ?>>+ Tambah Baru</option>
                        </select>
                    </div>
                    <input type="text" name="kategori_input" id="kategori_input" class="form-control mt-2"
                           placeholder="Ketik nama kategori baru..."
                           value="<?= $isCustomKategori ? esc($existingKategori) : '' ?>"
                           style="<?= $isCustomKategori ? '' : 'display: none;' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="4"><?= esc($tagihan['keterangan'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <hr>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-device-floppy me-2"></i> Update
            </button>
            <a href="<?= base_url('admin/spay-tagihan') ?>" class="btn btn-light">Batal</a>
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

// Format nominal input
document.getElementById('nominal-input').addEventListener('blur', function() {
    var value = this.value.replace(/[^\d]/g, '');
    if (value) {
        this.value = parseInt(value).toLocaleString('id-ID');
    }
});

toggleKategoriInput();
</script>
<?= $this->endSection() ?>