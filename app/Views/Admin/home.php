<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<?php
$dashboardGroups = [
    [
        'title' => 'Ringkasan Sekolah',
        'cards' => [
            [
                'label' => 'Total Siswa',
                'value' => $total_murid ?? 0,
                'icon' => 'ti-school',
                'tone' => 'primary',
            ],
            [
                'label' => 'Total Guru',
                'value' => $total_guru ?? 0,
                'icon' => 'ti-user',
                'tone' => 'success',
            ],
            [
                'label' => 'Total Kelas',
                'value' => $total_kelas ?? 0,
                'icon' => 'ti-users',
                'tone' => 'info',
            ],
            [
                'label' => 'Total Pendaftar',
                'value' => $total_pendaftar ?? 0,
                'icon' => 'ti-clipboard-list',
                'tone' => 'danger',
            ],
        ],
    ],
    [
        'title' => 'Kegiatan Harian',
        'cards' => [
            [
                'label' => 'Total Aktivitas',
                'value' => $total_aktivitas ?? 0,
                'icon' => 'ti-target',
                'tone' => 'warning',
            ],
            [
                'label' => 'Kehadiran Hari Ini',
                'value' => $kehadiran_hari_ini ?? 0,
                'icon' => 'ti-clipboard-check',
                'tone' => 'cyan',
            ],
        ],
    ],

];
?>

<div class="dashboard-header">
    <h1 class="mb-1">Dashboard</h1>
    <p class="mb-0 text-secondary">RA PERWANIDA</p>
</div>

<div class="card border rounded-2 mb-4">
    <div class="card-header bg-white border-bottom">
        <h5 class="mb-0">
            <i class="ti ti-bell me-2"></i>
            Pengumuman Aktif
        </h5>
    </div>
    <div class="card-body">
        <?php if (!empty($pengumuman_aktif)) : ?>
            <?php foreach ($pengumuman_aktif as $p) : ?>
                <div class="alert alert-<?= $p['prioritas'] == 'tinggi' ? 'danger' : ($p['prioritas'] == 'normal' ? 'warning' : 'info') ?> alert-dismissible fade show" role="alert">
                    <strong><?= esc($p['judul']) ?></strong><br>
                    <small><?= esc(substr($p['konten'], 0, 100)) ?>...</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="mb-0 text-secondary">Belum ada pengumuman aktif.</p>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($missing_tables)) : ?>
    <div class="alert alert-warning border-warning-subtle" role="alert">
        <strong>Setup database belum lengkap.</strong>
        Tabel berikut belum ada: <?= esc(implode(', ', $missing_tables)) ?>.
        Jalankan file <code>sql_tambahan_fitur_admin.sql</code> pada database <code>db_tk</code>.
    </div>
<?php endif; ?>

<div class="dashboard-group-list mb-4">
    <?php foreach ($dashboardGroups as $group) : ?>
        <section class="dashboard-card-group">
            <h2 class="dashboard-group-title"><?= esc($group['title']) ?></h2>

            <div class="dashboard-stats-grid">
                <?php foreach ($group['cards'] as $card) : ?>
                    <div class="admin-stat-card stat-<?= esc($card['tone']) ?>">
                        <span class="stat-icon">
                            <i class="ti <?= esc($card['icon']) ?>"></i>
                        </span>

                        <div>
                            <div class="stat-label"><?= esc($card['label']) ?></div>
                            <div class="stat-value"><?= esc($card['value']) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>

<script>
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const kalenderHariIni = document.getElementById('kalenderHariIni');

    if (kalenderHariIni) {
        kalenderHariIni.value = `${yyyy}-${mm}-${dd}`;
    }
</script>

<?= $this->endSection() ?>
