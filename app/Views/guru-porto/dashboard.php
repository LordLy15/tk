<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="row">
    <!-- Form Tambah Siswa -->
    <div class="col-md-4">
        <div class="card p-3 mb-4">
            <h5>Tambah Siswa</h5>
            <form action="/dashboard/saveSiswa" method="post">
                <input type="text" name="nama_siswa" class="form-control mb-2" placeholder="Nama Siswa" required>
                <input type="text" name="nisn" class="form-control mb-2" placeholder="NISN" required>
                <input type="text" name="kelas" class="form-control mb-2" placeholder="Kelas" required>
                <button type="submit" class="btn btn-primary w-100">Simpan Siswa</button>
            </form>
        </div>
        
        <div class="card p-3">
            <h5>Tambah Guru</h5>
            <form action="/dashboard/saveGuru" method="post">
                <input type="text" name="nama_guru" class="form-control mb-2" placeholder="Nama Lengkap" required>
                <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                <button type="submit" class="btn btn-success w-100">Registrasi Guru</button>
            </form>
        </div>
    </div>

    <!-- Tabel Data Siswa -->
    <div class="col-md-8">
        <h3>Data Siswa TK</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th>Kelas</th>
                    <th class="text-center" style="width: 1%; white-space: nowrap;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($siswa as $s) : ?>
                <tr>
                    <td><?= $s['nama_siswa'] ?></td>
                    <td><?= $s['nisn'] ?></td>
                    <td><?= $s['kelas'] ?></td>
                    <td class="text-center" style="width: 1%; white-space: nowrap;">
                        <div class="d-inline-flex align-items-center justify-content-center gap-1 p-1 bg-light border rounded">
                            <a href="/dashboard/deleteSiswa/<?= $s['id'] ?>"
                               class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center"
                               style="width: 36px; height: 36px; padding: 0;"
                               title="Hapus siswa"
                               aria-label="Hapus <?= esc($s['nama_siswa'], 'attr') ?>"
                               onclick="return confirm('Hapus data siswa ini?')">
                                <i class="fa-solid fa-trash"></i>
                                <span class="visually-hidden">Hapus</span>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
