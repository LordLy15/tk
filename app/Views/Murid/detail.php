<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Profil Murid</h1>
        <p>Ringkasan identitas dan alamat murid.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('murid/edit/' . $murid['id']) ?>" class="btn btn-warning">
            <i class="ti ti-edit"></i>
            Edit
        </a>
        <a href="<?= base_url('murid') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <img src="<?= base_url('assets/dashboard/images/avatar-1.jpg') ?>"
                     width="150"
                     height="150"
                     class="rounded-circle border p-2"
                     alt="Avatar murid">

                <h2 class="fs-4 mt-3 mb-1"><?= esc($murid['nama_murid']) ?></h2>
                <span class="badge badge-soft"><?= esc($murid['nisn']) ?></span>
            </div>

            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th width="210">NISN</th>
                            <td><?= esc($murid['nisn']) ?></td>
                        </tr>
                        <tr>
                            <th>Nama Murid</th>
                            <td><?= esc($murid['nama_murid']) ?></td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td><?= esc($murid['nama_kelas'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td><?= ($murid['jenis_kelamin'] ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                        </tr>
                        <tr>
                            <th>Tempat & Tanggal Lahir</th>
                            <td>
                                <?= esc($murid['tempat_lahir'] ?? '-') ?>,
                                <?= ! empty($murid['tanggal_lahir']) ? date('d-m-Y', strtotime($murid['tanggal_lahir'])) : '-' ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= nl2br(esc($murid['alamat'] ?? '-')) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
