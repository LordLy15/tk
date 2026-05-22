<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Edit Guru</h1>
        <p>Perbarui profil pengajar dan kualifikasi pendidikan.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('guru') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Edit Guru</h2>
                <p class="card-subtitle"><?= esc($guru['nama_guru'] ?? 'Data guru') ?></p>
            </div>
        </div>

        <div class="card-body">
            <form action="<?= base_url('guru/update/' . $guru['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-section">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="nama_guru" class="form-label">Nama Guru <span class="required-mark">*</span></label>
                            <input id="nama_guru"
                                   type="text"
                                   name="nama_guru"
                                   class="form-control"
                                   value="<?= esc(old('nama_guru', $guru['nama_guru'] ?? '')) ?>"
                                   required>
                        </div>

                        <div class="col-md-4">
                            <label for="nip_nik" class="form-label">NIP/NIK <span class="required-mark">*</span></label>
                            <input id="nip_nik"
                                   type="text"
                                   name="nip_nik"
                                   class="form-control"
                                   maxlength="18"
                                   inputmode="numeric"
                                   value="<?= esc(old('nip_nik', $guru['nip_nik'] ?? '')) ?>"
                                   data-digit-only
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="jabatan" class="form-label">Jabatan <span class="required-mark">*</span></label>
                            <input id="jabatan"
                                   type="text"
                                   name="jabatan"
                                   class="form-control"
                                   value="<?= esc(old('jabatan', $guru['jabatan'] ?? '')) ?>"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="pendidikan" class="form-label">Kualifikasi Pendidikan <span class="required-mark">*</span></label>
                            <input id="pendidikan"
                                   type="text"
                                   name="pendidikan"
                                   class="form-control"
                                   value="<?= esc(old('pendidikan', $guru['pendidikan'] ?? '')) ?>"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('guru') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Update Guru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
