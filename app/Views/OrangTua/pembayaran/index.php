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
            --ot-primary: #27ae60;
            --ot-primary-dark: #219653;
            --ot-success: #10b981;
            --ot-warning: #f59e0b;
            --ot-danger: #ef4444;
            --ot-text-muted: #64748b;
        }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; background-color: #f8fafc; }
        .ot-topbar {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%) !important;
            border-bottom: 3px solid #f1c40f !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .ot-topbar-brand {
            font-weight: 700;
            color: #ffffff !important;
            font-size: 1.125rem;
        }
        .ot-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
        .ot-badge { display: inline-flex; align-items: center; padding: 0.4rem 0.8rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; gap: 0.35rem; border: 1px solid transparent; }
        .ot-badge-pending { background: rgba(245, 158, 11, 0.1) !important; color: #d97706 !important; border-color: rgba(245, 158, 11, 0.2) !important; }
        .ot-badge-partial { background: rgba(59, 130, 246, 0.1) !important; color: #1d4ed8 !important; border-color: rgba(59, 130, 246, 0.2) !important; }
        .ot-badge-verified { background: rgba(16, 185, 129, 0.1) !important; color: #059669 !important; border-color: rgba(16, 185, 129, 0.2) !important; }
        .ot-badge-rejected { background: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; border-color: rgba(239, 68, 68, 0.2) !important; }
        
        .ot-filter-btn {
            border-radius: 30px !important;
            padding: 0.45rem 1.2rem !important;
            font-weight: 600 !important;
            font-size: 0.85rem !important;
            border: 1.5px solid #e2e8f0 !important;
            color: var(--ot-text-muted) !important;
            background-color: #ffffff !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .ot-filter-btn.active {
            background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%) !important;
            color: #ffffff !important;
            border-color: var(--ot-primary) !important;
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.2) !important;
        }
        .ot-filter-btn:hover:not(.active) {
            background-color: #f8fafc !important;
            border-color: #cbd5e1 !important;
            color: var(--ot-primary) !important;
        }

        .ot-detail-btn {
            background: transparent !important;
            color: var(--ot-primary) !important;
            border: 1.5px solid var(--ot-primary) !important;
            padding: 0.4rem 1.1rem !important;
            border-radius: 30px !important;
            font-weight: 600 !important;
            font-size: 0.8rem !important;
            transition: all 0.2s ease !important;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            text-decoration: none !important;
        }
        .ot-detail-btn:hover {
            background: var(--ot-primary) !important;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.2);
        }

        .tagihan-item { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 1.25rem; margin-bottom: 1rem; transition: all 0.3s ease; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .tagihan-item:hover { border-color: var(--ot-primary); box-shadow: 0 8px 24px rgba(39, 174, 96, 0.08); transform: translateY(-1px); }
        
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        .anim-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; opacity: 0; }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        
        .ot-header-btn {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1.5px solid rgba(255, 255, 255, 0.8) !important;
            color: #ffffff !important;
            border-radius: 30px !important;
            padding: 0.45rem 1.1rem !important;
            font-weight: 500 !important;
            font-size: 0.85rem !important;
            transition: all 0.2s ease !important;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none !important;
        }
        .ot-header-btn:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            border-color: #ffffff !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        .ot-back-btn {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1.5px solid rgba(255, 255, 255, 0.8) !important;
            color: #ffffff !important;
            border-radius: 50% !important;
            width: 36px !important;
            height: 36px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
        }
        .ot-back-btn:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            border-color: #ffffff !important;
            color: #ffffff !important;
            transform: scale(1.05);
        }
        .ot-back-btn i {
            font-size: 1.15rem !important;
            line-height: 1 !important;
        }
    </style>
