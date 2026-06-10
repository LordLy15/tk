<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<?php
$filterParams = [
    'tanggal' => $tanggal,
];

if (!empty($id_kelas)) {
    $filterParams['kelas'] = $id_kelas;
}

$daftarUrl = base_url('kehadiran') . '?' . http_build_query($filterParams);
$statusOptions = [
    'hadir' => ['label' => 'Hadir'],
    'sakit' => ['label' => 'Sakit'],
    'izin' => ['label' => 'Izin'],
    'alpha' => ['label' => 'Alpha'],
];
?>

<div class="crud-page-header">
    <div>
        <h1>Input Kehadiran</h1>
        <p><?= esc(date('d-m-Y', strtotime($tanggal))) ?></p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= esc($daftarUrl) ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Daftar Kehadiran
        </a>
    </div>
</div>

<?php if ($cek_libur) : ?>
    <div class="alert alert-warning border-warning-subtle" role="alert">
        <strong><?= esc(date('d-m-Y', strtotime($tanggal))) ?> libur sekolah.</strong>
        <?= esc($cek_libur['nama_libur']) ?>
    </div>
<?php endif; ?>

<div class="card border rounded-2 mb-3">
    <div class="card-body">
        <form method="get" action="<?= base_url('kehadiran/input') ?>" class="row g-3 align-items-end">
            <div class="col-md-4 col-lg-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input id="tanggal"
                       type="date"
                       name="tanggal"
                       class="form-control"
                       value="<?= esc($tanggal) ?>"
                       max="<?= esc($max_tanggal ?? date('Y-m-d')) ?>"
                       required>
            </div>

            <div class="col-md-5 col-lg-4">
                <label for="id_kelas" class="form-label">Kelas</label>
                <select name="kelas" id="id_kelas" class="form-select" required>
                    <option value="">Pilih Kelas</option>
                    <?php foreach ($kelas_list as $k) : ?>
                        <option value="<?= esc($k['id_kelas']) ?>" <?= (int) $id_kelas === (int) $k['id_kelas'] ? 'selected' : '' ?>>
                            <?= esc($k['nama_kelas']) ?>
                            <?php if (!empty($k['nama_guru'])) : ?>
                                - <?= esc($k['nama_guru']) ?>
                            <?php endif; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3 col-lg-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-search"></i>
                    Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($murid)) : ?>
    <form method="post" action="<?= base_url('kehadiran/simpan') ?>">
        <?= csrf_field() ?>

        <input type="hidden" name="tanggal" value="<?= esc($tanggal) ?>">
        <input type="hidden" name="id_kelas" value="<?= esc($id_kelas) ?>">

        <div class="card border rounded-2">
            <div class="card-header">
                <div>
                    <h5 class="mb-1">Daftar Murid <?= esc($selected_kelas['nama_kelas'] ?? '') ?></h5>
                    <?php if (!empty($selected_kelas['nama_guru'])) : ?>
                        <p class="mb-0 text-secondary"><?= esc($selected_kelas['nama_guru']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 64px;">No</th>
                                <th>Nama Murid</th>
                                <th style="min-width: 360px;">Status Kehadiran</th>
                                <th style="min-width: 220px;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($murid as $index => $m) : ?>
                                <?php
                                $absensi = $kehadiran_by_murid[$m['id']] ?? [];
                                $selectedStatus = $absensi['status'] ?? 'hadir';
                                $keterangan = $absensi['keterangan'] ?? '';
                                ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td class="fw-semibold"><?= esc($m['nama_murid']) ?></td>
                                    <td>
                                        <div class="btn-group flex-wrap" role="group" aria-label="Status <?= esc($m['nama_murid']) ?>">
                                            <?php foreach ($statusOptions as $status => $meta) : ?>
                                                <?php $fieldId = 'status-' . $m['id'] . '-' . $status; ?>
                                                <input type="radio"
                                                       class="btn-check"
                                                       name="kehadiran[<?= esc($m['id']) ?>]"
                                                       id="<?= esc($fieldId) ?>"
                                                       value="<?= esc($status) ?>"
                                                       autocomplete="off"
                                                       <?= $selectedStatus === $status ? 'checked' : '' ?>
                                                       required>
                                                <label class="btn btn-sm attendance-status-option attendance-status-<?= esc($status) ?>"
                                                       for="<?= esc($fieldId) ?>">
                                                    <?= esc($meta['label']) ?>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text"
                                               name="keterangan[<?= esc($m['id']) ?>]"
                                               class="form-control form-control-sm"
                                               value="<?= esc($keterangan) ?>"
                                               placeholder="Opsional">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-actions">
                    <a href="<?= esc($daftarUrl) ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Simpan Kehadiran
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php elseif ($id_kelas) : ?>
    <div class="alert alert-info mb-0">Belum ada murid di kelas ini.</div>
<?php else : ?>
    <div class="alert alert-info mb-0">Pilih tanggal dan kelas terlebih dahulu.</div>
<?php endif; ?>

<?= $this->endSection() ?>
