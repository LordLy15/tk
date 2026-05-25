<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<?php
$validation = session('validation') ?? null;
?>

<div class="crud-page-header">
    <div>
        <h1>Edit Orang Tua</h1>
        <p>Ubah data wali murid dan informasi keluarga.</p>
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
            <h2 class="card-title">
                Form Edit Orang Tua
            </h2>
        </div>

        <div class="card-body">

            <form method="post"
                  action="<?= base_url('orang-tua/update/'.$orang_tua['id']) ?>">

                <?= csrf_field() ?>

                <div class="form-section">
                    <div class="form-section-title">
                        Relasi Murid
                    </div>

                    <div class="row g-3">

                        <div class="col-md-4">

                            <label for="id_kelas" class="form-label">Kelas <span class="required-mark">*</span></label>
                            <select id="id_kelas" name="id_kelas" class="form-select" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas ?? [] as $k) : ?>
                                    <?php $selectedKelas = old('id_kelas', $orang_tua['id_kelas'] ?? '') == $k['id_kelas']; ?>
                                    <option value="<?= $k['id_kelas'] ?>"
                                        <?= ($id_kelas == $k['id_kelas']) ? 'selected' : '' ?>>

                                        <?= esc($k['nama_kelas']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <div class="col-md-8">

                            <label class="form-label">
                                Pilih Murid
                            </label>

                            <select name="id_murid"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Pilih Murid
                                </option>

                                <?php foreach($murid_list as $m): ?>

                                <option value="<?= $m['id'] ?>"
                                <?= $orang_tua['id_murid']==$m['id'] ? 'selected':'' ?>>

                                    <?= esc($m['nama_murid']) ?>

                                </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                    </div>
                </div>


                <!-- DATA AYAH -->

                <div class="form-section">

                    <div class="form-section-title">
                        Data Ayah
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label>Nama Ayah</label>

                            <input type="text"
                                   name="nama_ayah"
                                   class="form-control"
                                   value="<?= old('nama_ayah',$orang_tua['nama_ayah']) ?>"
                                   required>

                        </div>

                        <div class="col-md-6">

                            <label>No HP Ayah</label>

                            <input type="text"
                                   name="no_hp_ayah"
                                   class="form-control"
                                   value="<?= old('no_hp_ayah',$orang_tua['no_hp_ayah']) ?>"
                                   required>

                        </div>

                        <div class="col-md-6">

                            <label>Pekerjaan Ayah</label>

                            <input type="text"
                                   name="pekerjaan_ayah"
                                   class="form-control"
                                   value="<?= old('pekerjaan_ayah',$orang_tua['pekerjaan_ayah']) ?>">

                        </div>

                    </div>

                </div>


                <!-- DATA IBU -->

                <div class="form-section">

                    <div class="form-section-title">
                        Data Ibu
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label>Nama Ibu</label>

                            <input type="text"
                                   name="nama_ibu"
                                   class="form-control"
                                   value="<?= old('nama_ibu',$orang_tua['nama_ibu']) ?>"
                                   required>

                        </div>

                        <div class="col-md-6">

                            <label>No HP Ibu</label>

                            <input type="text"
                                   name="no_hp_ibu"
                                   class="form-control"
                                   value="<?= old('no_hp_ibu',$orang_tua['no_hp_ibu']) ?>"
                                   required>

                        </div>

                        <div class="col-md-6">

                            <label>Pekerjaan Ibu</label>

                            <input type="text"
                                   name="pekerjaan_ibu"
                                   class="form-control"
                                   value="<?= old('pekerjaan_ibu',$orang_tua['pekerjaan_ibu']) ?>">

                        </div>

                        <div class="col-md-6">

                            <label>Email</label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="<?= old('email',$orang_tua['email']) ?>">

                        </div>

                    </div>

                </div>


                <!-- ALAMAT -->

                <div class="form-section">

                    <?= view('Admin/partials/address_builder',[
                        'field'=>'alamat',
                        'label'=>'Alamat Keluarga',
                        'value'=>old('alamat',$orang_tua['alamat'])
                    ]) ?>

                </div>


                <div class="form-actions">

                    <a href="<?= base_url('orang-tua') ?>"
                       class="btn btn-secondary">

                        Batal

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="ti ti-device-floppy"></i>
                        Update Data

                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

<?= $this->endSection() ?>