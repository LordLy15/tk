<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<?php $isEdit = isset($libur); ?>

<div class="crud-page-header">
    <div>
        <h1><?= $isEdit ? 'Edit' : 'Tambah' ?> Libur Sekolah</h1>
        <p>Catat libur nasional, lokal, cuti bersama, atau agenda sekolah.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('libur') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Libur Sekolah</h2>
                <p class="card-subtitle">Tanggal libur akan mempengaruhi tampilan input kehadiran.</p>
            </div>
        </div>

        <div class="card-body">
            <form method="post" action="<?= $isEdit ? base_url('libur/update/' . $libur['id']) : base_url('libur/simpan') ?>">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="nama_libur" class="form-label">Nama Libur <span class="required-mark">*</span></label>
                        <input id="nama_libur"
                               type="text"
                               name="nama_libur"
                               class="form-control"
                               value="<?= esc(old('nama_libur', $libur['nama_libur'] ?? '')) ?>"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label for="jenis_libur" class="form-label">Jenis Libur <span class="required-mark">*</span></label>
                        <?php $jenis = old('jenis_libur', $libur['jenis_libur'] ?? ''); ?>
                        <select id="jenis_libur" name="jenis_libur" class="form-select" required>
                            <option value="">Pilih Jenis</option>
                            <option value="nasional" <?= $jenis === 'nasional' ? 'selected' : '' ?>>Nasional</option>
                            <option value="lokal" <?= $jenis === 'lokal' ? 'selected' : '' ?>>Lokal</option>
                            <option value="cuti_bersama" <?= $jenis === 'cuti_bersama' ? 'selected' : '' ?>>Cuti Bersama</option>
                            <option value="akhir_tahun" <?= $jenis === 'akhir_tahun' ? 'selected' : '' ?>>Akhir Tahun</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="required-mark">*</span></label>
                        <input id="tanggal_mulai"
                               type="date"
                               name="tanggal_mulai"
                               class="form-control"
                               value="<?= esc(old('tanggal_mulai', $libur['tanggal_mulai'] ?? '')) ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="required-mark">*</span></label>
                        <input id="tanggal_selesai"
                               type="date"
                               name="tanggal_selesai"
                               class="form-control"
                               value="<?= esc(old('tanggal_selesai', $libur['tanggal_selesai'] ?? '')) ?>"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label">Status <span class="required-mark">*</span></label>
                        <?php $status = old('status', $libur['status'] ?? 'aktif'); ?>
                        <select id="status" name="status" class="form-select" required>
                            <option value="aktif" <?= $status === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= $status === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan"
                                  name="keterangan"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Catatan tambahan untuk libur ini"><?= esc(old('keterangan', $libur['keterangan'] ?? '')) ?></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('libur') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Simpan Libur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
