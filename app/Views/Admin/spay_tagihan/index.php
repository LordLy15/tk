<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-receipt me-2"></i>
            Manajemen Tagihan
        </h4>
        <p class="text-muted mb-0">Kelola tagihan untuk akun orang tua</p>
    </div>
    <a href="<?= base_url('admin/spay-tagihan/tambah') ?>" class="btn btn-primary">
        <i class="ti ti-plus me-2"></i> Tambah Tagihan
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Filter Pencarian -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="<?= base_url('admin/spay-tagihan') ?>" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label for="search_siswa" class="form-label fw-bold">Nama Siswa</label>
                <input type="text" name="search_siswa" id="search_siswa" class="form-control" 
                       placeholder="Cari nama siswa..." value="<?= esc($search_siswa ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label for="search_kelas" class="form-label fw-bold">Kelas</label>
                <select name="search_kelas" id="search_kelas" class="form-select">
                    <option value="">-- Semua Kelas --</option>
                    <?php foreach ($kelas_list as $k) : ?>
                        <option value="<?= esc($k['kelas']) ?>" <?= (isset($search_kelas) && $search_kelas === $k['kelas']) ? 'selected' : '' ?>>
                            <?= esc($k['kelas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-search me-1"></i> Cari
                </button>
                <?php if (!empty($search_siswa) || !empty($search_kelas)) : ?>
                    <a href="<?= base_url('admin/spay-tagihan') ?>" class="btn btn-light w-100">
                        <i class="ti ti-refresh me-1"></i> Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($tagihan)) : ?>
            <?php if (!empty($search_siswa) || !empty($search_kelas)) : ?>
                <div class="text-center py-5">
                    <i class="ti ti-search" style="font-size: 4rem; color: #cbd5e1;"></i>
                    <h5 class="mt-3 mb-1">Hasil Tidak Ditemukan</h5>
                    <p class="text-muted mb-0">Tidak ada tagihan yang sesuai dengan kriteria pencarian Anda.</p>
                    <a href="<?= base_url('admin/spay-tagihan') ?>" class="btn btn-sm btn-outline-primary mt-3">
                        <i class="ti ti-refresh me-1"></i> Bersihkan Filter
                    </a>
                </div>
            <?php else : ?>
                <div class="text-center py-5">
                    <i class="ti ti-receipt" style="font-size: 4rem; color: #cbd5e1;"></i>
                    <h5 class="mt-3 mb-1">Belum Ada Tagihan</h5>
                    <p class="text-muted mb-0">Tambahkan tagihan pertama Anda.</p>
                    <a href="<?= base_url('admin/spay-tagihan/tambah') ?>" class="btn btn-primary mt-3">
                        <i class="ti ti-plus me-2"></i> Tambah Tagihan
                    </a>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <?php
            // Group tagihan by student (orang_tua_id)
            $groupedTagihan = [];
            foreach ($tagihan as $t) {
                $otId = $t['orang_tua_id'];
                if (!isset($groupedTagihan[$otId])) {
                    $groupedTagihan[$otId] = [
                        'nama_siswa' => $t['nama_siswa'] ?? 'Tanpa Siswa',
                        'nama_ortu'  => $t['nama_ortu'] ?? 'Tanpa Orang Tua',
                        'kelas'      => $t['kelas'] ?? 'Tanpa Kelas',
                        'email'      => $t['email'] ?? '',
                        'items'      => [],
                        'total_nominal' => 0
                    ];
                }
                $groupedTagihan[$otId]['items'][] = $t;
                $groupedTagihan[$otId]['total_nominal'] += (float)$t['nominal'];
            }
            ?>

            <div class="accordion" id="accordionTagihan">
                <?php $studentIdx = 0; foreach ($groupedTagihan as $otId => $group) : $studentIdx++; ?>
                    <div class="accordion-item border shadow-sm mb-3 rounded overflow-hidden">
                        <h2 class="accordion-header" id="headingSiswa<?= $studentIdx ?>">
                            <button class="accordion-button collapsed px-4 py-3 bg-white" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#collapseSiswa<?= $studentIdx ?>" 
                                    aria-expanded="false" aria-controls="collapseSiswa<?= $studentIdx ?>">
                                <div class="d-flex align-items-center justify-content-between w-100 me-3 flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px; background-color: #f3f4f6 !important;">
                                            <i class="ti ti-user fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark" style="margin: 0; font-size: 0.95rem;">
                                                <?= esc($group['nama_siswa']) ?>
                                            </h6>
                                            <div class="d-flex align-items-center gap-2 text-muted small mt-1">
                                                <span class="badge bg-light text-dark border"><?= esc($group['kelas']) ?></span>
                                                <span>• Ortu: <?= esc($group['nama_ortu']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-md-end d-flex align-items-center gap-3">
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2.5 py-1">
                                            <?= count($group['items']) ?> Tagihan
                                        </span>
                                        <span class="fw-bold text-primary font-size-md me-1">
                                            Total: Rp <?= number_format($group['total_nominal'], 0, ',', '.') ?>
                                        </span>
                                        <a href="<?= base_url('admin/spay-tagihan/tambah?orang_tua_id=' . $otId) ?>" 
                                           class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1"
                                           onclick="event.stopPropagation();"
                                           style="border-radius: 6px; padding: 0.35rem 0.75rem; font-size: 0.75rem;"
                                           title="Tambah Tagihan untuk Siswa Ini">
                                            <i class="ti ti-plus"></i>
                                            <span class="d-none d-md-inline">Tambah Tagihan</span>
                                        </a>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseSiswa<?= $studentIdx ?>" class="accordion-collapse collapse" 
                             aria-labelledby="headingSiswa<?= $studentIdx ?>" data-bs-parent="#accordionTagihan">
                            <div class="accordion-body bg-light-subtle p-3" style="background-color: #fafafa;">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered bg-white rounded align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 50px;" class="text-center">No</th>
                                                <th>Judul Tagihan</th>
                                                <th>Kategori</th>
                                                <th>Nominal</th>
                                                <th>Batas Bayar</th>
                                                <th style="width: 120px;" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($group['items'] as $itemIdx => $t) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $itemIdx + 1 ?></td>
                                                    <td><strong><?= esc($t['judul']) ?></strong></td>
                                                    <td>
                                                        <?php if (!empty($t['kategori'])) : ?>
                                                            <span class="badge bg-info-subtle text-info border border-info-subtle"><?= esc($t['kategori']) ?></span>
                                                        <?php else : ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><strong>Rp <?= number_format($t['nominal'], 0, ',', '.') ?></strong></td>
                                                    <td>
                                                        <?= $t['batas_bayar'] ? date('d M Y', strtotime($t['batas_bayar'])) : '-' ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('admin/spay-tagihan/edit/' . $t['id']) ?>"
                                                           class="btn btn-sm btn-outline-primary" title="Edit Tagihan">
                                                            <i class="ti ti-edit"></i>
                                                        </a>
                                                        <a href="<?= base_url('admin/spay-tagihan/hapus/' . $t['id']) ?>"
                                                           class="btn btn-sm btn-outline-danger"
                                                           onclick="return confirm('Yakin hapus tagihan ini?')" title="Hapus Tagihan">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>