<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<?php $isEdit = isset($pengumuman); ?>

<div class="crud-page-header">
    <div>
        <h1><?= $isEdit ? 'Edit' : 'Tambah' ?> Pengumuman</h1>
        <p>Publikasikan informasi sekolah dengan periode, prioritas, dan status yang jelas.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('pengumuman') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Pengumuman</h2>
                <p class="card-subtitle">Pengumuman aktif hanya tampil pada rentang tanggal yang dipilih.</p>
            </div>
        </div>

        <div class="card-body">
            <form method="post" action="<?= $isEdit ? base_url('pengumuman/update/' . $pengumuman['id']) : base_url('pengumuman/simpan') ?>">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-12">
                        <label for="judul" class="form-label">Judul Pengumuman <span class="required-mark">*</span></label>
                        <input id="judul"
                               type="text"
                               name="judul"
                               class="form-control"
                               value="<?= esc(old('judul', $pengumuman['judul'] ?? '')) ?>"
                               required>
                    </div>

                    <div class="col-12">
                        <label for="konten" class="form-label">Konten <span class="required-mark">*</span></label>
                        <textarea id="konten"
                                  name="konten"
                                  class="form-control"
                                  rows="6"
                                  required><?= esc(old('konten', $pengumuman['konten'] ?? '')) ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="required-mark">*</span></label>
                        <input id="tanggal_mulai"
                               type="date"
                               name="tanggal_mulai"
                               class="form-control"
                               value="<?= esc(old('tanggal_mulai', $pengumuman['tanggal_mulai'] ?? '')) ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="required-mark">*</span></label>
                        <input id="tanggal_selesai"
                               type="date"
                               name="tanggal_selesai"
                               class="form-control"
                               value="<?= esc(old('tanggal_selesai', $pengumuman['tanggal_selesai'] ?? '')) ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="prioritas" class="form-label">Prioritas <span class="required-mark">*</span></label>
                        <?php $prioritas = old('prioritas', $pengumuman['prioritas'] ?? 'normal'); ?>
                        <select id="prioritas" name="prioritas" class="form-select" required>
                            <option value="rendah" <?= $prioritas === 'rendah' ? 'selected' : '' ?>>Rendah</option>
                            <option value="normal" <?= $prioritas === 'normal' ? 'selected' : '' ?>>Normal</option>
                            <option value="tinggi" <?= $prioritas === 'tinggi' ? 'selected' : '' ?>>Tinggi</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status <span class="required-mark">*</span></label>
                        <?php $status = old('status', $pengumuman['status'] ?? 'aktif'); ?>
                        <select id="status" name="status" class="form-select" required>
                            <option value="aktif" <?= $status === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= $status === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('pengumuman') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Simpan Pengumuman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
