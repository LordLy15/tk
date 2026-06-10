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

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($pembayaran)) : ?>
            <div class="text-center py-5">
                <i class="ti ti-inbox" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h5 class="mt-3 mb-1">Belum Ada Pembayaran</h5>
                <p class="text-muted">Belum ada pembayaran yang perlu diverifikasi.</p>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Orang Tua</th>
                            <th>Siswa</th>
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