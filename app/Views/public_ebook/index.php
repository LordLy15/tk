<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Book - RA Perwanida</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/main.css?v=20260523a') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/orangtua-custom.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0fdf4 100%);
            min-height: 100vh;
        }

        /* ============================================
           ANIMATIONS - SAMA SEPERTI PEMBAYARAN
           ============================================ */

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Animation Classes */
        .anim-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .anim-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
            opacity: 0;
        }

        .anim-slide-in-left {
            animation: slideInLeft 0.5s ease-out forwards;
            opacity: 0;
        }

        .anim-scale-in {
            animation: scaleIn 0.4s ease-out forwards;
            opacity: 0;
        }

        .anim-float {
            animation: float 3s ease-in-out infinite;
        }

        .anim-bounce-in {
            animation: bounceIn 0.6s ease-out forwards;
            opacity: 0;
        }

        .anim-slide-up {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
        }

        /* Delay Classes - Stagger Effect */
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-500 { animation-delay: 500ms; }
        .delay-600 { animation-delay: 600ms; }
        .delay-700 { animation-delay: 700ms; }
        .delay-800 { animation-delay: 800ms; }

        /* Card Animation - Staggered */
        .ebook-card-animated {
            opacity: 0;
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .ebook-card-animated:nth-child(1) { animation-delay: 0ms; }
        .ebook-card-animated:nth-child(2) { animation-delay: 100ms; }
        .ebook-card-animated:nth-child(3) { animation-delay: 200ms; }
        .ebook-card-animated:nth-child(4) { animation-delay: 300ms; }
        .ebook-card-animated:nth-child(5) { animation-delay: 400ms; }
        .ebook-card-animated:nth-child(6) { animation-delay: 500ms; }
        .ebook-card-animated:nth-child(7) { animation-delay: 600ms; }
        .ebook-card-animated:nth-child(8) { animation-delay: 700ms; }
        .ebook-card-animated:nth-child(9) { animation-delay: 800ms; }
        .ebook-card-animated:nth-child(10) { animation-delay: 900ms; }
        .ebook-card-animated:nth-child(11) { animation-delay: 1000ms; }
        .ebook-card-animated:nth-child(12) { animation-delay: 1100ms; }

        /* ============================================
           E-BOOK CARD STYLES
           ============================================ */

        .ebook-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(39, 174, 96, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(39, 174, 96, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .ebook-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(39, 174, 96, 0.2);
            border-color: rgba(39, 174, 96, 0.4);
        }

        .ebook-cover-wrapper {
            position: relative;
            padding-top: 120%;
            overflow: hidden;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        }

        .ebook-cover {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .ebook-card:hover .ebook-cover {
            transform: scale(1.1);
        }

        .ebook-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            transition: all 0.3s ease;
        }

        .ebook-placeholder i {
            font-size: 4rem;
            color: #27ae60;
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        .ebook-card:hover .ebook-placeholder i {
            transform: scale(1.2);
            opacity: 0.8;
        }

        .ebook-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.4);
            animation: pulse 2s ease-in-out infinite;
            transition: all 0.3s ease;
        }

        .ebook-card:hover .ebook-badge {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(39, 174, 96, 0.5);
        }

        .ebook-content {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .ebook-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.3s ease;
        }

        .ebook-card:hover .ebook-title {
            color: #27ae60;
        }

        .ebook-author {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .ebook-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .ebook-kelas {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.75rem;
            color: #27ae60;
            background: rgba(39, 174, 96, 0.1);
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .ebook-card:hover .ebook-kelas {
            background: rgba(39, 174, 96, 0.2);
            transform: translateX(3px);
        }

        .ebook-description {
            font-size: 0.85rem;
            color: #6b7280;
            line-height: 1.5;
            margin-bottom: 12px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .ebook-download-btn {
            width: 100%;
            padding: 10px 16px;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .ebook-download-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .ebook-download-btn:hover::before {
            left: 100%;
        }

        .ebook-download-btn:hover {
            background: linear-gradient(135deg, #229954 0%, #27ae60 100%);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
        }

        .ebook-download-btn:active {
            transform: scale(0.98);
        }

        .filter-btn {
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            opacity: 0;
            animation: fadeInUp 0.4s ease-out forwards;
        }

        .filter-btn:hover {
            transform: translateY(-3px);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        }

        .filter-btn:not(.active) {
            background: white;
            color: #27ae60;
            border-color: rgba(39, 174, 96, 0.3);
        }

        .filter-btn:not(.active):hover {
            background: rgba(39, 174, 96, 0.15);
            border-color: #27ae60;
            transform: translateY(-2px);
        }

        .header-section {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
            padding: 40px 0;
            margin-bottom: 40px;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 8px 30px rgba(39, 174, 96, 0.2);
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            animation: float 6s ease-in-out infinite;
        }

        .header-section h2 {
            color: white;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .header-section p {
            color: rgba(255, 255, 255, 0.9);
            position: relative;
            z-index: 1;
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            padding: 20px 30px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            z-index: 1;
            animation: bounceIn 0.6s ease-out forwards;
            animation-delay: 0.3s;
            opacity: 0;
        }

        .stats-card .number {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            line-height: 1;
        }

        .stats-card .label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .empty-state i {
            font-size: 5rem;
            color: #d1fae5;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        .empty-state h5 {
            color: #27ae60;
            font-weight: 600;
        }

        .empty-state p {
            color: #6b7280;
        }

        .hero-icon {
            animation: float 3s ease-in-out infinite;
        }

        @media (max-width: 768px) {
            .header-section {
                padding: 30px 0;
                border-radius: 0 0 20px 20px;
            }

            .ebook-card {
                border-radius: 12px;
            }

            .stats-card .number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('/') ?>">
                <img src="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>" alt="Logo" width="36" height="36">
                <span>RA Perwanida</span>
            </a>
            <?php if (session()->get('orangtua_logged_in')) : ?>
                <a href="<?= base_url('orangtua/dashboard') ?>" class="btn btn-light btn-sm">
                    <i class="ti ti-dashboard me-1"></i> Dashboard
                </a>
            <?php else : ?>
                <a href="<?= base_url('orangtua/login') ?>" class="btn btn-outline-light btn-sm">
                    <i class="ti ti-login me-1"></i> Login
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Content -->
    <main>
        <!-- Header Section -->
        <div class="header-section">
            <div class="container">
                <div class="text-center">
                    <h2 class="fw-bold mb-2 anim-fade-in-up">
                        <i class="ti ti-book me-2 hero-icon"></i>
                        Koleksi E-Book
                    </h2>
                    <p class="mb-0 anim-fade-in-up delay-200">Kumpulan e-book pembelajaran untuk anak-anak TK</p>
                </div>

                <?php if (!empty($ebooks)) : ?>
                <div class="row justify-content-center mt-4">
                    <div class="col-auto">
                        <div class="stats-card">
                            <div class="number"><?= count($ebooks) ?></div>
                            <div class="label">Total E-Book</div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="container">
            <!-- Filter -->
            <?php if (!empty($kategoris)) : ?>
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                    <a href="<?= base_url('ebook') ?>"
                       class="btn filter-btn <?= !$filter_kategori ? 'active' : '' ?>">
                        <i class="ti ti-apps me-1"></i> Semua
                    </a>
                    <?php $filterDelay = 100; foreach ($kategoris as $k) : ?>
                        <?php if ($k['kategori']) : ?>
                            <a href="<?= base_url('ebook?kategori=' . urlencode($k['kategori'])) ?>"
                               class="btn filter-btn <?= $filter_kategori === $k['kategori'] ? 'active' : '' ?>"
                               style="animation-delay: <?= $filterDelay ?>ms;">
                                <?= esc($k['kategori']) ?>
                            </a>
                        <?php $filterDelay += 50; endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Alert -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show anim-fade-in-up" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- E-Books Grid -->
            <?php if (empty($ebooks)) : ?>
                <div class="card border-0 shadow-sm empty-state">
                    <i class="ti ti-book-off"></i>
                    <h5 class="mb-2">Belum Ada E-Book</h5>
                    <p class="mb-0">E-book akan segera tersedia. Stay tuned!</p>
                </div>
            <?php else : ?>
                <div class="row g-4">
                    <?php foreach ($ebooks as $index => $ebook) : ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="ebook-card ebook-card-animated" style="animation-delay: <?= ($index * 100) ?>ms;">
                                <div class="ebook-cover-wrapper">
                                    <?php if ($ebook['cover']) : ?>
                                        <img src="<?= base_url('writable/uploads/ebook/cover/' . $ebook['cover']) ?>"
                                             alt="<?= esc($ebook['judul']) ?>"
                                             class="ebook-cover">
                                    <?php else : ?>
                                        <div class="ebook-placeholder">
                                            <i class="ti ti-book"></i>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($ebook['kategori']) : ?>
                                        <span class="ebook-badge">
                                            <?= esc($ebook['kategori']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="ebook-content">
                                    <h6 class="ebook-title"><?= esc($ebook['judul']) ?></h6>

                                    <?php if ($ebook['penulis']) : ?>
                                        <p class="ebook-author">
                                            <i class="ti ti-user me-1"></i>
                                            <?= esc($ebook['penulis']) ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if ($ebook['kelas']) : ?>
                                        <div class="ebook-meta">
                                            <span class="ebook-kelas">
                                                <i class="ti ti-users"></i>
                                                <?= esc($ebook['kelas']) ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($ebook['deskripsi']) : ?>
                                        <p class="ebook-description"><?= esc($ebook['deskripsi']) ?></p>
                                    <?php endif; ?>

                                    <a href="<?= base_url('ebook/download/' . $ebook['id']) ?>"
                                       class="ebook-download-btn"
                                       target="_blank">
                                        <i class="ti ti-download"></i>
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5" style="background: white; border-top: 1px solid #e5e7eb;">
        <p class="mb-0 small text-muted">Copyright &copy; 2026 RA Perwanida Tempursari</p>
    </footer>

    <script src="<?= base_url('assets/dashboard/js/main.js') ?>"></script>
</body>
</html>
