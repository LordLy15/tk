<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Data Orang Tua</h1>
        <p>Kelola informasi wali murid dan kontak keluarga.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('orang-tua/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Orang Tua
        </a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">

        <form method="get"
              action="<?= base_url('orang-tua') ?>">

            <div class="row">

                <!-- Filter Kelas -->
                <div class="col-md-4">

                    <label class="form-label">
                        Pilih Kelas
                    </label>

                    <select name="kelas"
                            class="form-control">

                        <option value="">
                            Semua Kelas
                        </option>

                        <?php foreach($kelas as $k): ?>

                        <option value="<?= $k['id_kelas'] ?>"
                            <?= ($id_kelas == $k['id_kelas']) ? 'selected' : '' ?>>

                            <?= esc($k['nama_kelas']) ?>

                        </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <!-- Pencarian -->
                <div class="col-md-4">

                    <label class="form-label">
                        Cari Data
                    </label>

                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Search (Nama Siswa, Nama Ayah, Nama Ibu)"
                           value="<?= esc($search ?? '') ?>">

                </div>

                <!-- Tombol -->
                <div class="col-md-2 d-flex align-items-end">

                    <button type="submit"
                            class="btn btn-primary w-100">

                        <i class="ti ti-search"></i>
                        Cari

                    </button>

                </div>

                <div class="col-md-2 d-flex align-items-end">

                    <a href="<?= base_url('orang-tua') ?>"
                       class="btn btn-secondary w-100">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>
</div>

            </div>

        </form>

    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Murid</th>
                        <th>Ayah</th>
                        <th>Ibu</th>
                        <th>Kontak Utama</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orang_tua)) : ?>
                        <tr>
                            <td colspan="6" class="empty-state">Belum ada data orang tua.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($orang_tua as $ot) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-semibold"><?= esc($ot['nama_murid']) ?></td>
                                <td><?= esc($ot['nama_ayah']) ?></td>
                                <td><?= esc($ot['nama_ibu']) ?></td>
                                <td><?= esc($ot['no_hp_ayah'] ?: $ot['no_hp_ibu']) ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="<?= base_url('orang-tua/detail/' . $ot['id']) ?>" class="btn btn-info btn-sm">
                                            <i class="ti ti-eye"></i>
                                            Detail
                                        </a>
                                        <a href="<?= base_url('orang-tua/edit/' . $ot['id']) ?>" class="btn btn-warning btn-sm">
                                            <i class="ti ti-edit"></i>
                                            Edit
                                        </a>
                                        <a href="<?= base_url('orang-tua/hapus/' . $ot['id']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Hapus data orang tua ini?')">
                                            <i class="ti ti-trash"></i>
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
