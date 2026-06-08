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
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
    </style>
</head>
<body class="bg-light">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
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
    <main class="py-5">
        <div class="container">
            <!-- Header -->
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2" style="color: var(--ot-primary);">
                    <i class="ti ti-book me-2"></i>
                    Koleksi E-Book
                </h2>
                <p class="text-muted">Kumpulan e-book pembelajaran untuk anak-anak TK</p>
            </div>

            <!-- Filter -->
            <?php if (!empty($kategoris)) : ?>
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                    <a href="<?= base_url('ebook') ?>"
                       class="btn <?= !$filter_kategori ? 'btn-primary' : 'btn-light'; ?> btn-sm">
                        Semua
                    </a>
                    <?php foreach ($kategoris as $k) : ?>
                        <?php if ($k['kategori']) : ?>
                            <a href="<?= base_url('ebook?kategori=' . urlencode($k['kategori'])) ?>"
                               class="btn <?= $filter_kategori === $k['kategori'] ? 'btn-primary' : 'btn-light'; ?> btn-sm">
                                <?= esc($k['kategori']) ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Alert -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- E-Books Grid -->
            <?php if (empty($ebooks)) : ?>
                <div class="card border-0 shadow-sm p-5 text-center">
                    <i class="ti ti-book-off" style="font-size: 4rem; color: #cbd5e1;"></i>
                    <h5 class="mt-3 mb-1">Belum Ada E-Book</h5>
                    <p class="text-muted">E-book akan segera tersedia.</p>
                </div>
            <?php else : ?>
                <div class="row g-4">
                    <?php foreach ($ebooks as $ebook) : ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="ebook-card h-100">
                                <?php if ($ebook['cover']) : ?>
                                    <img src="<?= base_url('writable/uploads/ebook/cover/' . $ebook['cover']) ?>"
                                         alt="<?= esc($ebook['judul']) ?>"
                                         class="ebook-cover">
                                <?php else : ?>
                                    <div class="ebook-placeholder">
                                        <i class="ti ti-book"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="p-3">
                                    <h6 class="mb-1 fw-bold"><?= esc($ebook['judul']) ?></h6>
                                    <?php if ($ebook['penulis']) : ?>
                                        <p class="mb-1 text-muted small"><?= esc($ebook['penulis']) ?></p>
                                    <?php endif; ?>
                                    <?php if ($ebook['kategori']) : ?>
                                        <span class="badge bg-primary mb-2"><?= esc($ebook['kategori']) ?></span>
                                    <?php endif; ?>
                                    <?php if ($ebook['kelas']) : ?>
                                        <div class="small text-muted mb-2">
                                            <i class="ti ti-users me-1"></i> <?= esc($ebook['kelas']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($ebook['deskripsi']) : ?>
                                        <p class="mb-2 small text-muted" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            <?= esc($ebook['deskripsi']) ?>
                                        </p>
                                    <?php endif; ?>
                                    <a href="<?= base_url('ebook/download/' . $ebook['id']) ?>"
                                       class="btn btn-primary btn-sm w-100">
                                        <i class="ti ti-download me-1"></i> Download
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
    <footer class="text-center py-4 text-muted border-top bg-white">
        <p class="mb-0 small">Copyright &copy; 2026 RA Perwanida</p>
    </footer>

    <script src="<?= base_url('assets/dashboard/js/main.js') ?>"></script>
</body>
</html>