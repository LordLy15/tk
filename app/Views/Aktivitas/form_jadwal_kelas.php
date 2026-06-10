<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Tambah Jadwal Aktivitas Kelas</h1>
        <p>Hubungkan aktivitas pembelajaran dengan kelas dan tanggal pelaksanaan.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('aktivitas/jadwal-kelas') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Jadwal Aktivitas</h2>
                <p class="card-subtitle">Catat hasil pembelajaran setelah aktivitas selesai.</p>
            </div>
        </div>

        <div class="card-body">
            <form method="post" action="<?= base_url('aktivitas/simpan-jadwal-kelas') ?>">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="id_kelas" class="form-label">Kelas <span class="required-mark">*</span></label>
                        <select id="id_kelas" name="id_kelas" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            <?php foreach ($kelas_list ?? [] as $k) : ?>
                                <option value="<?= esc($k['id_kelas']) ?>" <?= old('id_kelas') == $k['id_kelas'] ? 'selected' : '' ?>>
                                    <?= esc($k['nama_kelas']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="id_aktivitas" class="form-label">Aktivitas <span class="required-mark">*</span></label>
                        <select id="id_aktivitas" name="id_aktivitas" class="form-select" required>
                            <option value="">Pilih Aktivitas</option>
                            <?php foreach ($aktivitas_list ?? [] as $a) : ?>
                                <option value="<?= esc($a['id']) ?>" <?= old('id_aktivitas') == $a['id'] ? 'selected' : '' ?>>
                                    <?= esc($a['judul_aktivitas']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="tanggal" class="form-label">Tanggal <span class="required-mark">*</span></label>
                        <input id="tanggal"
                               type="date"
                               name="tanggal"
                               class="form-control"
                               value="<?= esc(old('tanggal', date('Y-m-d'))) ?>"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input id="waktu_mulai"
                               type="time"
                               name="waktu_mulai"
                               class="form-control"
                               value="<?= esc(old('waktu_mulai')) ?>">
                    </div>

                    <div class="col-md-4">
                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                        <input id="waktu_selesai"
                               type="time"
                               name="waktu_selesai"
                               class="form-control"
                               value="<?= esc(old('waktu_selesai')) ?>">
                    </div>

                    <div class="col-12">
                        <label for="hasil_pembelajaran" class="form-label">Hasil Pembelajaran</label>
                        <textarea id="hasil_pembelajaran"
                                  name="hasil_pembelajaran"
                                  class="form-control"
                                  rows="3"><?= esc(old('hasil_pembelajaran')) ?></textarea>
                    </div>

                    <div class="col-12">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea id="catatan"
                                  name="catatan"
                                  class="form-control"
                                  rows="3"><?= esc(old('catatan')) ?></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('aktivitas/jadwal-kelas') ?>" class="btn btn-light">Batal</a>
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
