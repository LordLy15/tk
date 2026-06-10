<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<style>
    /* Styling konsol log developer agar tampak profesional */
    .dev-console-log {
        background-color: #1e1e2e;
        border: 1px solid #313244;
        border-radius: 8px;
        padding: 16px;
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 13px;
        max-height: 250px;
        overflow-y: auto;
        color: #a6e3a1;
    }
    .dev-log-row {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding: 6px 0;
    }
    .dev-log-time {
        color: #cba6f7;
    }
    .dev-log-user {
        color: #89b4fa;
    }
</style>

<div class="crud-page-header mb-4">
    <div>
        <h1><i class="ti ti-terminal-2 me-2 text-primary"></i>Panel Maintenance Developer</h1>
        <p>Sistem kontrol operasional, pembersihan cache, reset database, dan mode offline aplikasi.</p>
    </div>

    <div class="crud-page-actions">
        <?php if ($maintenance_active) : ?>
            <span class="badge bg-danger px-3 py-2 fs-6 d-inline-flex align-items-center gap-1">
                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                Mode Maintenance Aktif
            </span>
        <?php else : ?>
            <span class="badge bg-success px-3 py-2 fs-6 d-inline-flex align-items-center gap-1">
                <i class="ti ti-circle-check fs-5"></i>
                Sistem Online (Normal)
            </span>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <!-- Kontrol Mode Maintenance -->
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold text-dark mb-3">
                    <i class="ti ti-power me-1 text-danger"></i> Kontrol Mode Maintenance
                </h5>
                <p class="card-text text-muted small">Jika diaktifkan, hanya peran dengan hak akses <strong>Administrator (Developer)</strong> yang dapat menggunakan aplikasi ini. Pengguna lain (Admin, Staff, Guru) akan otomatis dialihkan ke halaman pemberitahuan maintenance yang elegan.</p>
                
                <form action="<?= base_url('admin/developer/toggle-maintenance') ?>" method="post" class="mt-4">
                    <input type="hidden" name="active" value="<?= $maintenance_active ? '0' : '1' ?>">
                    <?php if ($maintenance_active) : ?>
                        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                            <i class="ti ti-play-filled me-1"></i> Matikan Mode Maintenance (Go Online)
                        </button>
                    <?php else : ?>
                        <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold">
                            <i class="ti ti-circle-pause-filled me-1"></i> Aktifkan Mode Maintenance (Go Offline)
                        </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Utilitas Cache & Log -->
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold text-dark mb-3">
                    <i class="ti ti-settings me-1 text-primary"></i> Utilitas Sistem Cepat
                </h5>
                <p class="card-text text-muted small">Gunakan opsi di bawah ini untuk membersihkan cache aplikasi atau membersihkan log aktivitas sistem. Tindakan ini aman dan membantu meringankan ruang penyimpanan server.</p>
                
                <div class="row g-2 mt-4">
                    <div class="col-6">
                        <a href="<?= base_url('admin/developer/clear-cache') ?>" class="btn btn-outline-primary w-100 py-3 fw-semibold">
                            <i class="ti ti-trash-x d-block fs-3 mb-1"></i>
                            Bersihkan Cache
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('admin/developer/clear-logs') ?>" class="btn btn-outline-secondary w-100 py-3 fw-semibold" onclick="return confirm('Kosongkan semua log aktivitas sistem?')">
                            <i class="ti ti-history-toggle d-block fs-3 mb-1"></i>
                            Kosongkan Log
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Server Status Cards -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 text-center py-3">
            <div class="card-body">
                <i class="ti ti-brand-php fs-1 text-primary"></i>
                <h6 class="text-muted mt-3 mb-1">Versi PHP Engine</h6>
                <div class="fs-2 fw-bold text-dark"><?= esc($php_version) ?></div>
                <small class="text-secondary">Zend Engine Active</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 text-center py-3">
            <div class="card-body">
                <i class="ti ti-database fs-1 text-info"></i>
                <h6 class="text-muted mt-3 mb-1">Database Engine</h6>
                <div class="fs-2 fw-bold text-dark"><?= esc($db_version) ?></div>
                <small class="text-secondary"><?= esc($db_platform) ?></small>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 text-center py-3">
            <div class="card-body">
                <i class="ti ti-folders fs-1 text-success"></i>
                <h6 class="text-muted mt-3 mb-1">Memori Cache / Debug</h6>
                <div class="fs-3 fw-bold text-dark mt-1 mb-1"><?= esc($cache_size) ?> / <?= esc($debug_size) ?></div>
                <small class="text-secondary">Writable Cache Storage</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Database Tables Status -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold text-dark mb-3">
                    <i class="ti ti-table-alias me-1 text-success"></i> Tabel Database (`db_tk`)
                </h5>
                <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Tabel</th>
                                <th class="text-end">Jumlah Baris Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tables as $table) : ?>
                                <tr>
                                    <td class="font-monospace text-dark fw-semibold">
                                        <i class="ti ti-table me-2 text-secondary"></i><?= esc($table['name']) ?>
                                    </td>
                                    <td class="text-end fw-bold text-secondary"><?= esc($table['rows']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Activity Logs -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold text-dark mb-3">
                    <i class="ti ti-activity me-1 text-primary"></i> Aktivitas Sistem Terkini
                </h5>
                
                <div class="dev-console-log mb-3">
                    <?php if (empty($activity_logs)) : ?>
                        <div class="text-muted text-center py-5">Belum ada rekaman log aktivitas sistem.</div>
                    <?php else : ?>
                        <?php foreach ($activity_logs as $l) : ?>
                            <div class="dev-log-row">
                                <span class="dev-log-time">[<?= esc($l['created_at']) ?>]</span> 
                                <span class="dev-log-user">@<?= esc($l['username'] ?: 'System') ?></span>: 
                                <span class="text-light"><?= esc($l['aksi']) ?></span> 
                                <span class="text-muted small">(<?= esc($l['modul']) ?>)</span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="alert alert-danger d-flex align-items-start gap-2 mb-0" role="alert">
                    <i class="ti ti-alert-triangle fs-4 text-danger mt-1"></i>
                    <div>
                        <h6 class="alert-heading fw-bold text-danger mb-1">Zona Bahaya Developer (Reset Database)</h6>
                        <p class="small text-danger-emphasis mb-2">Tombol di bawah ini akan menghapus seluruh data yang ada saat ini dan memuat ulang struktur serta data bawaan asli dari file <code>db_tk.sql</code>. Gunakan hanya saat pengujian atau pemulihan darurat!</p>
                        <a href="<?= base_url('admin/developer/reset-db') ?>" 
                           class="btn btn-danger btn-sm fw-semibold" 
                           onclick="return confirm('PERINGATAN KERAS! Anda akan menghapus semua data saat ini dan mereset database ke keadaan awal. Apakah Anda yakin?')">
                            <i class="ti ti-refresh me-1"></i> Reset Database Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
