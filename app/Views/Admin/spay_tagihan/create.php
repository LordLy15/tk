<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>
<style>
.tipe-penerima-input:checked + .tipe-penerima-label {
    border-color: #28a745 !important;
    background-color: rgba(40, 167, 69, 0.08) !important;
    color: #28a745 !important;
}
.tipe-penerima-label {
    border: 2px solid #e2e8f0 !important;
    background-color: #fff !important;
    color: #495057 !important;
    border-radius: 12px !important;
    padding: 1.25rem 1rem !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
}
.tipe-penerima-label:hover {
    border-color: #cbd5e1 !important;
    background-color: #f8fafc !important;
}
.tipe-penerima-label i {
    font-size: 1.5rem;
}
</style>

<div class="mb-4">
    <a href="<?= base_url('admin/spay-tagihan') ?>" class="btn btn-light mb-3">
        <i class="ti ti-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="fw-bold mb-0">
            <i class="ti ti-plus me-2"></i>
            Tambah Tagihan Baru
        </h5>
    </div>
    <div class="card-body">
        <?= form_open(base_url('admin/spay-tagihan/simpan')) ?>
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tipe Penerima *</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="radio" class="btn-check tipe-penerima-input" name="tipe_penerima" id="tipe_personal" value="personal" autocomplete="off" checked>
                            <label class="tipe-penerima-label" for="tipe_personal">
                                <i class="ti ti-user mb-1"></i>
                                <span class="fw-bold">Per Orang Tua</span>
                                <small style="color: inherit; opacity: 0.75; font-size: 0.75rem;" class="text-center mt-1 d-none d-sm-block">
                                    Satu siswa penerima
                                </small>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" class="btn-check tipe-penerima-input" name="tipe_penerima" id="tipe_kelas" value="kelas" autocomplete="off">
                            <label class="tipe-penerima-label" for="tipe_kelas">
                                <i class="ti ti-users mb-1"></i>
                                <span class="fw-bold">Per Kelas (Massal)</span>
                                <small style="color: inherit; opacity: 0.75; font-size: 0.75rem;" class="text-center mt-1 d-none d-sm-block">
                                    Seluruh siswa di kelas
                                </small>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Tipe Personal Container -->
                <div class="mb-3" id="container_personal">
                    <label class="form-label fw-bold">Orang Tua *</label>
                    <?php $selectedOtId = service('request')->getGet('orang_tua_id'); ?>
                    <select name="orang_tua_id" id="orang_tua_id" class="form-select" required>
                        <option value="">-- Pilih Orang Tua --</option>
                        <?php foreach ($orang_tua_list as $ot) : ?>
                            <option value="<?= $ot['id'] ?>" <?= ($selectedOtId == $ot['id']) ? 'selected' : '' ?>>
                                <?= esc($ot['nama']) ?>
                                <?php if (!empty($ot['nama_siswa'])) : ?>
                                    (<?= esc($ot['nama_siswa']) ?><?= !empty($ot['kelas']) ? ' - ' . esc($ot['kelas']) : '' ?>)
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">Pilih akun orang tua yang akan ditagih</div>
                </div>

                <!-- Tipe Kelas Container -->
                <div class="mb-3" id="container_kelas" style="display: none;">
                    <label class="form-label fw-bold">Pilih Kelas *</label>
                    <select name="kelas_name" id="kelas_name" class="form-select">
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($kelas_list as $k) : ?>
                            <option value="<?= esc($k['kelas']) ?>"><?= esc($k['kelas']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">Pilih kelas yang akan dikirimi tagihan</div>

                    <!-- Checklist Siswa / Orang Tua -->
                    <div class="mt-3" id="container_daftar_murid" style="display: none;">
                        <label class="form-label fw-semibold text-dark mb-1">
                            Penerima Tagihan (Centang untuk menagih, hilangkan centang untuk membatalkan/cancel):
                        </label>
                        <div class="border rounded p-3 bg-light" style="max-height: 220px; overflow-y: auto;" id="daftar_murid_checklist">
                            <!-- Populated by AJAX -->
                        </div>
                        <div class="form-text text-danger mt-1" id="error_no_selection" style="display: none;">
                            * Pilih minimal satu orang tua siswa.
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Tagihan *</label>
                    <input type="text" name="judul" class="form-control"
                           placeholder="Contoh: SPP Bulan Juni 2026" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nominal *</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" name="nominal" class="form-control"
                               placeholder="250.000" required id="nominal-input">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Batas Pembayaran</label>
                    <input type="date" name="batas_bayar" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <div class="input-group">
                        <select name="kategori_select" id="kategori_select" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="SPP">SPP</option>
                            <option value="Seragam">Seragam</option>
                            <option value="Kegiatan">Kegiatan</option>
                            <option value="Buku">Buku</option>
                            <option value="Ujian">Ujian</option>
                            <option value="Lainnya">Lainnya</option>
                            <option value="__other__">+ Tambah Baru</option>
                        </select>
                    </div>
                    <input type="text" name="kategori_input" id="kategori_input" class="form-control mt-2"
                           placeholder="Ketik nama kategori baru..."
                           style="display: none;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="4"
                               placeholder="Contoh: SPP bulanan untuk bulan Juni 2026"></textarea>
                </div>
            </div>
        </div>

        <hr>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-device-floppy me-2"></i> Simpan
            </button>
            <a href="<?= base_url('admin/spay-tagihan') ?>" class="btn btn-light">Batal</a>
        </div>
        <?= form_close() ?>
    </div>
</div>

<script>
// Handle Tipe Penerima toggles
document.querySelectorAll('input[name="tipe_penerima"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        var personalContainer = document.getElementById('container_personal');
        var kelasContainer = document.getElementById('container_kelas');
        var selectPersonal = document.getElementById('orang_tua_id');
        var selectKelas = document.getElementById('kelas_name');
        
        if (this.value === 'kelas') {
            personalContainer.style.display = 'none';
            kelasContainer.style.display = 'block';
            selectPersonal.removeAttribute('required');
            selectKelas.setAttribute('required', 'required');
        } else {
            personalContainer.style.display = 'block';
            kelasContainer.style.display = 'none';
            selectPersonal.setAttribute('required', 'required');
            selectKelas.removeAttribute('required');
        }
    });
});

