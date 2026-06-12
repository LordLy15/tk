<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Edit Murid</h1>
        <p>Perbarui identitas murid tanpa mengubah riwayat kelas dan laporan yang sudah tersimpan.</p>
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
                <h2 class="card-title">Form Edit Murid</h2>
                <p class="card-subtitle"><?= esc($murid['nama_murid'] ?? 'Data murid') ?></p>
            </div>
        </div>

        <div class="card-body">
            <form action="<?= base_url('murid/update/' . $murid['id']) ?>" method="post" enctype="multipart/form-data">
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
                                   value="<?= esc(old('nisn', $murid['nisn'] ?? '')) ?>"
                                   data-digit-only
                                   required>
                        </div>

                        <div class="col-md-8">
                            <label for="nama_murid" class="form-label">Nama Murid <span class="required-mark">*</span></label>
                            <input id="nama_murid"
                                   type="text"
                                   name="nama_murid"
                                   class="form-control"
                                   value="<?= esc(old('nama_murid', $murid['nama_murid'] ?? '')) ?>"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="id_kelas" class="form-label">Kelas <span class="required-mark">*</span></label>
                            <select id="id_kelas" name="id_kelas" class="form-select" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas ?? [] as $k) : ?>
                                    <?php $selectedKelas = old('id_kelas', $murid['id_kelas'] ?? '') == $k['id_kelas']; ?>
                                    <option value="<?= esc($k['id_kelas']) ?>" <?= $selectedKelas ? 'selected' : '' ?>>
                                        <?= esc($k['nama_kelas']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="w-100">
                            <label for="jenis_kelamin" class="form-label">
                                Jenis Kelamin <span class="required-mark">*</span>
                            </label>

                            <?php $selectedGender = old('jenis_kelamin', $murid['jenis_kelamin'] ?? ''); ?>

                            <select id="jenis_kelamin"
                                    name="jenis_kelamin"
                                    class="form-select"
                                    required>
                                    
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" <?= $selectedGender === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= $selectedGender === 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        

                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="required-mark">*</span></label>
                            <input id="tempat_lahir"
                                   type="text"
                                   name="tempat_lahir"
                                   class="form-control"
                                   value="<?= esc(old('tempat_lahir', $murid['tempat_lahir'] ?? '')) ?>"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="required-mark">*</span></label>
                            <input id="tanggal_lahir"
                                   type="date"
                                   name="tanggal_lahir"
                                   class="form-control"
                                   value="<?= esc(old('tanggal_lahir', $murid['tanggal_lahir'] ?? '')) ?>"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="foto_murid" class="form-label">Ganti Foto Profil</label>
                            <input id="foto_murid"
                                   type="file"
                                   name="foto_murid"
                                   class="form-control"
                                   accept="image/jpeg,image/png,image/webp">
                            <div class="form-hint">Kosongkan jika tidak ingin mengganti foto. Maksimal 5 MB.</div>
                        </div>

                        <?php if (! empty($murid['foto_murid'])) : ?>
                            <div class="col-md-6">
                                <label class="form-label">Foto Saat Ini</label>
                                <div class="profile-upload-preview">
                                    <img src="<?= base_url('uploads/foto_murid/' . rawurlencode($murid['foto_murid'])) ?>"
                                         alt="Foto <?= esc($murid['nama_murid'] ?? 'murid') ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-section">
                    <?= view('Admin/partials/address_builder', [
                        'field' => 'alamat',
                        'label' => 'Alamat Murid',
                        'value' => old('alamat', $murid['alamat'] ?? ''),
                        'required' => true,
                        'structured_required' => false,
                    ]) ?>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('murid') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Update Murid
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
