<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<?php $isEdit = isset($fasilitas); ?>

<div class="crud-page-header">
    <div>
        <h1><?= $isEdit ? 'Edit' : 'Tambah' ?> Fasilitas</h1>
        <p>Kelola inventaris fasilitas sekolah, kondisi, dan lokasi penyimpanan.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('fasilitas') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Fasilitas Sekolah</h2>
                <p class="card-subtitle">Catatan kondisi membantu rekap fasilitas lebih akurat.</p>
            </div>
        </div>

        <div class="card-body">
            <form method="post" action="<?= $isEdit ? base_url('fasilitas/update/' . $fasilitas['id']) : base_url('fasilitas/simpan') ?>">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="nama_fasilitas" class="form-label">Nama Fasilitas <span class="required-mark">*</span></label>
                        <input id="nama_fasilitas"
                               type="text"
                               name="nama_fasilitas"
                               class="form-control"
                               value="<?= esc(old('nama_fasilitas', $fasilitas['nama_fasilitas'] ?? '')) ?>"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label for="jenis_fasilitas" class="form-label">Jenis <span class="required-mark">*</span></label>
                        <?php $jenis = old('jenis_fasilitas', $fasilitas['jenis_fasilitas'] ?? ''); ?>
                        <select id="jenis_fasilitas" name="jenis_fasilitas" class="form-select" required>
                            <option value="">Pilih Jenis</option>
                            <option value="ruangan" <?= $jenis === 'ruangan' ? 'selected' : '' ?>>Ruangan</option>
                            <option value="alat_pembelajaran" <?= $jenis === 'alat_pembelajaran' ? 'selected' : '' ?>>Alat Pembelajaran</option>
                            <option value="alat_olahraga" <?= $jenis === 'alat_olahraga' ? 'selected' : '' ?>>Alat Olahraga</option>
                            <option value="alat_musik" <?= $jenis === 'alat_musik' ? 'selected' : '' ?>>Alat Musik</option>
                            <option value="lainnya" <?= $jenis === 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="jumlah" class="form-label">Jumlah <span class="required-mark">*</span></label>
                        <input id="jumlah"
                               type="number"
                               name="jumlah"
                               class="form-control"
                               min="1"
                               value="<?= esc(old('jumlah', $fasilitas['jumlah'] ?? 1)) ?>"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label for="kondisi" class="form-label">Kondisi <span class="required-mark">*</span></label>
                        <?php $kondisi = old('kondisi', $fasilitas['kondisi'] ?? 'baik'); ?>
                        <select id="kondisi" name="kondisi" class="form-select" required>
                            <option value="baik" <?= $kondisi === 'baik' ? 'selected' : '' ?>>Baik</option>
                            <option value="cukup" <?= $kondisi === 'cukup' ? 'selected' : '' ?>>Cukup</option>
                            <option value="rusak" <?= $kondisi === 'rusak' ? 'selected' : '' ?>>Rusak</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input id="lokasi"
                               type="text"
                               name="lokasi"
                               class="form-control"
                               value="<?= esc(old('lokasi', $fasilitas['lokasi'] ?? '')) ?>"
                               placeholder="Contoh: Ruang Kelas A">
                    </div>

                    <div class="col-12">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea id="catatan"
                                  name="catatan"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Riwayat perawatan, kondisi detail, atau kebutuhan penggantian"><?= esc(old('catatan', $fasilitas['catatan'] ?? '')) ?></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('fasilitas') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Simpan Fasilitas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
