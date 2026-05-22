<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Profil Guru</h1>
        <p>Detail pengajar dan kualifikasi pendidikan.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('guru/edit/' . $guru['id']) ?>" class="btn btn-warning">
            <i class="ti ti-edit"></i>
            Edit
        </a>
        <a href="<?= base_url('guru') ?>" class="btn btn-light">
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
                     alt="Avatar guru">

                <h2 class="fs-4 mt-3 mb-1"><?= esc($guru['nama_guru']) ?></h2>
                <span class="badge badge-soft"><?= esc($guru['jabatan']) ?></span>
            </div>

            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th width="220">Nama Guru</th>
                            <td><?= esc($guru['nama_guru']) ?></td>
                        </tr>
                        <tr>
                            <th>NIP/NIK</th>
                            <td><?= esc($guru['nip_nik']) ?></td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <td><?= esc($guru['jabatan']) ?></td>
                        </tr>
                        <tr>
                            <th>Kualifikasi Pendidikan</th>
                            <td><?= esc($guru['pendidikan']) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
