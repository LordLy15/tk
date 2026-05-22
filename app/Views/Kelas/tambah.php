<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Tambah Kelas</h1>
        <p>Hubungkan kelas dengan jenjang pendidikan dan wali kelas.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('kelas') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Data Kelas</h2>
                <p class="card-subtitle">Pastikan pendidikan dan wali kelas sudah tersedia.</p>
            </div>
        </div>

        <div class="card-body">
            <form action="<?= base_url('kelas/simpan') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_kelas" class="form-label">Nama Kelas <span class="required-mark">*</span></label>
                        <input id="nama_kelas"
                               type="text"
                               name="nama_kelas"
                               class="form-control"
                               value="<?= esc(old('nama_kelas')) ?>"
                               placeholder="Contoh: TK A1"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="id_pendidikan" class="form-label">Pendidikan <span class="required-mark">*</span></label>
                        <select id="id_pendidikan" name="id_pendidikan" class="form-select" required>
                            <option value="">Pilih Pendidikan</option>
                            <?php foreach ($pendidikan ?? [] as $pen) : ?>
                                <option value="<?= esc($pen['id_pendidikan']) ?>" <?= old('id_pendidikan') == $pen['id_pendidikan'] ? 'selected' : '' ?>>
                                    <?= esc($pen['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="id_guru" class="form-label">Wali Kelas <span class="required-mark">*</span></label>
                        <select id="id_guru" name="id_guru" class="form-select" required>
                            <option value="">Pilih Guru</option>
                            <?php foreach ($guru ?? [] as $g) : ?>
                                <option value="<?= esc($g['id']) ?>" <?= old('id_guru') == $g['id'] ? 'selected' : '' ?>>
                                    <?= esc($g['nama_guru']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('kelas') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Simpan Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
