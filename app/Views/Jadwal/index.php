<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Jadwal Kelas</h1>
        <p>Kelola jadwal harian berdasarkan kelas.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('jadwal/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Jadwal
        </a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-6 col-lg-4">
                <label for="filter-kelas" class="form-label">Filter Kelas</label>
                <select id="filter-kelas" name="kelas" class="form-select" onchange="this.form.submit()">
                    <option value="">Pilih Kelas</option>
                    <?php foreach ($kelas_list ?? [] as $k) : ?>
                        <option value="<?= esc($k['id_kelas']) ?>" <?= $id_kelas_selected == $k['id_kelas'] ? 'selected' : '' ?>>
                            <?= esc($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
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
                        <th>Hari</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Aktivitas</th>
                        <th>Ruangan</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($jadwal)) : ?>
                        <tr>
                            <td colspan="7" class="empty-state">Pilih kelas atau tambahkan jadwal baru.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($jadwal as $j) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-semibold"><?= esc($j['hari']) ?></td>
                                <td><?= esc(date('H:i', strtotime($j['jam_masuk']))) ?></td>
                                <td><?= esc(date('H:i', strtotime($j['jam_keluar']))) ?></td>
                                <td><?= esc($j['aktivitas'] ?? '-') ?></td>
                                <td><?= esc($j['ruangan'] ?? '-') ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="<?= base_url('jadwal/edit/' . $j['id']) ?>" class="btn btn-warning btn-sm">
                                            <i class="ti ti-edit"></i>
                                            Edit
                                        </a>
                                        <a href="<?= base_url('jadwal/hapus/' . $j['id']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Hapus jadwal ini?')">
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
