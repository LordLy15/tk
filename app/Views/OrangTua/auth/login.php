<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Orang Tua - RA Perwanida</title>
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
        }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: linear-gradient(135deg, rgba(39, 174, 96, 0.08) 0%, rgba(46, 204, 113, 0.05) 50%, #f6f8fb 100%);
            min-height: 100vh;
        }
        .ot-login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(39, 174, 96, 0.15);
            border: 1px solid rgba(39, 174, 96, 0.1);
        }
        .ot-login-input {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        .ot-login-input:focus {
            border-color: var(--ot-primary);
            box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.15);
            outline: none;
        }
        .ot-login-btn {
            background: linear-gradient(135deg, var(--ot-primary) 0%, var(--ot-primary-dark) 100%);
            color: #fff;
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }
        .ot-login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(39, 174, 96, 0.35);
            color: #fff;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .anim-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center py-5">
            <div class="col-12 col-sm-10 col-md-6 col-lg-5">

                <!-- Login Card -->
                <div class="ot-login-card p-4 p-sm-5 anim-fade-in-up">

                    <!-- Logo & Brand -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center gap-3 mb-4">
                            <img src="<?= base_url('assets/logo.png') ?>"
                                 alt="Logo RA Perwanida"
                                 width="54"
                                 height="54"
                                 class="rounded-circle bg-light p-1">
                            <div class="text-start">
                                <span class="fw-bold d-block" style="color: #1e293b; font-size: 1.25rem;">RA PERWANIDA</span>
                                <small class="text-muted">TK PERWANIDA TEMPURSARI</small>
                            </div>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-4 text-center anim-fade-in-up delay-100">
                        <h1 class="h4 fw-bold mb-2" style="color: var(--ot-primary);">Login Orang Tua</h1>
                        <p class="text-muted mb-0">Masuk untuk melihat tagihan dan e-book anak</p>
                    </div>

                    <!-- Alert -->
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show animate" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form action="<?= base_url('orangtua/login') ?>" method="post" class="anim-fade-in-up delay-200">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-muted">
                                <i class="bi bi-envelope me-1"></i> Email
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control ot-login-input"
                                   placeholder="nama@email.com"
                                   value="<?= old('email') ?>"
                                   required
                                   autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-muted">
                                <i class="bi bi-lock me-1"></i> Password
                            </label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control ot-login-input"
                                   placeholder="Masukkan password"
                                   required>
                        </div>

                        <button type="submit" class="ot-login-btn">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Masuk
                        </button>
                    </form>

                    <!-- Footer -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <a href="<?= base_url('/') ?>" class="text-decoration-none small text-muted">
                            <i class="bi bi-house me-1"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>