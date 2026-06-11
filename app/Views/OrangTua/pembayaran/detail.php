<?php 
$t = $tagihan; 
$namaOrtu = session()->get('orangtua_nama') ?? 'Orang Tua';
?>
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
        .ot-badge-verified { background: rgba(16, 185, 129, 0.1) !important; color: #059669 !important; border-color: rgba(16, 185, 129, 0.2) !important; }
        .ot-badge-rejected { background: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; border-color: rgba(239, 68, 68, 0.2) !important; }
        
        .ot-btn-primary { 
            background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%) !important; 
            color: #fff !important; 
            border: none !important; 
            padding: 0.75rem 2rem !important; 
            border-radius: 30px !important; 
            font-weight: 600 !important; 
            transition: all 0.3s ease !important; 
            display: inline-flex !important; 
            align-items: center !important; 
            gap: 0.5rem !important; 
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.15) !important;
            text-decoration: none !important;
        }
        .ot-btn-primary:hover { 
            transform: translateY(-2px) !important; 
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.3) !important; 
        }
        
        .info-box { 
            background: #f8fafc; 
            border: 1px solid #e2e8f0;
            border-radius: 12px; 
            padding: 1rem; 
            height: 100%;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .info-box i {
            font-size: 1.25rem;
            color: var(--ot-primary);
            background: rgba(39, 174, 96, 0.08);
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .info-box.warning i {
            color: var(--ot-warning);
            background: rgba(245, 158, 11, 0.08);
        }

        .upload-dropzone {
            border: 2px dashed #cbd5e1 !important;
            background-color: #f8fafc;
            border-radius: 16px;
            padding: 2.25rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .upload-dropzone:hover {
            border-color: var(--ot-primary) !important;
            background-color: rgba(39, 174, 96, 0.02);
        }
        .upload-dropzone input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }
        
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        .anim-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; opacity: 0; }
        .delay-100 { animation-delay: 100ms; }
        
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
                    <a href="<?= base_url('orangtua/pembayaran') ?>" class="ot-back-btn" title="Kembali">
                        <i class="bi bi-arrow-left"></i>
                    </a>
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

                    <!-- Alert -->
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm anim-fade-in-up" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= esc(session()->getFlashdata('success')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm anim-fade-in-up" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Detail Card -->
                    <div class="ot-card p-4 mb-4 anim-fade-in-up">
                        <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3 pb-3 border-bottom">
                            <div>
                                <small class="text-muted d-block uppercase tracking-wider mb-1" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">DETAIL TAGIHAN</small>
                                <h4 class="fw-bold mb-2 text-dark" style="font-size: 1.35rem;"><?= esc(ucwords(strtolower($t['judul']))) ?></h4>
                                <?php $statusClass = $t['status'] === 'verified' ? 'ot-badge-verified' : ($t['status'] === 'rejected' ? 'ot-badge-rejected' : 'ot-badge-pending'); ?>
                                <?php $statusLabel = $t['status'] === 'verified' ? 'Lunas' : ($t['status'] === 'rejected' ? 'Ditolak' : 'Menunggu Verifikasi'); ?>
                                <?php $statusIcon = $t['status'] === 'verified' ? 'check-circle' : ($t['status'] === 'rejected' ? 'x-circle' : 'clock'); ?>
                                <span class="ot-badge <?= $statusClass ?>">
                                    <i class="bi bi-<?= $statusIcon ?>"></i>
                                    <?= $statusLabel ?>
                                </span>
                            </div>
                            <div class="text-start text-md-end">
                                <small class="text-muted d-block" style="font-size: 0.75rem; font-weight: 600;">Jumlah Tagihan</small>
                                <h3 class="fw-bold mb-0 text-success" style="color: var(--ot-primary) !important; font-size: 1.75rem;">
                                    Rp <?= number_format($t['nominal'], 0, ',', '.') ?>
                                </h3>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <?php if ($t['batas_bayar']) : ?>
                                <div class="col-12 col-md-4">
                                    <div class="info-box warning">
                                        <i class="bi bi-calendar-x"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.7rem; font-weight: 600; line-height: 1.2;">Batas Pembayaran</small>
                                            <span class="fw-bold text-dark" style="font-size: 0.9rem;"><?= date('d M Y', strtotime($t['batas_bayar'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($t['tanggal_bayar']) : ?>
                                <div class="col-12 col-md-4">
                                    <div class="info-box">
                                        <i class="bi bi-calendar-check"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.7rem; font-weight: 600; line-height: 1.2;">Tanggal Bayar</small>
                                            <span class="fw-bold text-dark" style="font-size: 0.9rem;"><?= date('d M Y', strtotime($t['tanggal_bayar'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($t['keterangan']) : ?>
                                <div class="col-12 col-md-4">
                                    <div class="info-box">
                                        <i class="bi bi-info-circle"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.7rem; font-weight: 600; line-height: 1.2;">Keterangan</small>
                                            <span class="fw-semibold text-dark" style="font-size: 0.9rem;"><?= esc($t['keterangan']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($t['status'] === 'rejected' && $t['catatan_admin']) : ?>
                            <div class="alert alert-danger mb-4 d-flex align-items-center gap-2 rounded-3 border-danger-subtle">
                                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                                <div>
                                    <strong>Pembayaran Ditolak:</strong> <?= esc($t['catatan_admin']) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($t['bukti_bayar']) : ?>
                            <div class="alert alert-success bg-success-subtle text-success border border-success-subtle mb-4 rounded-3 d-flex align-items-center gap-2" style="background-color: rgba(39, 174, 96, 0.08) !important; color: var(--ot-primary) !important;">
                                <i class="bi bi-cloud-check-fill fs-5"></i>
                                <div>
                                    <strong>Bukti transfer telah terkirim.</strong> Staf sekolah akan memverifikasi bukti pembayaran Anda.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="fw-bold text-dark mb-2 d-block" style="font-size: 0.9rem;"><i class="bi bi-image me-1"></i> Bukti Pembayaran:</label>
                                <div class="p-3 border rounded-3 bg-light text-center">
                                    <?php $ext = strtolower(pathinfo($t['bukti_bayar'], PATHINFO_EXTENSION)); ?>
                                    <?php if (in_array($ext, ['jpg', 'jpeg', 'png'])) : ?>
                                        <a href="<?= base_url('uploads/bukti_bayar/' . $t['bukti_bayar']) ?>" target="_blank" title="Klik untuk memperbesar">
                                            <img src="<?= base_url('uploads/bukti_bayar/' . $t['bukti_bayar']) ?>" alt="Bukti Transfer" class="img-fluid rounded border shadow-sm" style="max-height: 280px; object-fit: contain;">
                                        </a>
                                    <?php else : ?>
                                        <a href="<?= base_url('uploads/bukti_bayar/' . $t['bukti_bayar']) ?>" class="btn btn-outline-success btn-sm rounded-pill" target="_blank" style="border-color: var(--ot-primary); color: var(--ot-primary);">
                                            <i class="bi bi-file-pdf me-2"></i> Lihat Dokumen (PDF)
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Bukti Bayar -->
                    <?php if ($t['status'] !== 'verified') : ?>
                        <div class="ot-card p-4 anim-fade-in-up delay-100">
                            <h5 class="fw-bold text-dark mb-3">
                                <i class="bi bi-upload me-2 text-success" style="color: var(--ot-primary) !important;"></i>
                                Unggah Bukti Pembayaran
                            </h5>
                            
                            <form action="<?= base_url('orangtua/pembayaran/upload/' . $t['id']) ?>"
                                  method="post"
                                  enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-muted small mb-2">Pilih Foto Bukti Transfer Bank / Resi Pembayaran</label>
                                    
                                    <!-- Premium Drag & Drop Area -->
                                    <div class="upload-dropzone" id="dropzoneContainer">
                                        <input type="file"
                                               id="bukti_bayar"
                                               name="bukti_bayar"
                                               accept=".jpg,.jpeg,.png,.pdf"
                                               required>
                                        <div class="dropzone-content" id="dropzoneContent">
                                            <i class="bi bi-cloud-arrow-up-fill text-success mb-2" style="color: var(--ot-primary) !important; font-size: 2.5rem;"></i>
                                            <h6 class="fw-bold text-dark mb-1" id="upload_title">Pilih atau Tarik Berkas Resi Di Sini</h6>
                                            <p class="text-muted small mb-0" id="file_info">Mendukung format JPG, PNG, atau PDF (Maksimal 5MB)</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="ot-btn-primary w-100 justify-content-center py-2.5">
                                    <i class="bi bi-send-fill me-1"></i>
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
    <script>
        document.getElementById('bukti_bayar')?.addEventListener('change', function(e) {
            const fileInfo = document.getElementById('file_info');
            const uploadTitle = document.getElementById('upload_title');
            const dropzone = document.getElementById('dropzoneContainer');
            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                uploadTitle.textContent = "Berkas Bukti Terpilih:";
                fileInfo.innerHTML = `<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 mt-2" style="font-size:0.8rem; word-break:break-all;"><i class="bi bi-file-earmark-check me-1"></i> ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)</span>`;
                dropzone.style.borderColor = 'var(--ot-primary)';
                dropzone.style.backgroundColor = 'rgba(39, 174, 96, 0.03)';
            } else {
                uploadTitle.textContent = "Pilih atau Tarik Berkas Resi Di Sini";
                fileInfo.textContent = "Mendukung format JPG, PNG, atau PDF (Maksimal 5MB)";
                dropzone.style.borderColor = '#cbd5e1';
                dropzone.style.backgroundColor = '#f8fafc';
            }
        });
    </script>
</body>
</html>