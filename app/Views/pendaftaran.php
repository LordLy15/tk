<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section class="py-5 mt-4 bg-light min-vh-100">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #27ae60;">PENDAFTARAN SISWA BARU</h2>
            <p class="text-muted">Silakan isi formulir di bawah ini dengan data yang benar dan lengkap.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    
                    <form action="<?= base_url('pendaftaran/simpan') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-4">
                            <h5 class="fw-bold border-bottom pb-2" style="color: #27ae60;">
                                <i class="fas fa-child me-2"></i>Data Calon Siswa
                            </h5>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control rounded-3" name="nama_siswa" placeholder="Masukkan nama lengkap anak" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tempat Lahir</label>
                                <input type="text" class="form-control rounded-3" name="tempat_lahir" placeholder="Kota/Kabupaten" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" class="form-control rounded-3" name="tanggal_lahir" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select class="form-select rounded-3" name="jenis_kelamin" required>
                                <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-4 mt-5">
                            <h5 class="fw-bold border-bottom pb-2" style="color: #27ae60;">
                                <i class="fas fa-user-friends me-2"></i>Data Orang Tua / Wali
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Ayah</label>
                                <input type="text" class="form-control rounded-3" name="nama_ayah" placeholder="Nama lengkap Ayah" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Ibu</label>
                                <input type="text" class="form-control rounded-3" name="nama_ibu" placeholder="Nama lengkap Ibu" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. WhatsApp / HP</label>
                            <input type="tel" class="form-control rounded-3" name="no_hp" placeholder="Contoh: +6281234567890 atau 081234567890" required>
                            <small class="text-muted">Format: +62xxx atau 08xxx. Nomor yang aktif dan bisa dihubungi.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea class="form-control rounded-3" name="alamat" rows="3" placeholder="Nama Jalan, RT/RW, Desa, Kecamatan" required></textarea>
                        </div>

                        <div class="mb-4 mt-5">
                            <h5 class="fw-bold border-bottom pb-2" style="color: #27ae60;">
                                <i class="fas fa-file-upload me-2"></i>Upload Dokumen (Opsional)
                            </h5>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Foto Akta Kelahiran</label>
                            <input type="file" class="form-control rounded-3" name="akta_kelahiran" accept="image/*,.pdf">
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Formulir Pendaftaran
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>