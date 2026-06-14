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
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.15) transparent;
    }
    .dev-console-log::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .dev-console-log::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 999px;
    }
    .dev-console-log::-webkit-scrollbar-track {
        background: transparent;
    }
    
    /* Table scrollbar */
    .table-responsive {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }
    .table-responsive::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: transparent;
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

    /* Monospace query text area */
    .query-textarea {
        background-color: #1e1e2e;
        color: #cdd6f4;
        border: 1px solid #313244;
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 14px;
        padding: 12px;
        border-radius: 8px;
    }
    .query-textarea:focus {
        background-color: #181825;
        color: #cdd6f4;
        border-color: #27ae60;
        box-shadow: 0 0 0 0.25rem rgba(39, 174, 96, 0.25);
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
                    <?= csrf_field() ?>
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

    <!-- Utilitas Cache, Log & Backup -->
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold text-dark mb-3">
                    <i class="ti ti-settings me-1 text-primary"></i> Utilitas Sistem Cepat
                </h5>
                <p class="card-text text-muted small">Gunakan opsi di bawah ini untuk membersihkan cache aplikasi, mengosongkan log aktivitas, atau melakukan ekspor database cadangan. Tindakan ini aman untuk pemeliharaan server.</p>
                
                <div class="row g-2 mt-4">
                    <div class="col-4">
                        <a href="<?= base_url('admin/developer/clear-cache') ?>" class="btn btn-outline-primary w-100 py-3 fw-semibold text-center d-flex flex-column align-items-center justify-content-center h-100">
                            <i class="ti ti-trash-x fs-3 mb-1"></i>
                            <span style="font-size: 13px;">Clear Cache</span>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="<?= base_url('admin/developer/clear-logs') ?>" class="btn btn-outline-secondary w-100 py-3 fw-semibold text-center d-flex flex-column align-items-center justify-content-center h-100" onclick="return confirm('Kosongkan semua log aktivitas sistem?')">
                            <i class="ti ti-history-toggle fs-3 mb-1"></i>
                            <span style="font-size: 13px;">Clear Logs</span>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="<?= base_url('admin/developer/backup-db') ?>" class="btn btn-outline-success w-100 py-3 fw-semibold text-center d-flex flex-column align-items-center justify-content-center h-100">
                            <i class="ti ti-download fs-3 mb-1"></i>
                            <span style="font-size: 13px;">Backup DB</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Server Status Cards -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card shadow-sm border-0 text-center py-3 h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <div><i class="ti ti-brand-php fs-1 text-primary"></i></div>
                <h6 class="text-muted mt-3 mb-1">Versi PHP & OS</h6>
                <div class="fs-4 fw-bold text-dark"><?= esc($php_version) ?></div>
                <small class="text-secondary text-truncate d-block" title="<?= esc($os) ?>"><?= esc($os) ?></small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card shadow-sm border-0 text-center py-3 h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <div><i class="ti ti-database fs-1 text-info"></i></div>
                <h6 class="text-muted mt-3 mb-1">Database Engine</h6>
                <div class="fs-4 fw-bold text-dark text-truncate" title="<?= esc($db_version) ?>"><?= esc($db_version) ?></div>
                <small class="text-secondary"><?= esc($db_platform) ?></small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card shadow-sm border-0 text-center py-3 h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <div><i class="ti ti-folders fs-1 text-success"></i></div>
                <h6 class="text-muted mt-3 mb-1">Cache & Debug Size</h6>
                <div class="fs-5 fw-bold text-dark"><?= esc($cache_size) ?> / <?= esc($debug_size) ?></div>
                <small class="text-secondary">Logs: <?= esc($logs_size) ?></small>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card shadow-sm border-0 text-center py-3 h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <div><i class="ti ti-server fs-1 text-warning"></i></div>
                <h6 class="text-muted mt-3 mb-1">Penyimpanan Disk</h6>
                <div class="fs-5 fw-bold text-dark"><?= esc($disk_free) ?> / <?= esc($disk_total) ?></div>
                <small class="text-secondary">Free / Total Space</small>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="card-title fw-bold text-dark mb-3">
            <i class="ti ti-adjustments-horizontal me-1 text-primary"></i> Konfigurasi Lingkungan & Batasan PHP/DB
        </h5>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                        <span class="text-muted">Environment Mode (CI_ENVIRONMENT)</span>
                        <span class="badge bg-<?= $environment === 'development' ? 'warning text-dark' : 'success' ?> fw-semibold"><?= esc($environment) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                        <span class="text-muted">Sistem Operasi Server</span>
                        <span class="fw-semibold text-dark"><?= esc($os) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                        <span class="text-muted">Host Database</span>
                        <span class="font-monospace fw-semibold text-dark"><?= esc($db_host) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                        <span class="text-muted">Nama Database Aktif</span>
                        <span class="font-monospace fw-semibold text-dark"><?= esc($db_name) ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                        <span class="text-muted">Batas Upload Berkas (upload_max_filesize)</span>
                        <span class="fw-semibold text-dark"><?= esc($upload_limit) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                        <span class="text-muted">Batas Data POST (post_max_size)</span>
                        <span class="fw-semibold text-dark"><?= esc($post_limit) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                        <span class="text-muted">Limit Memori PHP (memory_limit)</span>
                        <span class="fw-semibold text-dark"><?= esc($memory_limit) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                        <span class="text-muted">Status Sambungan Database</span>
                        <span class="badge bg-success fw-semibold">Terhubung (OK)</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Database Tables Status -->
    <div class="col-lg-6 mb-4 mb-lg-0">
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
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
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

<!-- SQL Query Console Card -->
<div class="card shadow-sm border-0 mb-4" id="query-console">
    <div class="card-body">
        <h5 class="card-title fw-bold text-dark mb-3">
            <i class="ti ti-terminal-2 me-1 text-success"></i> Konsol Query SQL Interaktif
        </h5>
        <p class="card-text text-muted small">Eksekusi query SQL langsung pada database (SELECT, INSERT, UPDATE, DELETE, SHOW, DESCRIBE). Gunakan dengan hati-hati!</p>
        
        <!-- Alerts for query execution status -->
        <?php if (session()->getFlashdata('query_success')) : ?>
            <div class="alert alert-success d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="ti ti-circle-check fs-4 text-success"></i>
                <div class="fw-semibold small text-success-emphasis"><?= session()->getFlashdata('query_success') ?></div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('query_error')) : ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="ti ti-alert-triangle fs-4 text-danger"></i>
                <div class="font-monospace small text-danger-emphasis"><?= session()->getFlashdata('query_error') ?></div>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/developer/run-query') ?>" method="post" class="mb-4">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="sql_query" class="form-label fw-semibold text-dark small">SQL Query Editor</label>
                <textarea class="form-control query-textarea" id="sql_query" name="sql_query" rows="5" placeholder="SELECT * FROM users LIMIT 10;"><?= esc(session()->getFlashdata('query_sql') ?? '') ?></textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small"><i class="ti ti-info-circle me-1"></i> Pisahkan beberapa pernyataan query dengan titik koma jika diperlukan.</span>
                <button type="submit" class="btn btn-success fw-semibold px-4 d-inline-flex align-items-center gap-1">
                    <i class="ti ti-bolt fs-5"></i> Jalankan Query
                </button>
            </div>
        </form>

        <!-- Query results -->
        <?php if (session()->getFlashdata('query_results') !== null) : ?>
            <div class="card border border-light-subtle shadow-sm mb-3">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2 px-3">
                    <span class="fw-bold text-dark small"><i class="ti ti-table me-1"></i> Hasil Query SELECT (<?= count(session()->getFlashdata('query_results')) ?> baris)</span>
                    <span class="badge bg-secondary"><?= count(session()->getFlashdata('query_fields')) ?> Kolom</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-sm table-striped table-hover table-bordered mb-0 align-middle font-monospace" style="font-size: 12px; min-width: 600px;">
                            <thead class="table-dark sticky-top">
                                <tr>
                                    <?php foreach (session()->getFlashdata('query_fields') as $field) : ?>
                                        <th class="py-2 px-3"><?= esc($field) ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty(session()->getFlashdata('query_results'))) : ?>
                                    <tr>
                                        <td colspan="<?= count(session()->getFlashdata('query_fields')) ?>" class="text-center text-muted py-3">Query mengembalikan hasil kosong (0 baris).</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach (session()->getFlashdata('query_results') as $row) : ?>
                                        <tr>
                                            <?php foreach (session()->getFlashdata('query_fields') as $field) : ?>
                                                <td class="py-1 px-3">
                                                    <?php 
                                                    if ($row[$field] === null) {
                                                        echo '<em class="text-danger small">NULL</em>';
                                                    } elseif (is_string($row[$field]) && strlen($row[$field]) > 100) {
                                                        echo esc(substr($row[$field], 0, 100)) . '...';
                                                    } else {
                                                        echo esc($row[$field]);
                                                    }
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
