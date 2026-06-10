<?php
$currentUserName = session('nama_lengkap') ?: session('nama') ?: 'Pengguna';
$currentUserRole = session('role') ?: 'User';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title><?= esc($title ?? 'Dashboard RA PERWANIDA') ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/svg+xml"
        href="/assets/dashboard/images/logo-ra.svg">

    <link rel="shortcut icon" type="image/svg+xml"
        href="/assets/dashboard/images/logo-ra.svg">

    <link rel="stylesheet" href="/assets/dashboard/css/main.css?v=20260523a">
    <link rel="stylesheet" href="/assets/dashboard/css/admin-custom.css?v=20260523a">

</head>

<body>

<div id="overlay" class="overlay"></div>

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

            <img src="/assets/dashboard/images/avatar-1.jpg"
                 class="rounded-circle me-2"
                 width="40"
                 height="40">

            <div>

                <span class="fw-bold d-block text-dark">
                    <?= esc($currentUserName) ?>
                </span>

                <small class="text-muted">
                    <?= esc($currentUserRole) ?>
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

<?= $this->include('Admin/partials/sidebar') ?>

<main id="content" class="content py-4">

    <div class="container-fluid admin-content">

        <?php 
            $mFile = WRITEPATH . 'maintenance.json';
            if (file_exists($mFile) && ($mData = json_decode(file_get_contents($mFile), true)) && ($mData['active'] ?? false)) : 
        ?>
            <div class="alert alert-warning border-warning d-flex align-items-center gap-2 mb-3 shadow-sm" role="alert" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b;">
                <i class="ti ti-alert-triangle fs-4 text-warning"></i>
                <div class="small fw-semibold text-warning-emphasis">MODE MAINTENANCE AKTIF: Sistem saat ini sedang dalam pemeliharaan offline untuk peran lain.</div>
            </div>
        <?php endif; ?>

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

<script src="/assets/dashboard/js/main.js" type="module"></script>
<script src="/assets/dashboard/js/admin-form.js"></script>
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
