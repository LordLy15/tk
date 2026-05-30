<?php
$currentRole = session('role') ?: '';
$canAccess = static function (array $roles) use ($currentRole): bool {
    return $roles === [] || in_array($currentRole, $roles, true);
};

$navGroups = [
    [
        'label' => 'Utama',
        'items' => [
            ['label' => 'Dashboard', 'url' => 'admin', 'icon' => 'ti-home', 'roles' => ['Administrator', 'Admin', 'Guru', 'Staff']],
            ['label' => 'Data Murid', 'url' => 'murid', 'icon' => 'ti-school', 'roles' => ['Administrator', 'Admin', 'Staff']],
            ['label' => 'Data Guru', 'url' => 'guru', 'icon' => 'ti-user', 'roles' => ['Administrator', 'Admin', 'Staff']],
            ['label' => 'Data Kelas', 'url' => 'kelas', 'icon' => 'ti-users', 'roles' => ['Administrator', 'Admin', 'Staff']],
            ['label' => 'Data Pendidikan', 'url' => 'pendidikan', 'icon' => 'ti-school', 'roles' => ['Administrator', 'Admin']],
            // MENU PENDAFTARAN DITAMBAHKAN DI SINI
            ['label' => 'Data Pendaftaran', 'url' => 'admin/pendaftaran', 'icon' => 'ti-clipboard-list', 'roles' => ['Administrator', 'Admin', 'Staff']],
        ],
    ],
    [
        'label' => 'Manajemen',
        'items' => [
            ['label' => 'Kehadiran', 'url' => 'kehadiran', 'icon' => 'ti-clipboard-check', 'roles' => ['Administrator', 'Admin', 'Guru']],
            ['label' => 'Aktivitas', 'url' => 'aktivitas', 'icon' => 'ti-target', 'roles' => ['Administrator', 'Admin', 'Guru']],
            ['label' => 'Orang Tua', 'url' => 'orang-tua', 'icon' => 'ti-users-group', 'roles' => ['Administrator', 'Admin']],
            ['label' => 'Jadwal Kelas', 'url' => 'jadwal', 'icon' => 'ti-calendar', 'roles' => ['Administrator', 'Admin', 'Guru']],
        ],
    ],
    [
        'label' => 'Informasi',
        'items' => [
            ['label' => 'Pengumuman', 'url' => 'pengumuman', 'icon' => 'ti-bell', 'roles' => ['Administrator', 'Admin', 'Staff']],
            ['label' => 'Libur Sekolah', 'url' => 'libur', 'icon' => 'ti-calendar-off', 'roles' => ['Administrator', 'Admin', 'Guru', 'Staff']],
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
            <?php $items = array_values(array_filter($group['items'], static fn ($item) => $canAccess($item['roles'] ?? []))); ?>
            <?php if ($items === []) : ?>
                <?php continue; ?>
            <?php endif; ?>

            <li class="px-4 pt-3 pb-2">
                <small class="nav-text nav-section-label"><?= esc($group['label']) ?></small>
            </li>

            <?php foreach ($items as $item) : ?>
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
