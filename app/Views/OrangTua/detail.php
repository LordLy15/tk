<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Profil Orang Tua</h1>
        <p>Detail wali murid dan informasi kontak keluarga.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('orang-tua/edit/' . $orang_tua['id']) ?>" class="btn btn-warning">
            <i class="ti ti-edit"></i>
            Edit
        </a>
        <a href="<?= base_url('orang-tua') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <div class="avatar avatar-lg rounded-circle bg-light d-inline-flex align-items-center justify-content-center">
                    <i class="ti ti-users fs-1"></i>
                </div>

                <h2 class="fs-4 mt-3 mb-1"><?= esc($orang_tua['nama_ayah']) ?></h2>
                <span class="badge badge-soft">Wali Murid</span>
            </div>

            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <th width="220">Nama Murid</th>
                            <td><?= esc($orang_tua['nama_murid']) ?></td>
                        </tr>
                        
                        <tr>
                            <th>Nama Ayah</th>
                            <td><?= esc($orang_tua['nama_ayah']) ?></td>
                        </tr>
                        <tr>
                            <th>No. HP Ayah</th>
                            <td><?= esc($orang_tua['no_hp_ayah']) ?></td>
                        </tr>
                        <tr>
                            <th>Pekerjaan Ayah</th>
                            <td><?= esc($orang_tua['pekerjaan_ayah'] ?: '-') ?></td>
                        </tr>
                        <tr>
                            <th>Nama Ibu</th>
                            <td><?= esc($orang_tua['nama_ibu']) ?></td>
                        </tr>
                        <tr>
                            <th>No. HP Ibu</th>
                            <td><?= esc($orang_tua['no_hp_ibu']) ?></td>
                        </tr>
                        <tr>
                            <th>Pekerjaan Ibu</th>
                            <td><?= esc($orang_tua['pekerjaan_ibu'] ?: '-') ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= esc($orang_tua['email'] ?: '-') ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= nl2br(esc($orang_tua['alamat'])) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
