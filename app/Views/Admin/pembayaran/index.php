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
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Orang Tua</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Tagihan</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Tanggal Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pembayaran as $p) : ?>
                            <tr>
                                <td>
                                    <strong><?= esc($p['nama_ortu']) ?></strong>
                                </td>
                                <td><?= esc($p['nama_siswa'] ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= esc($p['kelas'] ?? 'Tanpa Kelas') ?></span>
                                </td>
                                <td><?= esc($p['judul']) ?></td>
                                <td>
                                    <strong>Rp <?= number_format($p['nominal'], 0, ',', '.') ?></strong>
                                </td>
                                <td>
                                    <?php
                                    $badgeClass = $p['status'] === 'verified'
                                        ? 'bg-success'
                                        : ($p['status'] === 'rejected' ? 'bg-danger' : 'bg-warning text-dark');
                                    $label = $p['status'] === 'verified'
                                        ? 'Lunas'
                                        : ($p['status'] === 'rejected' ? 'Ditolak' : 'Pending');
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= $label ?></span>
                                </td>
                                <td>
                                    <?= $p['tanggal_bayar']
                                        ? date('d M Y', strtotime($p['tanggal_bayar']))
                                        : '-'; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/verifikasi-pembayaran/' . $p['id']) ?>"
                                       class="btn btn-sm btn-primary">
                                        <i class="ti ti-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>