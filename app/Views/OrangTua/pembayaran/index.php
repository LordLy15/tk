<?php
$namaOrtu = session()->get('orangtua_nama') ?? 'Orang Tua';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - RA Perwanida</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/main.css?v=20260523a') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ot-primary: #8b5cf6;
            --ot-primary-dark: #7c3aed;
            --ot-success: #10b981;
            --ot-warning: #f59e0b;
            --ot-danger: #ef4444;
            --ot-text-muted: #64748b;
        }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .ot-topbar { background: #fff; border-bottom: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.04); }
        .ot-topbar-brand { font-weight: 700; color: var(--ot-primary); font-size: 1.125rem; }
        .ot-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .ot-badge { display: inline-flex; align-items: center; padding: 0.35rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; gap: 0.35rem; }
        .ot-badge-pending { background: rgba(245, 158, 11, 0.15); color: #b45309; }
        .ot-badge-verified { background: rgba(16, 185, 129, 0.15); color: #047857; }
        .ot-badge-rejected { background: rgba(239, 68, 68, 0.15); color: #dc2626; }
        .ot-btn-primary { background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%); color: #fff; border: none; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; }
        .ot-btn-primary:hover { color: #fff; transform: translateY(-1px); }
        .ot-btn-outline-primary { background: transparent; color: var(--ot-primary); border: 2px solid var(--ot-primary); padding: 0.4rem 1rem; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; }
        .ot-btn-outline-primary:hover { background: var(--ot-primary); color: #fff; }
        .tagihan-item { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 0.75rem; transition: all 0.3s ease; }
        .tagihan-item:hover { border-color: #a78bfa; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.1); }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        .anim-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; opacity: 0; }
        .delay-100 { animation-delay: 100ms; }
    </style>
</head>
<body>
    <!-- Topbar -->
    <nav class="ot-topbar fixed-top py-3 px-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <a href="<?= base_url('orangtua/dashboard') ?>" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <img src="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>" alt="Logo" width="36" height="36">
                    <span class="ot-topbar-brand">RA Perwanida</span>
                </div>
                <a href="<?= base_url('orangtua/logout') ?>" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </nav>

    <main class="pt-5 mt-4">
        <div class="container py-4">
            <!-- Header -->
            <div class="mb-4 anim-fade-in-up">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-credit-card" style="color: var(--ot-primary);"></i>
                    Pembayaran
                </h4>
                <p class="text-muted mb-0">Daftar tagihan dan riwayat pembayaran</p>
            </div>

            <!-- Filter -->
            <div class="ot-card p-3 mb-4 anim-fade-in-up delay-100">
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= base_url('orangtua/pembayaran') ?>"
                       class="btn <?= !$filter_status ? 'ot-btn-primary' : 'btn-light'; ?> btn-sm">
                        Semua
                    </a>
                    <a href="<?= base_url('orangtua/pembayaran?status=pending') ?>"
                       class="btn <?= $filter_status === 'pending' ? 'ot-btn-primary' : 'btn-light'; ?> btn-sm">
                        <i class="bi bi-clock me-1"></i> Menunggu
                    </a>
                    <a href="<?= base_url('orangtua/pembayaran?status=verified') ?>"
                       class="btn <?= $filter_status === 'verified' ? 'ot-btn-primary' : 'btn-light'; ?> btn-sm">
                        <i class="bi bi-check-circle me-1"></i> Lunas
                    </a>
                </div>
            </div>

            <!-- Alert -->
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show animate" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Tagihan List -->
            <?php if (empty($tagihan)) : ?>
                <div class="ot-card p-5 text-center anim-fade-in-up delay-200">
                    <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: var(--ot-success);"></i>
                    <h5 class="mt-3 mb-2">Tidak Ada Tagihan</h5>
                    <p class="text-muted">Belum ada tagihan dengan status ini.</p>
                </div>
            <?php else : ?>
                <div class="anim-fade-in-up delay-200">
                    <?php foreach ($tagihan as $t) : ?>
                        <div class="tagihan-item">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6 mb-2 mb-md-0">
                                    <h6 class="fw-bold mb-1"><?= esc($t['judul']) ?></h6>
                                    <div class="d-flex flex-wrap gap-3 small text-muted">
                                        <?php if ($t['batas_bayar']) : ?>
                                            <span><i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($t['batas_bayar'])) ?></span>
                                        <?php endif; ?>
                                        <?php if ($t['keterangan']) : ?>
                                            <span><i class="bi bi-info-circle me-1"></i><?= esc($t['keterangan']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 text-md-end mb-2 mb-md-0">
                                    <div class="fw-bold" style="font-size: 1.1rem; color: var(--ot-primary);">
                                        Rp <?= number_format($t['nominal'], 0, ',', '.') ?>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 text-md-end">
                                    <?php $statusClass = $t['status'] === 'verified' ? 'ot-badge-verified' : ($t['status'] === 'rejected' ? 'ot-badge-rejected' : 'ot-badge-pending'); ?>
                                    <?php $statusIcon = $t['status'] === 'verified' ? 'check-circle' : ($t['status'] === 'rejected' ? 'x-circle' : 'clock'); ?>
                                    <?php $statusLabel = $t['status'] === 'verified' ? 'Lunas' : ($t['status'] === 'rejected' ? 'Ditolak' : 'Menunggu'); ?>
                                    <span class="ot-badge <?= $statusClass ?> mb-2 d-inline-flex">
                                        <i class="bi bi-<?= $statusIcon ?>"></i>
                                        <?= $statusLabel ?>
                                    </span>
                                    <a href="<?= base_url('orangtua/pembayaran/' . $t['id']) ?>"
                                       class="btn btn-sm btn-outline-primary d-block">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>