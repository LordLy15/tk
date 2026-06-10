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
            <i class="ti ti-plus me-2"></i>
            Tambah Tagihan Baru
        </h5>
    </div>
    <div class="card-body">
        <?= form_open(base_url('admin/spay-tagihan/simpan')) ?>
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Orang Tua *</label>
                    <select name="orang_tua_id" class="form-select" required>
                        <option value="">-- Pilih Orang Tua --</option>
                        <?php foreach ($orang_tua_list as $ot) : ?>
                            <option value="<?= $ot['id'] ?>">
                                <?= esc($ot['nama']) ?>
                                <?php if (!empty($ot['nama_siswa'])) : ?>
                                    (<?= esc($ot['nama_siswa']) ?><?= !empty($ot['kelas']) ? ' - ' . esc($ot['kelas']) : '' ?>)
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">Pilih akun orang tua yang akan ditagih</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Tagihan *</label>
                    <input type="text" name="judul" class="form-control"
                           placeholder="Contoh: SPP Bulan Juni 2026" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nominal *</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" name="nominal" class="form-control"
                               placeholder="250.000" required id="nominal-input">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Batas Pembayaran</label>
                    <input type="date" name="batas_bayar" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <div class="input-group">
                        <select name="kategori_select" id="kategori_select" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="SPP">SPP</option>
                            <option value="Seragam">Seragam</option>
                            <option value="Kegiatan">Kegiatan</option>
                            <option value="Buku">Buku</option>
                            <option value="Ujian">Ujian</option>
                            <option value="Lainnya">Lainnya</option>
                            <option value="__other__">+ Tambah Baru</option>
                        </select>
                    </div>
                    <input type="text" name="kategori_input" id="kategori_input" class="form-control mt-2"
                           placeholder="Ketik nama kategori baru..."
                           style="display: none;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="4"
                              placeholder="Contoh: SPP bulanan untuk bulan Juni 2026"></textarea>
                </div>
            </div>
        </div>

        <hr>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-device-floppy me-2"></i> Simpan
            </button>
            <a href="<?= base_url('admin/spay-tagihan') ?>" class="btn btn-light">Batal</a>
        </div>
        <?= form_close() ?>
    </div>
</div>

<script>
// Handle kategori dropdown
document.getElementById('kategori_select').addEventListener('change', function() {
    var input = document.getElementById('kategori_input');
    if (this.value === '__other__') {
        input.style.display = 'block';
        input.focus();
    } else {
        input.style.display = 'none';
    }
});

// Format nominal input
document.getElementById('nominal-input').addEventListener('blur', function() {
    var value = this.value.replace(/[^\d]/g, '');
    if (value) {
        this.value = parseInt(value).toLocaleString('id-ID');
    }
});
</script>
<?= $this->endSection() ?>