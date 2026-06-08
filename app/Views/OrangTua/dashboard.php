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
            --ot-primary: #8b5cf6;
            --ot-primary-dark: #7c3aed;
            --ot-primary-light: #a78bfa;
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
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }
        .ot-topbar-brand {
            font-weight: 700;
            color: var(--ot-primary);
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
            box-shadow: 0 12px 40px rgba(139, 92, 246, 0.15);
        }
        .ot-card-hero {
            background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%);
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
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.35);
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
            box-shadow: 0 12px 30px rgba(139, 92, 246, 0.15);
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
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.1);
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
    </style>
</head>
<body>

    <!-- Topbar -->
    <nav class="ot-topbar fixed-top py-3 px-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>"
                         alt="Logo" width="40" height="40">
                    <span class="ot-topbar-brand">RA Perwanida</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-md-block">
                        <span class="fw-semibold d-block" style="color: #1e293b;"><?= esc($namaOrtu) ?></span>
                        <small class="text-muted">Orang Tua</small>
                    </div>
                    <a href="<?= base_url('orangtua/logout') ?>"
                       class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
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
                <div class="alert alert-success alert-dismissible fade show animate" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show animate" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Welcome Section -->
            <div class="mb-4 anim-fade-in-up">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-person-check" style="color: var(--ot-primary);"></i>
                    Selamat datang, <?= esc($namaOrtu) ?>!
                </h4>
                <?php if ($namaSiswa) : ?>
                    <p class="text-muted mb-0">
                        <i class="bi bi-heart-fill text-danger me-1"></i>
                        Orang tua dari <strong><?= esc($namaSiswa) ?></strong>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Hero Card - Tagihan Aktif -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="ot-card ot-card-hero p-4 p-md-5 anim-fade-in-up delay-100">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <i class="bi bi-receipt" style="font-size: 2.5rem;"></i>
                                    <div>
                                        <h3 class="mb-0 fw-bold">Tagihan Aktif</h3>
                                        <p class="mb-0">
                                            <?= ($stats['pending_count'] ?? 0) ?> tagihan menunggu pembayaran
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="mb-3">
                                    <small class="opacity-75">Total Tagihan</small>
                                    <h2 class="mb-0 fw-bold">
                                        Rp <?= number_format($stats['pending'] ?? 0, 0, ',', '.') ?>
                                    </h2>
                                </div>
                                <a href="<?= base_url('orangtua/pembayaran') ?>" class="ot-btn-primary">
                                    <i class="bi bi-credit-card"></i>
                                    Bayar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-6 col-lg-3 mb-3">
                    <div class="ot-card ot-stat-card anim-fade-in-up delay-200">
                        <div class="ot-stat-icon" style="background: rgba(139, 92, 246, 0.15); color: var(--ot-primary);">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="ot-stat-number" style="color: var(--ot-primary);">
                            <?= ($stats['pending_count'] ?? 0) + ($stats['lunas_count'] ?? 0) ?>
                        </div>
                        <div class="ot-stat-label">Total Tagihan</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-3">
                    <div class="ot-card ot-stat-card anim-fade-in-up delay-300">
                        <div class="ot-stat-icon" style="background: rgba(245, 158, 11, 0.15); color: var(--ot-warning);">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="ot-stat-number" style="color: var(--ot-warning);">
                            <?= $stats['pending_count'] ?? 0 ?>
                        </div>
                        <div class="ot-stat-label">Menunggu</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-3">
                    <div class="ot-card ot-stat-card anim-fade-in-up delay-400">
                        <div class="ot-stat-icon" style="background: rgba(16, 185, 129, 0.15); color: var(--ot-success);">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="ot-stat-number" style="color: var(--ot-success);">
                            <?= $stats['lunas_count'] ?? 0 ?>
                        </div>
                        <div class="ot-stat-label">Lunas</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-3">
                    <div class="ot-card ot-stat-card anim-fade-in-up delay-500">
                        <div class="ot-stat-icon" style="background: rgba(139, 92, 246, 0.15); color: var(--ot-primary);">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div class="ot-stat-number" style="color: var(--ot-primary); font-size: 1.25rem;">
                            Rp <?= number_format($stats['total'] ?? 0, 0, ',', '.') ?>
                        </div>
                        <div class="ot-stat-label">Total Keseluruhan</div>
                    </div>
                </div>
            </div>

            <!-- Tagihan Terbaru -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="ot-card p-4 anim-fade-in-up delay-300">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-list-ul" style="color: var(--ot-primary);"></i>
                                Tagihan Terbaru
                            </h5>
                            <a href="<?= base_url('orangtua/pembayaran') ?>" class="ot-btn-secondary">
                                Lihat Semua
                            </a>
                        </div>

                        <?php if (empty($tagihan_terbaru)) : ?>
                            <div class="text-center py-5">
                                <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: var(--ot-success);"></i>
                                <h5 class="mt-3 mb-1">Semua Lunas!</h5>
                                <p class="text-muted mb-0">Tidak ada tagihan yang menunggu.</p>
                            </div>
                        <?php else : ?>
                            <?php foreach ($tagihan_terbaru as $tagihan) : ?>
                                <div class="tagihan-item">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <?php
                                            $statusColor = $tagihan['status'] === 'verified' ? 'success' : ($tagihan['status'] === 'rejected' ? 'danger' : 'warning');
                                            $statusBg = $tagihan['status'] === 'verified' ? 'rgba(16, 185, 129, 0.1)' : ($tagihan['status'] === 'rejected' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(245, 158, 11, 0.1)');
                                            $statusIcon = $tagihan['status'] === 'verified' ? 'check-circle-fill' : ($tagihan['status'] === 'rejected' ? 'x-circle-fill' : 'clock');
                                            $statusText = $tagihan['status'] === 'verified' ? 'Lunas' : ($tagihan['status'] === 'rejected' ? 'Ditolak' : 'Menunggu');
                                            ?>
                                            <div class="status-icon" style="background: <?= $statusBg ?>; color: var(--ot-<?= $statusColor ?>);">
                                                <i class="bi bi-<?= $statusIcon ?>"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold"><?= esc($tagihan['judul']) ?></h6>
                                                <small class="text-muted">
                                                    <?= $tagihan['batas_bayar']
                                                        ? 'Batas: ' . date('d M Y', strtotime($tagihan['batas_bayar']))
                                                        : 'Tidak ada batas waktu'; ?>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold mb-1" style="font-size: 1.1rem;">
                                                Rp <?= number_format($tagihan['nominal'], 0, ',', '.') ?>
                                            </div>
                                            <span class="ot-badge ot-badge-<?= $tagihan['status'] === 'verified' ? 'verified' : ($tagihan['status'] === 'rejected' ? 'rejected' : 'pending') ?>">
                                                <?= $statusText ?>
                                            </span>
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
                    <div class="ot-card p-4 anim-fade-in-up delay-400">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-book" style="color: var(--ot-primary);"></i>
                                E-Book Terbaru
                            </h5>
                            <a href="<?= base_url('ebook') ?>" class="ot-btn-secondary">
                                Lihat Semua
                            </a>
                        </div>

                        <?php if (empty($ebooks)) : ?>
                            <div class="text-center py-5">
                                <i class="bi bi-book" style="font-size: 4rem; color: var(--ot-text-muted);"></i>
                                <h5 class="mt-3 mb-1">Belum Ada E-Book</h5>
                                <p class="text-muted mb-0">E-book akan segera tersedia.</p>
                            </div>
                        <?php else : ?>
                            <div class="row g-3">
                                <?php foreach ($ebooks as $ebook) : ?>
                                    <div class="col-6 col-md-3">
                                        <div class="ebook-card h-100">
                                            <?php if (!empty($ebook['cover'])) : ?>
                                                <img src="<?= base_url('writable/uploads/ebook/cover/' . $ebook['cover']) ?>"
                                                     alt="<?= esc($ebook['judul']) ?>"
                                                     class="ebook-cover">
                                            <?php else : ?>
                                                <div class="ebook-placeholder">
                                                    <i class="bi bi-book"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="p-3">
                                                <h6 class="mb-1 fw-semibold" style="font-size: 0.9rem; line-height: 1.3;">
                                                    <?= esc($ebook['judul']) ?>
                                                </h6>
                                                <?php if (!empty($ebook['penulis'])) : ?>
                                                    <p class="mb-1 text-muted small"><?= esc($ebook['penulis']) ?></p>
                                                <?php endif; ?>
                                                <?php if (!empty($ebook['kategori'])) : ?>
                                                    <span class="badge" style="background: rgba(139, 92, 246, 0.1); color: var(--ot-primary);"><?= esc($ebook['kategori']) ?></span>
                                                <?php endif; ?>
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
    <footer class="text-center py-4 mt-5 text-muted">
        <p class="mb-0 small">Copyright &copy; 2026 RA Perwanida</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>