<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= base_url('admin/verifikasi-pembayaran') ?>" class="btn btn-light mb-3">
        <i class="ti ti-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Detail Pembayaran -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0">
                    <i class="ti ti-receipt me-2"></i>
                    Detail Pembayaran
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Orang Tua</label>
                        <p class="fw-semibold mb-0"><?= esc($pembayaran['nama_ortu']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Siswa</label>
                        <p class="fw-semibold mb-0"><?= esc($pembayaran['nama_siswa'] ?? '-') ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Tagihan</label>
                        <p class="fw-semibold mb-0"><?= esc($pembayaran['judul']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Nominal</label>
                        <p class="fw-bold mb-0 text-primary">
                            Rp <?= number_format($pembayaran['nominal'], 0, ',', '.') ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">No. HP</label>
                        <p class="mb-0"><?= esc($pembayaran['no_hp'] ?? '-') ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Tanggal Bayar</label>
                        <p class="mb-0">
                            <?= $pembayaran['tanggal_bayar']
                                ? date('d M Y', strtotime($pembayaran['tanggal_bayar']))
                                : '-'; ?>
                        </p>
                    </div>
                    <?php if ($pembayaran['keterangan']) : ?>
                        <div class="col-12">
                            <label class="text-muted small">Keterangan</label>
                            <p class="mb-0"><?= esc($pembayaran['keterangan']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Form Verifikasi -->
        <?php if ($pembayaran['status'] === 'pending') : ?>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0">
                        <i class="ti ti-settings me-2"></i>
                        Proses Verifikasi
                    </h5>
                </div>
                <div class="card-body">
                    <?= form_open(base_url('admin/verifikasi-pembayaran/proses/' . $pembayaran['id'])) ?>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="verified">Verifikasi (Lunas)</option>
                            <option value="rejected">Tolak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3"
                                  placeholder="Masukkan catatan jika diperlukan"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-check me-2"></i> Simpan
                        </button>
                        <a href="<?= base_url('admin/verifikasi-pembayaran') ?>"
                           class="btn btn-light">
                            Batal
                        </a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        <?php else : ?>
            <div class="alert <?= $pembayaran['status'] === 'verified' ? 'alert-success' : 'alert-danger' ?>">
                <i class="ti <?= $pembayaran['status'] === 'verified' ? 'ti-check-circle' : 'ti-x-circle' ?> me-2"></i>
                Pembayaran ini sudah <?= $pembayaran['status'] === 'verified' ? 'diverifikasi' : 'ditolak' ?>.
                <?php if ($pembayaran['catatan_admin']) : ?>
                    <br><strong>Catatan:</strong> <?= esc($pembayaran['catatan_admin']) ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <!-- Bukti Bayar -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0">
                    <i class="ti ti-file me-2"></i>
                    Bukti Bayar
                </h5>
            </div>
            <div class="card-body">
                <?php if ($pembayaran['bukti_bayar']) : ?>
                    <?php $ext = strtolower(pathinfo($pembayaran['bukti_bayar'], PATHINFO_EXTENSION)); ?>
                    <?php if (in_array($ext, ['jpg', 'jpeg', 'png'])) : ?>
                        <a href="<?= base_url('writable/uploads/bukti_bayar/' . $pembayaran['bukti_bayar']) ?>"
                           target="_blank">
                            <img src="<?= base_url('writable/uploads/bukti_bayar/' . $pembayaran['bukti_bayar']) ?>"
                                 alt="Bukti Bayar"
                                 class="img-fluid rounded">
                        </a>
                    <?php else : ?>
                        <a href="<?= base_url('writable/uploads/bukti_bayar/' . $pembayaran['bukti_bayar']) ?>"
                           class="btn btn-outline-primary" target="_blank">
                            <i class="ti ti-file-pdf me-2"></i> Lihat PDF
                        </a>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="text-center text-muted py-4">
                        <i class="ti ti-file-off" style="font-size: 3rem;"></i>
                        <p class="mt-2 mb-0">Belum ada bukti bayar</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>