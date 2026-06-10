<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<?php $isEdit = isset($jadwal); ?>

<div class="crud-page-header">
    <div>
        <h1><?= $isEdit ? 'Edit' : 'Tambah' ?> Jadwal Kelas</h1>
        <p>Atur hari, jam belajar, aktivitas, dan ruangan kelas.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('jadwal') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Jadwal Kelas</h2>
                <p class="card-subtitle">Gunakan rentang waktu yang jelas agar jadwal mudah dibaca.</p>
            </div>
        </div>

        <div class="card-body">
            <form method="post" action="<?= $isEdit ? base_url('jadwal/update/' . $jadwal['id']) : base_url('jadwal/simpan') ?>">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="id_kelas" class="form-label">Kelas <span class="required-mark">*</span></label>
                        <select id="id_kelas" name="id_kelas" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            <?php foreach ($kelas_list ?? [] as $k) : ?>
                                <?php $selectedKelas = old('id_kelas', $jadwal['id_kelas'] ?? '') == $k['id_kelas']; ?>
                                <option value="<?= esc($k['id_kelas']) ?>" <?= $selectedKelas ? 'selected' : '' ?>>
                                    <?= esc($k['nama_kelas']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="hari" class="form-label">Hari <span class="required-mark">*</span></label>
                        <select id="hari" name="hari" class="form-select" required>
                            <option value="">Pilih Hari</option>
                            <?php foreach ($hari_list ?? [] as $h) : ?>
                                <option value="<?= esc($h) ?>" <?= old('hari', $jadwal['hari'] ?? '') === $h ? 'selected' : '' ?>>
                                    <?= esc($h) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="jam_masuk" class="form-label">Jam Masuk <span class="required-mark">*</span></label>
                        <input id="jam_masuk"
                               type="time"
                               name="jam_masuk"
                               class="form-control"
                               value="<?= esc(old('jam_masuk', $jadwal['jam_masuk'] ?? '')) ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="jam_keluar" class="form-label">Jam Keluar <span class="required-mark">*</span></label>
                        <input id="jam_keluar"
                               type="time"
                               name="jam_keluar"
                               class="form-control"
                               value="<?= esc(old('jam_keluar', $jadwal['jam_keluar'] ?? '')) ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="aktivitas" class="form-label">Aktivitas</label>
                        <input id="aktivitas"
                               type="text"
                               name="aktivitas"
                               class="form-control"
                               value="<?= esc(old('aktivitas', $jadwal['aktivitas'] ?? '')) ?>"
                               placeholder="Contoh: Belajar Membaca">
                    </div>

                    <div class="col-md-6">
                        <label for="ruangan" class="form-label">Ruangan</label>
                        <input id="ruangan"
                               type="text"
                               name="ruangan"
                               class="form-control"
                               value="<?= esc(old('ruangan', $jadwal['ruangan'] ?? '')) ?>"
                               placeholder="Contoh: Ruang Kelas A1">
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('jadwal') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
