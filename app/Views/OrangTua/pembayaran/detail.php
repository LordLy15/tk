<?php $t = $tagihan; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Tagihan - RA Perwanida</title>
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
        .ot-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .ot-badge { display: inline-flex; align-items: center; padding: 0.35rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; gap: 0.35rem; }
        .ot-badge-pending { background: rgba(245, 158, 11, 0.15); color: #b45309; }
        .ot-badge-verified { background: rgba(16, 185, 129, 0.15); color: #047857; }
        .ot-badge-rejected { background: rgba(239, 68, 68, 0.15); color: #dc2626; }
        .ot-btn-primary { background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%); color: #fff; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.5rem; }
        .ot-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(139, 92, 246, 0.35); color: #fff; }
        .ot-login-input { border: 2px solid #e2e8f0; border-radius: 10px; padding: 0.75rem 1rem; transition: all 0.3s ease; }
        .ot-login-input:focus { border-color: var(--ot-primary); box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15); outline: none; }
        .info-box { background: #f8fafc; border-radius: 12px; padding: 1rem; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        .anim-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; opacity: 0; }
        .delay-100 { animation-delay: 100ms; }
    </style>
</head>
<body>
    <nav class="ot-topbar fixed-top py-3 px-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <a href="<?= base_url('orangtua/pembayaran') ?>" class="btn btn-light btn-sm">
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
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">

                    <!-- Alert -->
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show anim-fade-in-up" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            <?= esc(session()->getFlashdata('success')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show anim-fade-in-up" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Detail Card -->
                    <div class="ot-card p-4 mb-4 anim-fade-in-up">
                        <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3">
                            <div>
                                <h4 class="fw-bold mb-2"><?= esc($t['judul']) ?></h4>
                                <?php $statusClass = $t['status'] === 'verified' ? 'ot-badge-verified' : ($t['status'] === 'rejected' ? 'ot-badge-rejected' : 'ot-badge-pending'); ?>
                                <?php $statusLabel = $t['status'] === 'verified' ? 'Lunas' : ($t['status'] === 'rejected' ? 'Ditolak' : 'Menunggu'); ?>
                                <span class="ot-badge <?= $statusClass ?>">
                                    <?= $statusLabel ?>
                                </span>
                            </div>
                            <div class="text-start text-md-end">
                                <small class="text-muted">Total Tagihan</small>
                                <h3 class="fw-bold mb-0" style="color: var(--ot-primary);">
                                    Rp <?= number_format($t['nominal'], 0, ',', '.') ?>
                                </h3>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <?php if ($t['batas_bayar']) : ?>
                                <div class="col-6 col-md-4">
                                    <div class="info-box">
                                        <small class="text-muted d-block mb-1">Batas Pembayaran</small>
                                        <span class="fw-semibold"><?= date('d M Y', strtotime($t['batas_bayar'])) ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($t['tanggal_bayar']) : ?>
                                <div class="col-6 col-md-4">
                                    <div class="info-box">
                                        <small class="text-muted d-block mb-1">Tanggal Bayar</small>
                                        <span class="fw-semibold"><?= date('d M Y', strtotime($t['tanggal_bayar'])) ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($t['keterangan']) : ?>
                                <div class="col-12 col-md-4">
                                    <div class="info-box">
                                        <small class="text-muted d-block mb-1">Keterangan</small>
                                        <span class="fw-semibold"><?= esc($t['keterangan']) ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($t['status'] === 'rejected' && $t['catatan_admin']) : ?>
                            <div class="alert alert-danger mb-4">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                <strong>Catatan Admin:</strong> <?= esc($t['catatan_admin']) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($t['bukti_bayar']) : ?>
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-file-earmark-check me-2"></i>
                                <strong>Bukti bayar sudah diupload.</strong>
                                Silakan tunggu verifikasi dari admin.
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Bukti Bayar -->
                    <?php if ($t['status'] !== 'verified') : ?>
                        <div class="ot-card p-4 anim-fade-in-up delay-100">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-upload" style="color: var(--ot-primary);"></i>
                                Upload Bukti Pembayaran
                            </h5>
                            <form action="<?= base_url('orangtua/pembayaran/upload/' . $t['id']) ?>"
                                  method="post"
                                  enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label for="bukti_bayar" class="form-label fw-semibold text-muted">
                                        Pilih file bukti transfer
                                    </label>
                                    <input type="file"
                                           id="bukti_bayar"
                                           name="bukti_bayar"
                                           class="form-control ot-login-input"
                                           accept=".jpg,.jpeg,.png,.pdf"
                                           required>
                                    <div class="form-text">Format: JPG, PNG, atau PDF. Maksimal 5MB.</div>
                                </div>
                                <button type="submit" class="ot-btn-primary">
                                    <i class="bi bi-send"></i>
                                    Kirim Bukti Pembayaran
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>