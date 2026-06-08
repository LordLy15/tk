<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= base_url('admin/spay-orang-tua') ?>" class="btn btn-light mb-3">
        <i class="ti ti-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="fw-bold mb-0">
            <i class="ti ti-user-plus me-2"></i>
            Tambah Akun Orang Tua
        </h5>
    </div>
    <div class="card-body">
        <?= form_open(base_url('admin/spay-orang-tua/simpan')) ?>
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nama Orang Tua *</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                    <div class="form-text">Minimal 6 karakter</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Pilih Siswa (Opsional)</label>
                    <select name="murid_id" id="murid_id" class="form-select">
                        <option value="">-- Pilih Siswa --</option>
                        <?php foreach ($murid_list as $m) : ?>
                            <option value="<?= $m['id'] ?>">
                                <?= esc($m['nama_murid']) ?> - <?= esc($m['nama_kelas'] ?? 'Tanpa Kelas') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">Pilih siswa untuk otomatis mengisi nama dan kelas</div>
                </div>

                <div class="alert alert-info">
                    <i class="ti ti-info-circle me-2"></i>
                    <strong>Info:</strong> Jika Anda memilih siswa, nama dan kelas akan otomatis terisi. Anda juga bisa mengisi manual tanpa memilih siswa.
                </div>
            </div>
        </div>

        <hr>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-device-floppy me-2"></i> Simpan
            </button>
            <a href="<?= base_url('admin/spay-orang-tua') ?>" class="btn btn-light">Batal</a>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection() ?>