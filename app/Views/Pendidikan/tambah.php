<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Tambah Pendidikan</h1>
        <p>Tambahkan jenjang atau program pendidikan untuk pengelompokan kelas.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('pendidikan') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Pendidikan</h2>
                <p class="card-subtitle">Contoh: KB, TK A, TK B, atau program khusus.</p>
            </div>
        </div>

        <div class="card-body">
            <form action="<?= base_url('pendidikan/simpan') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="nama" class="form-label">Nama Pendidikan <span class="required-mark">*</span></label>
                        <input id="nama"
                               type="text"
                               name="nama"
                               class="form-control"
                               value="<?= esc(old('nama')) ?>"
                               required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('pendidikan') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Simpan Pendidikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
