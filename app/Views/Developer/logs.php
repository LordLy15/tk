<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header mb-4">
    <div>
        <h1><i class="ti ti-history me-2 text-primary"></i>Log Aktivitas & Perubahan</h1>
        <p>Rekam jejak operasional, perubahan data, dan aktivitas otentikasi sistem.</p>
    </div>
    
    <div class="crud-page-actions">
        <a href="<?= base_url('admin/developer') ?>" class="btn btn-outline-secondary">
            <i class="ti ti-terminal"></i>
            Kembali ke Panel Developer
        </a>
    </div>
</div>

<!-- Search Form -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="<?= base_url('admin/developer/logs') ?>" method="get" class="row g-2 align-items-center">
            <div class="col-md-9 col-sm-8">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="ti ti-search text-muted"></i></span>
                    <input type="text" 
                           name="search" 
                           class="form-control border-start-0 bg-light" 
                           placeholder="Cari berdasarkan aksi, modul, atau username..." 
                           value="<?= esc($search) ?>">
                </div>
            </div>
            <div class="col-md-3 col-sm-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 fw-semibold">Cari Log</button>
                <?php if ($search) : ?>
                    <a href="<?= base_url('admin/developer/logs') ?>" class="btn btn-light" title="Reset pencarian"><i class="ti ti-rotate-clockwise"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Logs Table -->
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 170px;">Waktu</th>
                        <th style="width: 130px;">User</th>
                        <th>Aksi</th>
                        <th style="width: 150px;">Modul</th>
                        <th>Deskripsi</th>
                        <th style="width: 120px;" class="text-center">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="ti ti-ghost d-block fs-1 text-secondary mb-2"></i>
                                Tidak ditemukan rekaman log aktivitas.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($logs as $l) : ?>
                            <tr>
                                <td class="text-secondary small font-monospace">
                                    <?= esc($l['created_at']) ?>
                                </td>
                                <td>
                                    <span class="fw-semibold text-primary">
                                        @<?= esc($l['username'] ?: 'System') ?>
                                    </span>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <?= esc($l['aksi']) ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis px-2 py-1">
                                        <?= esc($l['modul']) ?>
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    <?= esc($l['deskripsi']) ?>
                                </td>
                                <td class="text-center text-secondary small font-monospace">
                                    <?= esc($l['ip_address'] ?: '-') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Area -->
        <?php if ($total_pages > 1) : ?>
            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3">
                <div class="small text-muted">
                    Menampilkan log aktivitas, total <strong><?= esc($total_logs) ?></strong> data.
                </div>
                <nav aria-label="Navigasi log aktivitas">
                    <ul class="pagination mb-0">
                        <!-- Previous Page -->
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-item" 
                               href="<?= base_url('admin/developer/logs?page=' . ($page - 1) . ($search ? '&search=' . urlencode($search) : '')) ?>">
                                <span class="page-link"><i class="ti ti-chevron-left"></i></span>
                            </a>
                        </li>
                        
                        <!-- Page Numbers -->
                        <?php 
                            $start = max(1, $page - 2);
                            $end = min($total_pages, $page + 2);
                            for ($i = $start; $i <= $end; $i++) : 
                        ?>
                            <li class="page-item <?= $page === $i ? 'active' : '' ?>">
                                <a class="page-link" 
                                   href="<?= base_url('admin/developer/logs?page=' . $i . ($search ? '&search=' . urlencode($search) : '')) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <!-- Next Page -->
                        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-item" 
                               href="<?= base_url('admin/developer/logs?page=' . ($page + 1) . ($search ? '&search=' . urlencode($search) : '')) ?>">
                                <span class="page-link"><i class="ti ti-chevron-right"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
