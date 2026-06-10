<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Jadwal Aktivitas Kelas</h1>
        <p>Pantau aktivitas pembelajaran yang sudah dijadwalkan per kelas.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('aktivitas/tambah-jadwal-kelas') ?>" class="btn btn-primary">
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
                        <th>Tanggal</th>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                        <th>Hasil Pembelajaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($aktivitas_kelas)) : ?>
                        <tr>
                            <td colspan="5" class="empty-state">Pilih kelas atau tambahkan jadwal aktivitas.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($aktivitas_kelas as $ak) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc(date('d-m-Y', strtotime($ak['tanggal']))) ?></td>
                                <td class="fw-semibold"><?= esc($ak['judul_aktivitas']) ?></td>
                                <td>
                                    <?php if (! empty($ak['waktu_mulai']) && ! empty($ak['waktu_selesai'])) : ?>
                                        <?= esc(date('H:i', strtotime($ak['waktu_mulai'])) . ' - ' . date('H:i', strtotime($ak['waktu_selesai']))) ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <?php $hasil = $ak['hasil_pembelajaran'] ?? '-'; ?>
                                <td><?= esc(strlen($hasil) > 80 ? substr($hasil, 0, 80) . '...' : $hasil) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
