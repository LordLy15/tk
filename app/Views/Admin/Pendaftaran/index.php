<?= $this->extend('Admin/Dashboard') ?> 

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold" style="color: #27ae60;">
                    <i class="fas fa-clipboard-list me-2"></i> Data Pendaftaran Siswa Baru
                </h5>
                <p class="text-muted small mb-0">Kelola data calon siswa baru dan verifikasi berkas pendaftaran.</p>
            </div>
            
            <span class="badge bg-danger rounded-pill px-3 py-2">
                Total: <?= count($pendaftaran) ?> Pendaftar
            </span>
        </div>
        
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table class="table table-hover align-middle border-top">
                    <thead class="table-light" style="color: #27ae60;">
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">Nama Calon Siswa</th>
                            <th class="py-3">Data Kelahiran</th>
                            <th class="py-3">Orang Tua / Wali</th>
                            <th class="py-3">Kontak & Alamat</th>
                            <th class="py-3 text-center">Bukti Upload</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php if(empty($pendaftaran)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-folder-open text-muted mb-3" style="font-size: 48px;"></i><br>
                                    <h6 class="text-muted">Belum ada data pendaftaran yang masuk.</h6>
                                </td>
                            </tr>
                            
                        <?php else : ?>
                            <?php $no = 1; foreach($pendaftaran as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <strong class="text-dark"><?= esc($row['nama_siswa']); ?></strong><br>
                                        <span class="badge bg-light text-dark border mt-1"><?= esc($row['jenis_kelamin']); ?></span>
                                    </td>
                                    <td>
                                        <?= esc($row['tempat_lahir']); ?>, <br>
                                        <small class="text-muted"><?= date('d M Y', strtotime($row['tanggal_lahir'])); ?></small>
                                    </td>
                                    <td>
                                        <span class="d-block small">Ayah: <strong><?= esc($row['nama_ayah']); ?></strong></span>
                                        <span class="d-block small">Ibu: <strong><?= esc($row['nama_ibu']); ?></strong></span>
                                    </td>
                                    <td>
                                        <span class="d-block small">
                                            <i class="fab fa-whatsapp text-success me-1"></i> <?= esc($row['no_hp']); ?>
                                        </span>
                                        <small class="text-muted text-wrap" style="max-width: 200px; display: inline-block;">
                                            <?= esc($row['alamat']); ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <?php if($row['akta_kelahiran']) : ?>
                                            <a href="<?= base_url('uploads/akta/' . $row['akta_kelahiran']); ?>" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                                Lihat Akta
                                            </a>
                                        <?php else : ?>
                                            <span class="badge bg-secondary rounded-pill px-3">Tidak Ada</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>