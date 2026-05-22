<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<?php
$isEdit = isset($orang_tua);
$validation = session('validation') ?? ($validation ?? null);
?>

<div class="crud-page-header">
    <div>
        <h1><?= $isEdit ? 'Edit' : 'Tambah' ?> Orang Tua</h1>
        <p>Lengkapi data wali murid, kontak darurat, dan alamat keluarga.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('orang-tua') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Data Orang Tua</h2>
                <p class="card-subtitle">Data ini dipakai untuk komunikasi sekolah dengan keluarga.</p>
            </div>
        </div>

        <div class="card-body">
            <form method="post" action="<?= $isEdit ? base_url('orang-tua/update/' . $orang_tua['id']) : base_url('orang-tua/simpan') ?>">
                <?= csrf_field() ?>

<div class="form-section">
    <div class="form-section-title">
        Relasi Murid
    </div>

    <div class="row g-3">

        <div class="col-md-4">

            <label class="form-label">
                Kelas
            </label>

            <select class="form-select"
                    onchange="window.location='?kelas='+this.value">

                <option value="">
                    Pilih Kelas
                </option>

                <?php foreach($kelas as $k): ?>

                <option value="<?= $k['id_kelas'] ?>"
                    <?= ($id_kelas == $k['id_kelas']) ? 'selected' : '' ?>>

                    <?= esc($k['nama_kelas']) ?>

                </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="col-md-8">

            <label for="id_murid"
                   class="form-label">

                Pilih Murid
                <span class="required-mark">*</span>

            </label>

            <select id="id_murid"
                    name="id_murid"
                    class="form-select"
                    required>

                <option value="">
                    Pilih Murid
                </option>

                <?php foreach($murid_list as $m): ?>

                <option value="<?= $m['id'] ?>">

                    <?= esc($m['nama_murid']) ?>

                </option>

                <?php endforeach; ?>

            </select>

        </div>

    </div>
</div>

                <div class="form-section">
                    <div class="form-section-title">Data Ayah</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_ayah" class="form-label">Nama Ayah <span class="required-mark">*</span></label>
                            <input id="nama_ayah"
                                   type="text"
                                   name="nama_ayah"
                                   class="form-control"
                                   value="<?= esc(old('nama_ayah', $orang_tua['nama_ayah'] ?? '')) ?>"
                                   required>
                            <?php if ($validation && $validation->hasError('nama_ayah')) : ?>
                                <div class="text-danger small mt-1"><?= esc($validation->getError('nama_ayah')) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label for="no_hp_ayah" class="form-label">Nomor HP Ayah <span class="required-mark">*</span></label>
                            <input id="no_hp_ayah"
                                   type="tel"
                                   name="no_hp_ayah"
                                   class="form-control"
                                   maxlength="15"
                                   inputmode="numeric"
                                   value="<?= esc(old('no_hp_ayah', $orang_tua['no_hp_ayah'] ?? '')) ?>"
                                   data-digit-only
                                   required>
                            <?php if ($validation && $validation->hasError('no_hp_ayah')) : ?>
                                <div class="text-danger small mt-1"><?= esc($validation->getError('no_hp_ayah')) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                            <input id="pekerjaan_ayah"
                                   type="text"
                                   name="pekerjaan_ayah"
                                   class="form-control"
                                   value="<?= esc(old('pekerjaan_ayah', $orang_tua['pekerjaan_ayah'] ?? '')) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">Data Ibu</div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_ibu" class="form-label">Nama Ibu <span class="required-mark">*</span></label>
                            <input id="nama_ibu"
                                   type="text"
                                   name="nama_ibu"
                                   class="form-control"
                                   value="<?= esc(old('nama_ibu', $orang_tua['nama_ibu'] ?? '')) ?>"
                                   required>
                            <?php if ($validation && $validation->hasError('nama_ibu')) : ?>
                                <div class="text-danger small mt-1"><?= esc($validation->getError('nama_ibu')) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label for="no_hp_ibu" class="form-label">Nomor HP Ibu <span class="required-mark">*</span></label>
                            <input id="no_hp_ibu"
                                   type="tel"
                                   name="no_hp_ibu"
                                   class="form-control"
                                   maxlength="15"
                                   inputmode="numeric"
                                   value="<?= esc(old('no_hp_ibu', $orang_tua['no_hp_ibu'] ?? '')) ?>"
                                   data-digit-only
                                   required>
                            <?php if ($validation && $validation->hasError('no_hp_ibu')) : ?>
                                <div class="text-danger small mt-1"><?= esc($validation->getError('no_hp_ibu')) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                            <input id="pekerjaan_ibu"
                                   type="text"
                                   name="pekerjaan_ibu"
                                   class="form-control"
                                   value="<?= esc(old('pekerjaan_ibu', $orang_tua['pekerjaan_ibu'] ?? '')) ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   class="form-control"
                                   value="<?= esc(old('email', $orang_tua['email'] ?? '')) ?>"
                                   placeholder="nama@email.com">
                            <?php if ($validation && $validation->hasError('email')) : ?>
                                <div class="text-danger small mt-1"><?= esc($validation->getError('email')) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <?= view('Admin/partials/address_builder', [
                        'field' => 'alamat',
                        'label' => 'Alamat Keluarga',
                        'value' => old('alamat', $orang_tua['alamat'] ?? ''),
                        'required' => true,
                    ]) ?>
                    <?php if ($validation && $validation->hasError('alamat')) : ?>
                        <div class="text-danger small mt-2"><?= esc($validation->getError('alamat')) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('orang-tua') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
