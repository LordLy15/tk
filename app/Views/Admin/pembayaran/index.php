<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-credit-card me-2"></i>
            Verifikasi Pembayaran
        </h4>
        <p class="text-muted mb-0">Kelola dan verifikasi pembayaran dari orang tua</p>
    </div>
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
        <form method="GET" action="<?= base_url('admin/verifikasi-pembayaran') ?>" class="row g-3 align-items-end">
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
                    <a href="<?= base_url('admin/verifikasi-pembayaran') ?>" class="btn btn-light w-100">
                        <i class="ti ti-refresh me-1"></i> Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($pembayaran)) : ?>
            <?php if (!empty($search_siswa) || !empty($search_kelas)) : ?>
                <div class="text-center py-5">
                    <i class="ti ti-search" style="font-size: 4rem; color: #cbd5e1;"></i>
                    <h5 class="mt-3 mb-1">Hasil Tidak Ditemukan</h5>
                    <p class="text-muted mb-0">Tidak ada pembayaran yang sesuai dengan kriteria pencarian Anda.</p>
                    <a href="<?= base_url('admin/verifikasi-pembayaran') ?>" class="btn btn-sm btn-outline-primary mt-3">
                        <i class="ti ti-refresh me-1"></i> Bersihkan Filter
                    </a>
                </div>
            <?php else : ?>
                <div class="text-center py-5">
                    <i class="ti ti-inbox" style="font-size: 4rem; color: #cbd5e1;"></i>
                    <h5 class="mt-3 mb-1">Belum Ada Pembayaran</h5>
                    <p class="text-muted mb-0">Belum ada pembayaran yang perlu diverifikasi.</p>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <?php
            // Group pembayaran by student (orang_tua_id)
            $groupedPembayaran = [];
            foreach ($pembayaran as $p) {
                $otId = $p['orang_tua_id'];
                if (!isset($groupedPembayaran[$otId])) {
                    $groupedPembayaran[$otId] = [
                        'nama_siswa' => $p['nama_siswa'] ?? 'Tanpa Siswa',
                        'nama_ortu'  => $p['nama_ortu'] ?? 'Tanpa Orang Tua',
                        'kelas'      => $p['kelas'] ?? 'Tanpa Kelas',
                        'items'      => [],
                        'pending_count' => 0
                    ];
                }
                $groupedPembayaran[$otId]['items'][] = $p;
                if ($p['status'] === 'pending') {
                    $groupedPembayaran[$otId]['pending_count']++;
                }
            }
            ?>

            <div class="accordion" id="accordionPembayaran">
                <?php $studentIdx = 0; foreach ($groupedPembayaran as $otId => $group) : $studentIdx++; ?>
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
                                        <?php if ($group['pending_count'] > 0) : ?>
                                            <span class="badge bg-warning text-dark border border-warning-subtle rounded-pill px-2.5 py-1 fw-semibold">
                                                <i class="ti ti-alert-circle me-1"></i><?= $group['pending_count'] ?> Perlu Verifikasi
                                            </span>
                                        <?php else : ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 fw-semibold" style="background-color: rgba(25, 135, 84, 0.1); color: #198754;">
                                                <i class="ti ti-circle-check me-1"></i>Selesai
                                            </span>
                                        <?php endif; ?>
                                        <span class="text-muted small">
                                            <?= count($group['items']) ?> Transaksi
                                        </span>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseSiswa<?= $studentIdx ?>" class="accordion-collapse collapse" 
                             aria-labelledby="headingSiswa<?= $studentIdx ?>" data-bs-parent="#accordionPembayaran">
                            <div class="accordion-body bg-light-subtle p-3" style="background-color: #fafafa;">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered bg-white rounded align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 50px;" class="text-center">No</th>
                                                <th>Tagihan</th>
                                                <th>Nominal Bayar / Tagihan</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Tanggal Bayar</th>
                                                <th class="text-center" style="width: 100px;">Bukti</th>
                                                <th style="width: 120px;" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($group['items'] as $itemIdx => $p) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $itemIdx + 1 ?></td>
                                                    <td><?= esc($p['judul']) ?></td>
                                                    <td>
                                                        <strong>Rp <?= number_format($p['nominal_bayar'], 0, ',', '.') ?></strong>
                                                        <br>
                                                        <small class="text-muted">Tagihan: Rp <?= number_format($p['nominal'], 0, ',', '.') ?></small>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        $badgeClass = $p['status'] === 'verified'
                                                            ? 'bg-success-subtle text-success border-success-subtle'
                                                            : ($p['status'] === 'rejected' ? 'bg-danger-subtle text-danger border-danger-subtle' : 'bg-warning-subtle text-dark border-warning-subtle');
                                                        $label = $p['status'] === 'verified'
                                                            ? 'Disetujui'
                                                            : ($p['status'] === 'rejected' ? 'Ditolak' : 'Pending');
                                                        ?>
                                                        <span class="badge border <?= $badgeClass ?>"><?= $label ?></span>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $p['tanggal_bayar'] ? date('d M Y', strtotime($p['tanggal_bayar'])) : '-' ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if ($p['bukti_bayar']) : ?>
                                                            <?php $ext = strtolower(pathinfo($p['bukti_bayar'], PATHINFO_EXTENSION)); ?>
                                                            <?php if (in_array($ext, ['jpg', 'jpeg', 'png'])) : ?>
                                                                <a href="<?= base_url('uploads/bukti_bayar/' . $p['bukti_bayar']) ?>" target="_blank">
                                                                    <img src="<?= base_url('uploads/bukti_bayar/' . $p['bukti_bayar']) ?>" 
                                                                         alt="Bukti" class="img-thumbnail rounded" style="width: 50px; height: 35px; object-fit: cover;">
                                                                </a>
                                                            <?php else : ?>
                                                                <a href="<?= base_url('uploads/bukti_bayar/' . $p['bukti_bayar']) ?>" target="_blank" class="btn btn-sm btn-light p-1">
                                                                    <i class="ti ti-file-text"></i> PDF
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php else : ?>
                                                            <span class="text-muted small">Tidak ada</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('admin/verifikasi-pembayaran/' . $p['id']) ?>"
                                                           class="btn btn-sm <?= $p['status'] === 'pending' ? 'btn-warning' : 'btn-outline-primary' ?> w-100">
                                                            <i class="ti ti-eye me-1"></i> <?= $p['status'] === 'pending' ? 'Verifikasi' : 'Detail' ?>
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