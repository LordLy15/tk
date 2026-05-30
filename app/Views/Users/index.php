<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Manajemen Pengguna</h1>
        <p>Kelola akun pengguna, penugasan peran (role), dan integrasi wali kelas.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('admin/users/tambah') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Pengguna
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Peran (Role)</th>
                        <th>Guru Terkait</th>
                        <th style="width: 120px;" class="text-center">Status</th>
                        <th style="width: 120px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)) : ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data pengguna terdaftar.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $u) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-bold text-dark"><?= esc($u['nama_lengkap']) ?></td>
                                <td><code class="text-secondary"><?= esc($u['username']) ?></code></td>
                                <td><?= esc($u['email']) ?></td>
                                <td>
                                    <?php 
                                        $role = strtolower((string)$u['nama_role']);
                                        $badgeClass = match($role) {
                                            'administrator' => 'bg-dark',
                                            'admin'         => 'bg-info',
                                            'staff'         => 'bg-warning text-dark',
                                            'guru'          => 'bg-success',
                                            default         => 'bg-secondary'
                                        };
                                    ?>
                                    <span class="badge <?= $badgeClass ?> px-2.5 py-1.5 fs-7">
                                        <?= esc($u['nama_role'] ?: 'Belum Diatur') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($role === 'guru') : ?>
                                        <span class="text-dark fw-semibold">
                                            <i class="ti ti-user me-1 text-success"></i><?= esc($u['nama_guru'] ?: 'Belum Terhubung') ?>
                                        </span>
                                    <?php else : ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (($u['status'] ?? 'aktif') === 'aktif') : ?>
                                        <span class="badge bg-success-subtle text-success px-3 py-1.5 border border-success-subtle">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger-subtle text-danger px-3 py-1.5 border border-danger-subtle">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?= base_url('admin/users/edit/' . $u['id_users']) ?>" 
                                           class="btn btn-warning btn-sm btn-icon-btn d-inline-flex align-items-center justify-content-center"
                                           title="Edit Pengguna"
                                           style="width: 32px; height: 32px;">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        
                                        <?php if ((int)session('id_users') !== (int)$u['id_users']) : ?>
                                            <a href="<?= base_url('admin/users/hapus/' . $u['id_users']) ?>" 
                                               class="btn btn-danger btn-sm btn-icon-btn d-inline-flex align-items-center justify-content-center"
                                               title="Hapus Pengguna"
                                               style="width: 32px; height: 32px;"
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        <?php else : ?>
                                            <button class="btn btn-secondary btn-sm btn-icon-btn d-inline-flex align-items-center justify-content-center"
                                                    disabled
                                                    style="width: 32px; height: 32px;"
                                                    title="Tidak bisa menghapus akun sendiri">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
