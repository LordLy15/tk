<?php
$navGroups = [
    [
        'label' => 'Utama',
        'items' => [
            ['label' => 'Dashboard', 'url' => 'admin', 'icon' => 'ti-home'],
            ['label' => 'Data Murid', 'url' => 'murid', 'icon' => 'ti-school'],
            ['label' => 'Data Guru', 'url' => 'guru', 'icon' => 'ti-user'],
            ['label' => 'Data Kelas', 'url' => 'kelas', 'icon' => 'ti-users'],
            ['label' => 'Data Pendidikan', 'url' => 'pendidikan', 'icon' => 'ti-school'],
            // MENU PENDAFTARAN DITAMBAHKAN DI SINI
            ['label' => 'Data Pendaftaran', 'url' => 'admin/pendaftaran', 'icon' => 'ti-clipboard-list'],
        ],
    ],
    [
        'label' => 'Manajemen',
        'items' => [
            ['label' => 'Kehadiran', 'url' => 'kehadiran', 'icon' => 'ti-clipboard-check'],
            ['label' => 'Aktivitas', 'url' => 'aktivitas', 'icon' => 'ti-target'],
            ['label' => 'Orang Tua', 'url' => 'orang-tua', 'icon' => 'ti-users-group'],
            ['label' => 'Jadwal Kelas', 'url' => 'jadwal', 'icon' => 'ti-calendar'],
        ],
    ],
    [
        'label' => 'Informasi',
        'items' => [
            ['label' => 'Pengumuman', 'url' => 'pengumuman', 'icon' => 'ti-bell'],
            ['label' => 'Libur Sekolah', 'url' => 'libur', 'icon' => 'ti-calendar-off'],
        ],
    ],
];
?>

<aside id="sidebar" class="sidebar">
    <div class="logo-area">
        <a href="<?= base_url('admin') ?>" class="brand-link d-inline-flex">
            <img src="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>"
                 alt="Logo"
                 width="28"
                 height="28">

            <span class="brand-text nav-text">RA PERWANIDA</span>
        </a>
    </div>

    <ul class="nav flex-column">
        <?php foreach ($navGroups as $group) : ?>
            <li class="px-4 pt-3 pb-2">
                <small class="nav-text nav-section-label"><?= esc($group['label']) ?></small>
            </li>

            <?php foreach ($group['items'] as $item) : ?>
                <li>
                    <a class="nav-link"
                       href="<?= base_url($item['url']) ?>">
                        <i class="ti <?= esc($item['icon']) ?>"></i>
                        <span class="nav-text"><?= esc($item['label']) ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </ul>
</aside>