// Handle Kategori dropdown
document.getElementById('kategori_select').addEventListener('change', function() {
    var input = document.getElementById('kategori_input');
    if (this.value === '__other__') {
        input.style.display = 'block';
        input.focus();
    } else {
        input.style.display = 'none';
    }
});

// Format nominal input
document.getElementById('nominal-input').addEventListener('blur', function() {
    var value = this.value.replace(/[^\d]/g, '');
    if (value) {
        this.value = parseInt(value).toLocaleString('id-ID');
    }
});

// Handle Kelas selection & AJAX checklist loading
document.getElementById('kelas_name').addEventListener('change', function() {
    var kelas = this.value;
    var container = document.getElementById('container_daftar_murid');
    var checklist = document.getElementById('daftar_murid_checklist');
    
    if (!kelas) {
        container.style.display = 'none';
        checklist.innerHTML = '';
        return;
    }
    
    checklist.innerHTML = '<div class="text-muted"><i class="ti ti-reload animate-spin me-2 d-inline-block"></i>Memuat daftar murid...</div>';
    container.style.display = 'block';
    
    fetch('<?= base_url('admin/spay-tagihan/get-orang-tua-by-kelas') ?>?kelas=' + encodeURIComponent(kelas))
        .then(response => response.json())
        .then(data => {
            checklist.innerHTML = '';
            if (data.length === 0) {
                checklist.innerHTML = '<div class="text-danger p-2">Tidak ada data wali murid aktif di kelas ini.</div>';
                return;
            }
            
            // Render Select All Checkbox
            var selectAllDiv = document.createElement('div');
            selectAllDiv.className = 'form-check border-bottom pb-2 mb-2';
            selectAllDiv.innerHTML = `
                <input class="form-check-input" type="checkbox" id="check_all_students" checked>
                <label class="form-check-label fw-bold text-dark" for="check_all_students" style="cursor: pointer;">
                    Pilih Semua
                </label>
            `;
            checklist.appendChild(selectAllDiv);
            
            // Render individual parent/student checklist
            data.forEach(function(ot) {
                var div = document.createElement('div');
                div.className = 'form-check mb-2';
                div.innerHTML = `
                    <input class="form-check-input student-checkbox" type="checkbox" name="selected_orang_tua[]" value="${ot.id}" id="ot_${ot.id}" checked>
                    <label class="form-check-label text-dark" for="ot_${ot.id}" style="cursor: pointer;">
                        <strong>${ot.nama_siswa || 'Tanpa Nama Siswa'}</strong> - Wali: ${ot.nama}
                    </label>
                `;
                checklist.appendChild(div);
            });
            
            // Hook select all trigger
            document.getElementById('check_all_students').addEventListener('change', function() {
                var checked = this.checked;
                document.querySelectorAll('.student-checkbox').forEach(function(cb) {
                    cb.checked = checked;
                });
            });
        })
        .catch(error => {
            console.error('Error:', error);
            checklist.innerHTML = '<div class="text-danger p-2">Gagal memuat data wali murid.</div>';
        });
});

// Client-side Form Validation
document.querySelector('form').addEventListener('submit', function(e) {
    var tipe = document.querySelector('input[name="tipe_penerima"]:checked').value;
    if (tipe === 'kelas') {
        var checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
        if (checkedCount === 0) {
            e.preventDefault();
            document.getElementById('error_no_selection').style.display = 'block';
            document.getElementById('kelas_name').focus();
            return false;
        } else {
            document.getElementById('error_no_selection').style.display = 'none';
        }
    }
});
</script>
<?= $this->endSection() ?>