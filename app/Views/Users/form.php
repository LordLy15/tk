<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1><?= $user ? 'Edit Pengguna' : 'Tambah Pengguna Baru' ?></h1>
        <p><?= $user ? 'Perbarui data akun dan hak akses pengguna.' : 'Buat akun pengguna baru dengan hak akses spesifik.' ?></p>
    </div>
    
    <div class="crud-page-actions">
        <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="<?= $user ? base_url('admin/users/update/' . $user['id_users']) : base_url('admin/users/simpan') ?>" method="post">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" 
                                   id="nama_lengkap" 
                                   name="nama_lengkap" 
                                   class="form-control" 
                                   placeholder="Nama Lengkap Pengguna"
                                   required 
                                   value="<?= old('nama_lengkap', $user['nama_lengkap'] ?? '') ?>">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   class="form-control" 
                                   placeholder="Username untuk login"
                                   required 
                                   value="<?= old('username', $user['username'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control" 
                                   placeholder="Alamat Email aktif"
                                   required 
                                   value="<?= old('email', $user['email'] ?? '') ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">
                                Password <?= $user ? '' : '<span class="text-danger">*</span>' ?>
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="<?= $user ? 'Kosongkan jika tidak ingin mengubah password' : 'Masukkan password' ?>"
                                   <?= $user ? '' : 'required' ?>>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="id_role" class="form-label fw-semibold">Peran & Hak Akses <span class="text-danger">*</span></label>
                            <select id="id_role" name="id_role" class="form-select" required>
                                <option value="" disabled selected>Pilih Peran Pengguna</option>
                                <?php foreach ($roles as $r) : ?>
                                    <option value="<?= $r['id_role'] ?>" 
                                            <?= old('id_role', $user['id_role'] ?? '') == $r['id_role'] ? 'selected' : '' ?>>
                                        <?= esc($r['nama_role']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold">Status Akun <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="aktif" <?= old('status', $user['status'] ?? 'aktif') === 'aktif' ? 'selected' : '' ?>>Aktif (Bisa Login)</option>
                                <option value="nonaktif" <?= old('status', $user['status'] ?? 'aktif') === 'nonaktif' ? 'selected' : '' ?>>Nonaktif (Diblokir)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pilihan Guru Khusus Guru Peran -->
                    <div class="mb-4" id="guru_select_container" style="display: none;">
                        <div class="p-3 bg-light rounded-3 border border-light-subtle">
                            <label for="id_guru" class="form-label fw-bold text-success"><i class="ti ti-school me-1"></i>Hubungkan Akun dengan Data Guru</label>
                            <p class="small text-muted mb-2">Akun dengan peran Guru wajib dihubungkan dengan data profil Guru yang terdaftar agar pembatasan kelas berfungsi dengan benar.</p>
                            <select id="id_guru" name="id_guru" class="form-select">
                                <option value="" disabled selected>Pilih Profil Guru Terkait</option>
                                <?php foreach ($gurus as $g) : ?>
                                    <option value="<?= $g['id'] ?>" 
                                            <?= old('id_guru', $user['id_guru'] ?? '') == $g['id'] ? 'selected' : '' ?>>
                                        <?= esc($g['nama_guru']) ?> (<?= esc($g['jabatan']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('admin/users') ?>" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Pengguna
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('id_role');
        const guruContainer = document.getElementById('guru_select_container');
        const guruSelect = document.getElementById('id_guru');

        function toggleGuruSelect() {
            // Deteksi berdasarkan teks nama role, bukan hardcode ID
            const selectedText = roleSelect.options[roleSelect.selectedIndex]?.text?.trim().toLowerCase() ?? '';
            const isGuru = selectedText.includes('guru');

            if (isGuru) {
                guruContainer.style.display = 'block';
                guruSelect.setAttribute('required', 'required');
            } else {
                guruContainer.style.display = 'none';
                guruSelect.removeAttribute('required');
                guruSelect.value = '';
            }
        }

        roleSelect.addEventListener('change', toggleGuruSelect);
        toggleGuruSelect(); // jalankan saat load
    });
</script>

<?= $this->endSection() ?>
