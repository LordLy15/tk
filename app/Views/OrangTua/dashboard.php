<?php
$namaOrtu = session()->get('orangtua_nama') ?? 'Orang Tua';
$namaSiswa = session()->get('orangtua_nama_siswa') ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - RA Perwanida</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/main.css?v=20260523a') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ot-primary: #27ae60;
            --ot-primary-dark: #219653;
            --ot-primary-light: #2ecc71;
            --ot-success: #10b981;
            --ot-warning: #f59e0b;
            --ot-danger: #ef4444;
            --ot-text-muted: #64748b;
        }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
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
        .ot-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .ot-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(39, 174, 96, 0.15);
        }
        .ot-card-hero {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            border: none;
        }
        .ot-card-hero .text-muted {
            color: rgba(255,255,255,0.8) !important;
        }
        .ot-stat-card {
            text-align: center;
            padding: 1.5rem;
        }
        .ot-stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
            font-size: 1.5rem;
        }
        .ot-stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .ot-stat-label {
            font-size: 0.875rem;
            color: var(--ot-text-muted);
            margin-top: 0.25rem;
        }
        .ot-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            gap: 0.35rem;
        }
        .ot-badge-pending {
            background: rgba(245, 158, 11, 0.15);
            color: #b45309;
        }
        .ot-badge-verified {
            background: rgba(16, 185, 129, 0.15);
            color: #047857;
        }
        .ot-badge-rejected {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
        }
        .ot-btn-primary {
            background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%);
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .ot-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.35);
            color: #fff;
        }
        .ot-btn-secondary {
            background: transparent;
            color: var(--ot-primary);
            border: 2px solid var(--ot-primary);
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }
        .ot-btn-secondary:hover {
            background: var(--ot-primary);
            color: #fff;
        }
        .ebook-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }
        .ebook-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(39, 174, 96, 0.15);
        }
        .ebook-cover {
            width: 100%;
            height: 160px;
            object-fit: cover;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        }
        .ebook-placeholder {
            width: 100%;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #94a3b8;
            font-size: 2.5rem;
        }
        .tagihan-item {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
        }
        .tagihan-item:hover {
            border-color: var(--ot-primary-light);
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.1);
        }
        .status-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .anim-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-500 { animation-delay: 500ms; }
        
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
    </style>
