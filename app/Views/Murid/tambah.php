<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Tambah Murid</h1>
        <p>Lengkapi identitas murid dan alamat tempat tinggal secara terstruktur.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('murid') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Data Murid</h2>
                <p class="card-subtitle">Data ini dipakai untuk kelas dan kehadiran.</p>
            </div>
        </div>

        <div class="card-body">
            <form action="<?= base_url('murid/simpan') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-section">
                    <div class="form-section-title">Identitas Murid</div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="nisn" class="form-label">NISN <span class="required-mark">*</span></label>
                            <input id="nisn"
                                   type="text"
                                   name="nisn"
                                   class="form-control"
                                   maxlength="20"
                                   inputmode="numeric"
                                   value="<?= esc(old('nisn')) ?>"
                                   data-digit-only
                                   required>
                        </div>

                        <div class="col-md-8">
                            <label for="nama_murid" class="form-label">Nama Murid <span class="required-mark">*</span></label>
                            <input id="nama_murid"
                                   type="text"
                                   name="nama_murid"
                                   class="form-control"
                                   value="<?= esc(old('nama_murid')) ?>"
                                   placeholder="Nama lengkap murid"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="id_kelas" class="form-label">Kelas <span class="required-mark">*</span></label>
                            <select id="id_kelas" name="id_kelas" class="form-select" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas ?? [] as $k) : ?>
                                    <option value="<?= esc($k['id_kelas']) ?>" <?= old('id_kelas') == $k['id_kelas'] ? 'selected' : '' ?>>
                                        <?= esc($k['nama_kelas']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="required-mark">*</span></label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" <?= old('jenis_kelamin') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= old('jenis_kelamin') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="required-mark">*</span></label>
                            <input id="tempat_lahir"
                                   type="text"
                                   name="tempat_lahir"
                                   class="form-control"
                                   value="<?= esc(old('tempat_lahir')) ?>"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="required-mark">*</span></label>
                            <input id="tanggal_lahir"
                                   type="date"
                                   name="tanggal_lahir"
                                   class="form-control"
                                   value="<?= esc(old('tanggal_lahir')) ?>"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <?= view('Admin/partials/address_builder', [
                        'field' => 'alamat',
                        'label' => 'Alamat Murid',
                        'value' => old('alamat'),
                        'required' => true,
                    ]) ?>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('murid') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Simpan Murid
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