</head>
<body>
    <!-- Topbar -->
    <nav class="ot-topbar fixed-top py-2 px-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center text-decoration-none">
                        <img src="<?= base_url('assets/logo.png'); ?>" alt="Logo RA Perwanida" class="me-2 rounded-circle bg-white p-1" style="max-height: 40px; width: 40px;">
                        <div class="lh-1 text-start">
                            <span class="d-block fw-bold text-white" style="font-size: 0.95rem; letter-spacing: 0.5px;">RA PERWANIDA</span>
                            <small style="color: #ffffff; font-size: 0.65rem; opacity: 0.95;">TEMPURSARI</small>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="<?= base_url('orangtua/ubah-password') ?>"
                       class="ot-header-btn" title="Ubah Password">
                        <i class="bi bi-key"></i>
                        <span class="d-none d-sm-inline">Password</span>
                    </a>
                    <a href="<?= base_url('orangtua/logout') ?>"
                       class="ot-header-btn" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-sm-inline">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-5 mt-4">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    
                    <!-- Back Button -->
                    <div class="mb-3 anim-fade-in-up">
                        <a href="<?= base_url('orangtua/dashboard') ?>" class="btn btn-white border border-light-subtle shadow-xs rounded-pill px-3 py-2 d-inline-flex align-items-center gap-2 text-dark fw-semibold" style="font-size: 0.85rem; background-color: #ffffff;">
                            <i class="bi bi-arrow-left"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                    
                    <!-- Header -->
                    <div class="mb-4 anim-fade-in-up">
                        <h4 class="fw-bold mb-1 text-dark">
                            <i class="bi bi-credit-card-2-back-fill me-2" style="color: var(--ot-primary);"></i>
                            Riwayat Pembayaran
                        </h4>
                        <p class="text-muted mb-0 small">Lihat daftar tagihan sekolah anak Anda dan unggah bukti transfer di sini.</p>
                    </div>

                    <!-- Filter -->
                    <div class="ot-card p-3 mb-4 anim-fade-in-up delay-100">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="<?= base_url('orangtua/pembayaran') ?>"
                               class="ot-filter-btn <?= !$filter_status ? 'active' : ''; ?>">
                                Semua
                            </a>
                            <a href="<?= base_url('orangtua/pembayaran?status=pending') ?>"
                               class="ot-filter-btn <?= $filter_status === 'pending' ? 'active' : ''; ?>">
                                <i class="bi bi-clock"></i> Menunggu Verifikasi
                            </a>
                            <a href="<?= base_url('orangtua/pembayaran?status=partial') ?>"
                               class="ot-filter-btn <?= $filter_status === 'partial' ? 'active' : ''; ?>">
                                <i class="bi bi-arrow-repeat"></i> Dicicil
                            </a>
                            <a href="<?= base_url('orangtua/pembayaran?status=verified') ?>"
                               class="ot-filter-btn <?= $filter_status === 'verified' ? 'active' : ''; ?>">
                                <i class="bi bi-check-circle"></i> Sudah Lunas
                            </a>
                        </div>
                    </div>

                    <!-- Alert -->
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm anim-fade-in-up" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= esc(session()->getFlashdata('success')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Tagihan List -->
                    <?php if (empty($tagihan)) : ?>
                        <div class="ot-card p-5 text-center anim-fade-in-up delay-200">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background-color: rgba(39, 174, 96, 0.08) !important;">
                                <i class="bi bi-file-earmark-check-fill text-success fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Tidak Ada Tagihan</h5>
                            <p class="text-muted small">Semua pembayaran dengan kategori filter ini aman atau belum tersedia.</p>
                        </div>
                    <?php else : ?>
                        <div class="anim-fade-in-up delay-200">
                            <?php foreach ($tagihan as $t) : ?>
                                <div class="tagihan-item">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap gap-3">
                                        
                                        <!-- Left: Icon & Info -->
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" 
                                                 style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%);">
                                                <?php if (stripos($t['judul'], 'spp') !== false) : ?>
                                                    <i class="bi bi-journal-bookmark fs-5"></i>
                                                <?php elseif (stripos($t['judul'], 'seragam') !== false) : ?>
                                                    <i class="bi bi-tag fs-5"></i>
                                                <?php else : ?>
                                                    <i class="bi bi-receipt fs-5"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1 text-dark" style="font-size: 1rem;"><?= esc(ucwords(strtolower($t['judul']))) ?></h6>
                                                <div class="d-flex flex-wrap gap-2 align-items-center text-muted small" style="font-size: 0.75rem;">
                                                    <?php if ($t['batas_bayar']) : ?>
                                                        <span><i class="bi bi-calendar3 me-1"></i>Batas: <?= date('d M Y', strtotime($t['batas_bayar'])) ?></span>
                                                    <?php endif; ?>
                                                    <?php if ($t['keterangan']) : ?>
                                                        <span class="d-none d-sm-inline">•</span>
                                                        <span><i class="bi bi-info-circle me-1"></i><?= esc($t['keterangan']) ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Right: Nominal, Status & Action -->
                                        <div class="d-flex align-items-center gap-4 ms-auto ms-md-0 w-100 w-md-auto justify-content-between justify-content-md-end flex-wrap flex-sm-nowrap">
                                            <div class="text-start text-md-end">
                                                <small class="text-muted d-block" style="font-size: 0.7rem;">Nominal</small>
                                                <?php if ($t['sisa_tagihan'] < $t['nominal'] && $t['sisa_tagihan'] > 0) : ?>
                                                    <span class="fw-semibold small d-block text-muted text-decoration-line-through">
                                                        Rp <?= number_format($t['nominal'], 0, ',', '.') ?>
                                                    </span>
                                                    <span class="fw-bold text-danger" style="font-size: 1.15rem;">
                                                        Sisa: Rp <?= number_format($t['sisa_tagihan'], 0, ',', '.') ?>
                                                    </span>
                                                <?php else : ?>
                                                    <span class="fw-bold" style="font-size: 1.15rem; color: var(--ot-primary);">
                                                        Rp <?= number_format($t['nominal'], 0, ',', '.') ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="d-flex flex-row flex-md-column align-items-center align-items-md-end gap-2">
                                                <?php 
                                                if ($t['status'] === 'verified') {
                                                    $statusClass = 'ot-badge-verified';
                                                    $statusIcon = 'check-circle';
                                                    $statusLabel = 'Lunas';
                                                } elseif ($t['status'] === 'partial') {
                                                    $statusClass = 'ot-badge-partial';
                                                    $statusIcon = 'arrow-repeat';
                                                    $statusLabel = 'Dicicil';
                                                } elseif ($t['status'] === 'rejected') {
                                                    $statusClass = 'ot-badge-rejected';
                                                    $statusIcon = 'x-circle';
                                                    $statusLabel = 'Ditolak';
                                                } else {
                                                    $statusClass = 'ot-badge-pending';
                                                    $statusIcon = 'clock';
                                                    $statusLabel = 'Menunggu';
                                                }
                                                ?>
                                                <span class="ot-badge <?= $statusClass ?>">
                                                    <i class="bi bi-<?= $statusIcon ?>"></i>
                                                    <?= $statusLabel ?>
                                                </span>
                                                <a href="<?= base_url('orangtua/pembayaran/' . $t['id']) ?>"
                                                   class="ot-detail-btn">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>