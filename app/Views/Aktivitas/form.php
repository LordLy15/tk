<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<?php $isEdit = isset($aktivitas); ?>

<div class="crud-page-header">
    <div>
        <h1><?= $isEdit ? 'Edit' : 'Tambah' ?> Aktivitas</h1>
        <p>Susun aktivitas pembelajaran lengkap dengan tujuan, metode, dan alat.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('aktivitas') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
       
            
        

        <div class="card-body">
            <form method="post" action="<?= $isEdit ? base_url('aktivitas/update/' . $aktivitas['id']) : base_url('aktivitas/simpan') ?>">
                <?= csrf_field() ?>

                <div class="form-section">
                    <div class="form-section-title">Informasi Aktivitas</div>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="judul_aktivitas" class="form-label">Judul Aktivitas <span class="required-mark">*</span></label>
                            <input id="judul_aktivitas"
                                   type="text"
                                   name="judul_aktivitas"
                                   class="form-control"
                                   value="<?= esc(old('judul_aktivitas', $aktivitas['judul_aktivitas'] ?? '')) ?>"
                                   required>
                        </div>

                        <div class="col-md-4">
                            <label for="durasi_menit" class="form-label">Durasi (menit)</label>
                            <input id="durasi_menit"
                                   type="number"
                                   name="durasi_menit"
                                   class="form-control"
                                   min="1"
                                   value="<?= esc(old('durasi_menit', $aktivitas['durasi_menit'] ?? '')) ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_aktivitas" class="form-label">Jenis Aktivitas <span class="required-mark">*</span></label>
                            <?php $jenis = old('jenis_aktivitas', $aktivitas['jenis_aktivitas'] ?? ''); ?>
                            <select id="jenis_aktivitas" name="jenis_aktivitas" class="form-select" required>
                                <option value="">Pilih Jenis</option>
                                <option value="pembelajaran" <?= $jenis === 'pembelajaran' ? 'selected' : '' ?>>Pembelajaran</option>
                                <option value="bermain" <?= $jenis === 'bermain' ? 'selected' : '' ?>>Bermain</option>
                                <option value="seni" <?= $jenis === 'seni' ? 'selected' : '' ?>>Seni</option>
                                <option value="olahraga" <?= $jenis === 'olahraga' ? 'selected' : '' ?>>Olahraga</option>
                                <option value="musik" <?= $jenis === 'musik' ? 'selected' : '' ?>>Musik</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="kategori" class="form-label">Kategori <span class="required-mark">*</span></label>
                            <input id="kategori"
                                   type="text"
                                   name="kategori"
                                   class="form-control"
                                   value="<?= esc(old('kategori', $aktivitas['kategori'] ?? '')) ?>"
                                   placeholder="Contoh: Literasi, Motorik, Seni"
                                   required>
                        </div>

                        <div class="col-12">
                            <label for="deskripsi" class="form-label">Deskripsi <span class="required-mark">*</span></label>
                            <textarea id="deskripsi"
                                      name="deskripsi"
                                      class="form-control"
                                      rows="4"
                                      required><?= esc(old('deskripsi', $aktivitas['deskripsi'] ?? '')) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">Detail Pembelajaran</div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="tujuan" class="form-label">Tujuan Pembelajaran</label>
                            <textarea id="tujuan"
                                      name="tujuan"
                                      class="form-control"
                                      rows="3"><?= esc(old('tujuan', $aktivitas['tujuan'] ?? '')) ?></textarea>
                        </div>

                        <div class="col-12">
                            <label for="metode" class="form-label">Metode</label>
                            <textarea id="metode"
                                      name="metode"
                                      class="form-control"
                                      rows="3"><?= esc(old('metode', $aktivitas['metode'] ?? '')) ?></textarea>
                        </div>

                        <div class="col-12">
                            <label for="bahan_alat" class="form-label">Bahan & Alat</label>
                            <textarea id="bahan_alat"
                                      name="bahan_alat"
                                      class="form-control"
                                      rows="3"><?= esc(old('bahan_alat', $aktivitas['bahan_alat'] ?? '')) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('aktivitas') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Simpan Aktivitas
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>

<?= $this->endSection() ?>
