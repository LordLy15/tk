<?= $this->extend('Admin/Dashboard') ?> 

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="ti ti-clipboard-list me-2 text-primary"></i> Data Pendaftaran Siswa Baru
                    </h5>
                    <p class="text-muted small">Kelola data calon siswa baru dan verifikasi berkas pendaftaran.</p>
                </div>
                <div>
                    <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">
                        Total: <?= isset($list_pendaftaran) ? count($list_pendaftaran) : 0 ?> Pendaftar
                    </span>
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle" style="font-size: 0.9rem;">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center rounded-start" width="5%">No</th>
                                <th width="20%">Nama Calon Siswa</th>
                                <th width="15%">Data Kelahiran</th>
                                <th width="20%">Orang Tua / Wali</th>
                                <th width="20%">Kontak & Alamat</th>
                                <th class="text-center rounded-end" width="15%">Bukti Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($list_pendaftaran)) : ?>
                                <?php $no = 1; foreach ($list_pendaftaran as $p) : ?>
                                    <tr class="border-bottom">
                                        <td class="text-center fw-bold text-secondary"><?= $no++ ?></td>
                                        
                                        <td>
                                            <span class="d-block fw-bold text-dark"><?= esc($p['nama_siswa']) ?></span>
                                            <?php if ($p['jenis_kelamin'] == 'Laki-laki'): ?>
                                                <span class="badge bg-primary-subtle text-primary mt-1 border border-primary-subtle"><i class="ti ti-gender-male me-1"></i>Laki-laki</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger mt-1 border border-danger-subtle"><i class="ti ti-gender-female me-1"></i>Perempuan</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <span class="d-block text-dark"><?= esc($p['tempat_lahir']) ?></span>
                                            <small class="text-muted">
                                                <i class="ti ti-calendar-event me-1"></i><?= date('d M Y', strtotime($p['tanggal_lahir'])) ?>
                                            </small>
                                        </td>

                                        <td>
                                            <small class="d-block text-muted">Ayah:</small>
                                            <span class="d-block fw-semibold text-dark mb-1"><?= esc($p['nama_ayah']) ?></span>
                                            <small class="d-block text-muted">Ibu:</small>
                                            <span class="d-block fw-semibold text-dark"><?= esc($p['nama_ibu']) ?></span>
                                        </td>

                                        <td>
                                            <span class="d-block fw-bold text-success mb-1">
                                                <i class="ti ti-brand-whatsapp me-1"></i> <?= esc($p['no_hp']) ?>
                                            </span>
                                            <span class="d-block text-muted small text-truncate" style="max-width: 180px;" title="<?= esc($p['alamat']) ?>">
                                                <?= esc($p['alamat']) ?>
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <?php if (!empty($p['akta_kelahiran'])): ?>
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalBerkas<?= $p['id_pendaftaran'] ?>">
                                                    <i class="ti ti-photo me-1"></i> Lihat Bukti
                                                </button>

                                                <div class="modal fade" id="modalBerkas<?= $p['id_pendaftaran'] ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content border-0 shadow">
                                                            <div class="modal-header border-bottom-0 pb-0">
                                                                <h5 class="modal-title fw-bold">Bukti Berkas: <?= esc($p['nama_siswa']) ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center p-4">
                                                                <img src="<?= base_url('assets/images/' . $p['akta_kelahiran']) ?>" 
                                                                     class="img-fluid rounded shadow-sm" 
                                                                     alt="Bukti Akta" 
                                                                     style="max-height: 70vh; object-fit: contain;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php else: ?>
                                                <span class="badge bg-light text-muted border border-secondary px-2">Belum Upload</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ti ti-inbox fs-1 d-block mb-3 text-secondary"></i>
                                            Belum ada data pendaftaran yang masuk.
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>