</head>
<body>

    <!-- Topbar -->
    <nav class="ot-topbar fixed-top py-2 px-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <a class="navbar-brand d-flex align-items-center text-decoration-none" href="<?= base_url('orangtua/dashboard'); ?>">
                    <img src="<?= base_url('assets/logo.png'); ?>" alt="Logo RA Perwanida" class="me-3 rounded-circle bg-white p-1" style="max-height: 48px; width: 48px;">
                    <div class="lh-1 text-start">
                        <span class="d-block fw-bold text-white" style="font-size: 1.1rem; letter-spacing: 0.5px;">RA PERWANIDA</span>
                        <small style="color: #ffffff; font-size: 0.7rem; opacity: 0.95;">TEMPURSARI</small>
                    </div>
                </a>
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

    <!-- Main Content -->
    <main class="pt-5 mt-4">
        <div class="container py-4">

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Profile Siswa Card -->
            <div class="card border-0 shadow-sm mb-4 anim-fade-in-up" style="border-radius: 16px; border-left: 5px solid var(--ot-primary) !important;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-7 mb-3 mb-md-0">
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 54px; height: 54px; background-color: rgba(39, 174, 96, 0.1); color: var(--ot-primary);">
                                    <i class="bi bi-person-check-fill fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1 text-dark">Selamat Datang, <?= esc($namaOrtu) ?>!</h5>
                                    <p class="text-muted mb-0 small">
                                        Wali murid dari <strong class="text-dark"><?= esc($namaSiswa) ?></strong> 
                                        <?php if (!empty($orangtua['kelas'])) : ?>
                                            • <span class="badge bg-light text-dark border ms-1"><?= esc($orangtua['kelas']) ?></span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 text-md-end border-start-md">
                            <div class="ps-md-3 small text-muted">
                                <div class="mb-1"><i class="bi bi-envelope-fill me-2 text-muted"></i><?= esc($orangtua['email'] ?? '-') ?></div>
                                <div><i class="bi bi-telephone-fill me-2 text-muted"></i><?= esc($orangtua['no_hp'] ?? '-') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Card - Tagihan Aktif & Stats Section -->
            <div class="row mb-4">
                <!-- Left: Tagihan Aktif -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="card border-0 text-white anim-fade-in-up delay-100 shadow-sm d-flex flex-column h-100" 
                         style="background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%); border-radius: 16px; min-height: 220px; overflow: hidden; justify-content: space-between; padding: 1.75rem;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3" 
                                 style="background: rgba(255, 255, 255, 0.18); width: 48px; height: 48px; font-size: 1.4rem;">
                                <i class="bi bi-credit-card-2-front"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-white">Tagihan Belum Lunas</h5>
                                <p class="mb-0 opacity-75 small text-white">
                                    <?= ($stats['pending_count'] ?? 0) ?> tagihan sedang menunggu pembayaran
                                </p>
                            </div>
                        </div>
                        <div class="my-3">
                            <small class="opacity-75 d-block text-white mb-1" style="font-size: 0.8rem;">Total Pembayaran</small>
                            <h2 class="fw-bold text-white mb-0" style="font-size: 2.2rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                                Rp <?= number_format($stats['pending'] ?? 0, 0, ',', '.') ?>
                            </h2>
                        </div>
                        <div>
                            <a href="<?= base_url('orangtua/pembayaran') ?>" class="btn w-100 py-2.5 d-flex align-items-center justify-content-center gap-2" 
                               style="background-color: #ffffff; color: var(--ot-primary-dark); font-weight: 700; border: none; border-radius: 10px; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
                                <i class="bi bi-wallet2"></i>
                                Bayar Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right: Stats Cards -->
                <div class="col-lg-6">
                    <div class="row g-3 h-100">
                        <div class="col-6">
                            <div class="card border-0 shadow-sm d-flex flex-column justify-content-center align-items-center anim-fade-in-up delay-200 h-100 p-3" 
                                 style="border-radius: 14px; min-height: 100px;">
                                <div class="rounded-3 d-flex align-items-center justify-content-center mb-2" 
                                     style="width: 38px; height: 38px; background: rgba(39, 174, 96, 0.1); color: var(--ot-primary);">
                                    <i class="bi bi-file-earmark-text-fill fs-5"></i>
                                </div>
                                <div class="fw-bold text-dark fs-4">
                                    <?= ($stats['pending_count'] ?? 0) + ($stats['lunas_count'] ?? 0) ?>
                                </div>
                                <div class="text-muted small" style="font-size: 0.75rem;">Total Tagihan</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 shadow-sm d-flex flex-column justify-content-center align-items-center anim-fade-in-up delay-300 h-100 p-3" 
                                 style="border-radius: 14px; min-height: 100px;">
                                <div class="rounded-3 d-flex align-items-center justify-content-center mb-2" 
                                     style="width: 38px; height: 38px; background: rgba(245, 158, 11, 0.1); color: var(--ot-warning);">
                                    <i class="bi bi-clock-fill fs-5"></i>
                                </div>
                                <div class="fw-bold text-warning fs-4">
                                    <?= $stats['pending_count'] ?? 0 ?>
                                </div>
                                <div class="text-muted small" style="font-size: 0.75rem;">Belum Bayar</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 shadow-sm d-flex flex-column justify-content-center align-items-center anim-fade-in-up delay-400 h-100 p-3" 
                                 style="border-radius: 14px; min-height: 100px;">
                                <div class="rounded-3 d-flex align-items-center justify-content-center mb-2" 
                                     style="width: 38px; height: 38px; background: rgba(16, 185, 129, 0.1); color: var(--ot-success);">
                                    <i class="bi bi-check-circle-fill fs-5"></i>
                                </div>
                                <div class="fw-bold text-success fs-4">
                                    <?= $stats['lunas_count'] ?? 0 ?>
                                </div>
                                <div class="text-muted small" style="font-size: 0.75rem;">Lunas</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 shadow-sm d-flex flex-column justify-content-center align-items-center anim-fade-in-up delay-500 h-100 p-3" 
                                 style="border-radius: 14px; min-height: 100px;">
                                <div class="rounded-3 d-flex align-items-center justify-content-center mb-2" 
                                     style="width: 38px; height: 38px; background: rgba(39, 174, 96, 0.1); color: var(--ot-primary);">
                                    <i class="bi bi-cash-stack fs-5"></i>
                                </div>
                                <div class="fw-bold text-dark" style="font-size: 0.95rem; word-break: break-all; text-align: center;">
                                    Rp <?= number_format($stats['total'] ?? 0, 0, ',', '.') ?>
                                </div>
                                <div class="text-muted small" style="font-size: 0.75rem;">Total Nominal</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tagihan Terbaru -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm p-4 anim-fade-in-up delay-300" style="border-radius: 16px;">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-list-ul me-2 text-primary"></i>
                                Tagihan Terbaru
                            </h5>
                            <a href="<?= base_url('orangtua/pembayaran') ?>" class="ot-btn-secondary py-1.5 px-3">
                                Lihat Semua
                            </a>
                        </div>

                        <?php if (empty($tagihan_terbaru)) : ?>
                            <div class="text-center py-5">
                                <i class="bi bi-check-circle-fill" style="font-size: 3.5rem; color: var(--ot-success);"></i>
                                <h5 class="mt-3 mb-1 fw-bold">Semua Tagihan Lunas!</h5>
                                <p class="text-muted mb-0 small">Terima kasih, tidak ada tagihan tertunggak saat ini.</p>
                            </div>
                        <?php else : ?>
                            <?php foreach ($tagihan_terbaru as $tagihan) : ?>
                                <div class="tagihan-item p-3 mb-2 rounded border" style="transition: all 0.3s ease;">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <?php
                                            $statusColor = $tagihan['status'] === 'verified' ? 'success' : ($tagihan['status'] === 'rejected' ? 'danger' : 'warning');
                                            $statusBg = $tagihan['status'] === 'verified' ? 'rgba(16, 185, 129, 0.1)' : ($tagihan['status'] === 'rejected' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(245, 158, 11, 0.1)');
                                            $statusIcon = $tagihan['status'] === 'verified' ? 'check-circle-fill' : ($tagihan['status'] === 'rejected' ? 'x-circle-fill' : 'clock-fill');
                                            $statusText = $tagihan['status'] === 'verified' ? 'Lunas' : ($tagihan['status'] === 'rejected' ? 'Ditolak' : 'Menunggu');
                                            ?>
                                            <div class="status-icon d-flex align-items-center justify-content-center rounded-3" style="background: <?= $statusBg ?>; color: var(--ot-<?= $statusColor ?>); width: 42px; height: 42px; font-size: 1.2rem;">
                                                <i class="bi bi-<?= $statusIcon ?>"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark"><?= esc($tagihan['judul']) ?></h6>
                                                <small class="text-muted">
                                                    <?= $tagihan['batas_bayar']
                                                        ? 'Batas: ' . date('d M Y', strtotime($tagihan['batas_bayar']))
                                                        : 'Tidak ada batas waktu'; ?>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="text-md-end d-flex align-items-center gap-3">
                                            <div>
                                                <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                                    Rp <?= number_format($tagihan['nominal'], 0, ',', '.') ?>
                                                </div>
                                                <span class="ot-badge ot-badge-<?= $tagihan['status'] === 'verified' ? 'verified' : ($tagihan['status'] === 'rejected' ? 'rejected' : 'pending') ?>">
                                                    <?= $statusText ?>
                                                </span>
                                            </div>
                                            <a href="<?= base_url('orangtua/pembayaran/' . $tagihan['id']) ?>" 
                                               class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" 
                                               style="height: 36px; width: 36px; border-radius: 8px;" title="Detail Pembayaran">
                                                <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- E-Book Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm p-4 anim-fade-in-up delay-400" style="border-radius: 16px;">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-book me-2 text-primary"></i>
                                E-Book Terbaru
                            </h5>
                            <a href="<?= base_url('ebook') ?>" class="ot-btn-secondary py-1.5 px-3">
                                Lihat Semua
                            </a>
                        </div>

                        <?php if (empty($ebooks)) : ?>
                            <div class="text-center py-5">
                                <i class="bi bi-journal-x" style="font-size: 3.5rem; color: var(--ot-text-muted);"></i>
                                <h5 class="mt-3 mb-1 fw-bold">Belum Ada E-Book</h5>
                                <p class="text-muted mb-0 small">Buku elektronik edukatif akan segera diunggah admin.</p>
                            </div>
                        <?php else : ?>
                            <div class="row g-3">
                                <?php foreach ($ebooks as $ebook) : ?>
                                    <div class="col-6 col-md-3">
                                        <div class="ebook-card h-100 border rounded-3 overflow-hidden shadow-xs d-flex flex-column justify-content-between" style="transition: all 0.3s ease;">
                                            <div>
                                                <?php if (!empty($ebook['cover'])) : ?>
                                                    <img src="<?= base_url('writable/uploads/ebook/cover/' . $ebook['cover']) ?>"
                                                         alt="<?= esc($ebook['judul']) ?>"
                                                         class="ebook-cover w-100" style="height: 160px; object-fit: cover;">
                                                <?php else : ?>
                                                    <div class="ebook-placeholder w-100 d-flex align-items-center justify-content-center bg-light text-muted" style="height: 160px; font-size: 2rem;">
                                                        <i class="bi bi-book"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="p-3">
                                                    <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.85rem; line-height: 1.3;">
                                                        <?= esc($ebook['judul']) ?>
                                                    </h6>
                                                    <?php if (!empty($ebook['penulis'])) : ?>
                                                        <p class="mb-1 text-muted small" style="font-size: 0.75rem;"><?= esc($ebook['penulis']) ?></p>
                                                    <?php endif; ?>
                                                    <?php if (!empty($ebook['kategori'])) : ?>
                                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded px-2 py-0.5" style="font-size: 0.65rem;">
                                                            <?= esc($ebook['kategori']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="p-3 pt-0">
                                                <a href="<?= base_url('ebook/download/' . $ebook['id']) ?>" class="btn btn-sm btn-outline-primary w-100" style="border-radius: 8px;">
                                                    <i class="bi bi-download me-1"></i> Unduh
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5 text-muted border-top bg-white">
        <p class="mb-0 small">Copyright &copy; 2026 RA Perwanida. Hak Cipta Dilindungi.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>