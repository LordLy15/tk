<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title><?= esc($title ?? 'Dashboard Sekolah TK') ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180"
        href="<?= base_url('assets/dashboard/images/apple-touch-icon.png') ?>">

    <link rel="icon" type="image/png" sizes="32x32"
        href="<?= base_url('assets/dashboard/images/favicon-32x32.png') ?>">

    <link rel="icon" type="image/png" sizes="16x16"
        href="<?= base_url('assets/dashboard/images/favicon-16x16.png') ?>">

    <link rel="stylesheet"
        href="<?= base_url('assets/dashboard/css/main.css?v=20260519') ?>">
    <link rel="stylesheet"
        href="<?= base_url('assets/dashboard/css/admin-custom.css?v=20260521c') ?>">

</head>

<body>

<div id="overlay" class="overlay"></div>

<!-- TOPBAR -->
<nav id="topbar" class="navbar bg-white border-bottom fixed-top topbar px-3">

    <button id="toggleBtn"
        class="d-none d-lg-inline-flex btn btn-light btn-icon btn-sm">

        <i class="ti ti-layout-sidebar-left-expand"></i>

    </button>

    <button id="mobileBtn"
        class="btn btn-light btn-icon btn-sm d-lg-none me-2">

        <i class="ti ti-layout-sidebar-left-expand"></i>

    </button>

    <div class="d-flex align-items-center ms-auto">

    <div class="dropdown">

        <a href="#"
           class="d-flex align-items-center text-decoration-none"
           data-bs-toggle="dropdown">

            <img src="<?= base_url('assets/dashboard/images/avatar-1.jpg') ?>"
                 class="rounded-circle me-2"
                 width="40"
                 height="40">

            <div>

                <span class="fw-bold d-block text-dark">
                    Admin
                </span>

                <small class="text-muted">
                    Administrator
                </small>

            </div>

            <i class="ti ti-chevron-down ms-2"></i>

        </a>

        <ul class="dropdown-menu dropdown-menu-end">

            <li>
                <a class="dropdown-item" href="#">
                    <i class="ti ti-user me-2"></i>
                    Profil Saya
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="#">
                    <i class="ti ti-settings me-2"></i>
                    Pengaturan
                </a>
            </li>

            <li><hr class="dropdown-divider"></li>

            <li>
                <a class="dropdown-item text-danger"
                   href="<?= base_url('logout') ?>">

                    <i class="ti ti-logout me-2"></i>
                    Logout

                </a>
            </li>

        </ul>

    </div>

</div> 

</nav>

<!-- SIDEBAR -->
<?= $this->include('Admin/partials/sidebar') ?>

<!-- MAIN CONTENT -->
<main id="content" class="content py-4">

    <div class="container-fluid admin-content">

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>

    </div>

</main>

<footer class="text-center py-2 mt-5 text-secondary">

    <p class="mb-0">
        Copyright &copy; 2026 Dashboard Sekolah TK
    </p>

</footer>

<script src="<?= base_url('assets/dashboard/js/main.js') ?>"
        type="module"></script>
<script src="<?= base_url('assets/dashboard/js/admin-form.js') ?>"></script>
<script>
    window.addEventListener('load', function () {
        const currentPath = window.location.pathname.replace(/\/$/, '');
        const navLinks = document.querySelectorAll('.sidebar .nav-link');

        navLinks.forEach(function (link) {
            const href = link.getAttribute('href');
            let hrefPath = '';

            link.classList.remove('active');

            if (!href) {
                return;
            }

            try {
                hrefPath = new URL(href, window.location.origin).pathname.replace(/\/$/, '');
            } catch (error) {
                hrefPath = href.replace(/\/$/, '');
            }

            const isDashboard = hrefPath.endsWith('/admin')
                && (currentPath.endsWith('/admin') || currentPath.endsWith('/public'));
            const isChildPage = hrefPath !== '/'
                && !hrefPath.endsWith('/admin')
                && currentPath.startsWith(hrefPath + '/');

            if (hrefPath === currentPath || isDashboard || isChildPage) {
                link.classList.add('active');
            }
        });
    });
</script>

</body>

</html>
