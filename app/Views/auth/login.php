<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Login Admin') ?></title>

    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="shortcut icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dashboard/css/main.css?v=20260523a') ?>">

    <style>
        :root {
            --login-green: #16a34a;
            --login-dark: #0f172a;
            --login-muted: #64748b;
            --login-border: #dbe7df;
        }

        body {
            background:
                linear-gradient(135deg, rgba(22, 163, 74, .12), rgba(14, 165, 233, .08)),
                #f6f8fb;
            color: var(--login-dark);
            min-height: 100vh;
        }

        .login-shell {
            min-height: 100vh;
            padding: 1.5rem;
        }

        .login-card {
            background: #fff;
            border: 1px solid var(--login-border);
            border-radius: 8px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .12);
            max-width: 430px;
            width: 100%;
        }

        .brand-mark {
            align-items: center;
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            display: inline-flex;
            gap: .75rem;
            padding: .7rem .85rem;
        }

        .brand-mark img {
            height: 42px;
            width: 42px;
        }

        .brand-mark span {
            color: var(--login-dark);
            display: block;
            font-size: .95rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .brand-mark small {
            color: var(--login-muted);
            font-size: .72rem;
            font-weight: 600;
        }

        .login-title {
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: 0;
        }

        .btn-login {
            background: var(--login-green);
            border-color: var(--login-green);
            font-weight: 700;
        }

        .btn-login:hover,
        .btn-login:focus {
            background: #15803d;
            border-color: #15803d;
        }
    </style>
</head>

<body>
    <main class="login-shell d-flex align-items-center justify-content-center">
        <section class="login-card p-4 p-sm-5">
            <div class="text-center mb-4">
                <a class="brand-mark text-decoration-none" href="<?= base_url('/') ?>">
                    <img src="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>" alt="Logo RA Perwanida">
                    <span>
                        RA PERWANIDA
                        <small>TEMPURSARI</small>
                    </span>
                </a>
            </div>

            <div class="mb-4">
                <h1 class="login-title mb-1">Login Admin</h1>
                <p class="text-muted mb-0">Masuk dengan akun yang sudah terdaftar</p>
            </div>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/login') ?>" method="post" autocomplete="on">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="login" class="form-label">Username atau Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-user"></i></span>
                        <input
                            id="login"
                            name="login"
                            type="text"
                            class="form-control"
                            value="<?= esc(old('login')) ?>"
                            autocomplete="username"
                            required
                            autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-lock"></i></span>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control"
                            autocomplete="current-password"
                            required>
                    </div>
                </div>

                <button class="btn btn-login text-white w-100" type="submit">
                    <i class="ti ti-login me-2"></i>
                    Login
                </button>
            </form>
        </section>
    </main>

    <script src="<?= base_url('assets/dashboard/js/main.js') ?>" type="module"></script>
</body>

</html>
