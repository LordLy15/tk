<?= $this->extend('Admin/Dashboard') ?>

<?= $this->section('content') ?>

<div class="crud-page-header">
    <div>
        <h1>Tambah Guru</h1>
        <p>Masukkan data pengajar untuk wali kelas dan kegiatan belajar.</p>
    </div>

    <div class="crud-page-actions">
        <a href="<?= base_url('guru') ?>" class="btn btn-light">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<div class="crud-form-shell">
    <div class="card crud-form-card">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Data Guru</h2>
                <p class="card-subtitle">Gunakan NIP/NIK angka tanpa spasi atau tanda baca.</p>
            </div>
        </div>

        <div class="card-body">
            <form action="<?= base_url('guru/simpan') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-section">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="nama_guru" class="form-label">Nama Guru <span class="required-mark">*</span></label>
                            <input id="nama_guru"
                                   type="text"
                                   name="nama_guru"
                                   class="form-control"
                                   value="<?= esc(old('nama_guru')) ?>"
                                   required>
                        </div>

                        <div class="col-md-4">
                            <label for="nip_nik" class="form-label">NIP/NIK <span class="required-mark">*</span></label>
                            <input id="nip_nik"
                                   type="text"
                                   name="nip_nik"
                                   class="form-control"
                                   maxlength="18"
                                   inputmode="numeric"
                                   value="<?= esc(old('nip_nik')) ?>"
                                   data-digit-only
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="jabatan" class="form-label">Jabatan <span class="required-mark">*</span></label>
                            <input id="jabatan"
                                   type="text"
                                   name="jabatan"
                                   class="form-control"
                                   value="<?= esc(old('jabatan')) ?>"
                                   placeholder="Contoh: Wali Kelas"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="pendidikan" class="form-label">Kualifikasi Pendidikan <span class="required-mark">*</span></label>
                            <input id="pendidikan"
                                   type="text"
                                   name="pendidikan"
                                   class="form-control"
                                   value="<?= esc(old('pendidikan')) ?>"
                                   placeholder="Contoh: S1 PAUD"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="foto_guru" class="form-label">Foto Profil</label>
                            <input id="foto_guru"
                                   type="file"
                                   name="foto_guru"
                                   class="form-control"
                                   accept="image/jpeg,image/png,image/webp">
                            <div class="form-hint">Format JPG, PNG, atau WEBP. Maksimal 5 MB.</div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('guru') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i>
                        Simpan Guru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Crop Foto -->
<div class="modal fade" id="cropModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">Sesuaikan & Potong Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnCancelCropClose"></button>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <div class="img-container" style="max-height: 400px; min-height: 200px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                    <img id="imageToCrop" src="" style="max-width: 100%; max-height: 380px; display: block;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancelCrop">Batal</button>
                <button type="button" class="btn btn-primary" id="btnCropAndApply">
                    <i class="ti ti-crop"></i> Potong & Terapkan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Load Cropper.js CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<!-- Load Bootstrap JS to ensure bootstrap is defined globally -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const fotoInput = document.getElementById("foto_guru");
    const cropModalEl = document.getElementById("cropModal");
    const imageToCrop = document.getElementById("imageToCrop");
    const btnCropAndApply = document.getElementById("btnCropAndApply");
    const btnCancelCrop = document.getElementById("btnCancelCrop");
    const btnCancelCropClose = document.getElementById("btnCancelCropClose");
    
    let cropper = null;
    let originalFile = null;
    let cropModal = null;

    fotoInput.addEventListener("change", function (e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            originalFile = files[0];
            
            if (!originalFile.type.startsWith('image/')) {
                alert('File yang dipilih harus berupa gambar!');
                fotoInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                imageToCrop.src = event.target.result;
                
                try {
                    if (!cropModal) {
                        cropModal = new bootstrap.Modal(cropModalEl);
                    }
                    cropModal.show();
                } catch (error) {
                    console.error("Error initializing modal:", error);
                    alert("Gagal membuka modul crop gambar. Pastikan browser mendukung Bootstrap 5.");
                }
            };
            reader.readAsDataURL(originalFile);
        }
    });

    cropModalEl.addEventListener("shown.bs.modal", function () {
        try {
            cropper = new Cropper(imageToCrop, {
                aspectRatio: 3 / 4, // 3:4 portrait ratio for teacher card profile
                viewMode: 1,
                autoCropArea: 0.9,
                responsive: true,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        } catch (error) {
            console.error("Error initializing cropper:", error);
            alert("Gagal memuat alat pemotong gambar.");
        }
    });

    cropModalEl.addEventListener("hidden.bs.modal", function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        imageToCrop.src = "";
    });

    function cancelCrop() {
        fotoInput.value = "";
        originalFile = null;
    }
    btnCancelCrop.addEventListener("click", cancelCrop);
    btnCancelCropClose.addEventListener("click", cancelCrop);

    btnCropAndApply.addEventListener("click", function () {
        if (!cropper) return;

        try {
            const canvas = cropper.getCroppedCanvas({
                width: 480,
                height: 640,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            canvas.toBlob(function (blob) {
                if (blob) {
                    const croppedFile = new File([blob], originalFile.name, {
                        type: originalFile.type || "image/jpeg",
                        lastModified: Date.now()
                    });

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    fotoInput.files = dataTransfer.files;

                    // Update preview
                    const previewImg = document.querySelector(".profile-upload-preview img");
                    if (previewImg) {
                        previewImg.src = URL.createObjectURL(blob);
                    } else {
                        let previewWrapper = document.getElementById("new-photo-preview-wrapper");
                        if (!previewWrapper) {
                            previewWrapper = document.createElement("div");
                            previewWrapper.id = "new-photo-preview-wrapper";
                            previewWrapper.className = "col-md-7 mt-3";
                            fotoInput.closest(".col-md-6").after(previewWrapper);
                        }
                        previewWrapper.innerHTML = `
                            <label class="form-label">Pratinjau Foto Baru</label>
                            <div class="profile-upload-preview">
                                <img src="${URL.createObjectURL(blob)}" alt="Pratinjau Foto Baru" style="max-height: 200px; border-radius: 12px; object-fit: cover;">
                            </div>
                        `;
                    }

                    if (cropModal) {
                        cropModal.hide();
                    }
                }
            }, originalFile.type || "image/jpeg", 0.9);
        } catch (error) {
            console.error("Error applying crop:", error);
            alert("Terjadi kesalahan saat memotong gambar.");
        }
    });
});
</script>

<?= $this->endSection() ?>
