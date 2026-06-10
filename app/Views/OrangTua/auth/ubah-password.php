<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Password - RA Perwanida</title>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/main.css?v=20260523a') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --ot-primary: #8b5cf6; --ot-primary-dark: #7c3aed; }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; background: linear-gradient(135deg, rgba(139, 92, 246, 0.08) 0%, rgba(167, 139, 250, 0.05) 50%, #f6f8fb 100%); min-height: 100vh; }
        .card-custom { background: #fff; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(139, 92, 246, 0.15); border: 1px solid rgba(139, 92, 246, 0.1); }
        .form-control:focus { border-color: var(--ot-primary); box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15); }
        .btn-primary-custom { background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%); color: #fff; border: none; padding: 0.875rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 1rem; transition: all 0.3s ease; width: 100%; }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(139, 92, 246, 0.35); color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center py-5">
            <div class="col-12 col-sm-10 col-md-6 col-lg-5">
                <div class="card-custom p-4 p-sm-5">
                    <div class="text-center mb-4">
                        <img src="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>" alt="Logo" width="60" height="60" class="mb-3">
                        <h4 style="color: var(--ot-primary);">Ubah Password</h4>
                        <p class="text-muted">Ubah password akun Anda</p>
                    </div>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            <?= esc(session()->getFlashdata('success')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('orangtua/auth/simpan-password') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">
                                <i class="bi bi-lock me-1"></i> Password Lama
                            </label>
                            <input type="password" name="password_lama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">
                                <i class="bi bi-key me-1"></i> Password Baru
                            </label>
                            <input type="password" name="password_baru" class="form-control" required minlength="6">
                            <div class="form-text">Minimal 6 karakter</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">
                                <i class="bi bi-key-fill me-1"></i> Konfirmasi Password Baru
                            </label>
                            <input type="password" name="konfirmasi_password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn-primary-custom">
                            <i class="bi bi-check2 me-2"></i> Simpan Password
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <a href="<?= base_url('orangtua/dashboard') ?>" class="text-decoration-none text-muted">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>