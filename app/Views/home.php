<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section id="tentang" class="py-5 mt-3">
    <div class="container">
        <div class="row align-items-center gx-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <h2 class="fw-bold mb-4" style="color: #27ae60;">TENTANG KAMI</h2>
                <p class="text-muted lh-lg" style="text-align: justify; font-size: 1.05rem;">
                    Selamat datang di RA PERWANIDA. Kami adalah lembaga pendidikan anak usia dini yang berfokus pada pengembangan karakter dan kreativitas. Dengan lingkungan yang aman dan menyenangkan, kami membantu buah hati Anda tumbuh menjadi pribadi yang berakhlak mulia dan cerdas.
                </p>
            </div>
           <div class="col-md-6">
                <img src="<?= base_url('assets/images/gambar-sekolah.jpeg') ?>" 
                    alt="Gedung RA Perwanida" 
                    class="img-fluid rounded-4 shadow w-100" 
                    style="height: 320px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<section id="visi-misi" class="py-5 bg-light">
    <div class="container">
        <div class="row flex-row-reverse align-items-center gx-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <h2 class="fw-bold mb-4" style="color: #27ae60;">VISI MISI</h2>
                <div class="text-muted lh-lg" style="font-size: 1.05rem;">
                    <p><strong>Visi:</strong> "Terwujudnya Pribadi Unggul yang Cerdas, Sehat, Mandiri"</p>
                    <p style="text-align: justify;">Raudhatul Athfal mencerminkan komitmen untuk mengembangkan seluruh potensi anak secara optimal dan seimbang. "Pribadi Unggul" menggambarkan harapan bahwa setiap anak dapat berkembang menjadi individu yang menonjol dalam berbagai aspek kehidupan...</p> 
                    
                    <p class="mb-2"><strong>Misi:</strong></p>
                    <ul class="ps-3">
                        <li class="mb-2">Menyelenggarakan pembelajaran berkesadaran yang mengembangkan kemampuan anak untuk memahami proses belajarnya melalui refleksi sederhana.</li>
                        <li class="mb-2">Menciptakan pembelajaran bermakna dengan mengaitkan setiap pengalaman belajar dengan kehidupan nyata anak dan lingkungan terdekat.</li>
                        
                        <div id="moreMisi" style="display: none;">
                            <li class="mb-2">Memastikan pembelajaran menggembirakan melalui penciptaan suasana belajar yang positif, aman, dan menyenangkan.</li>
                            <li class="mb-2">Mengembangkan delapan dimensi profil lulusan secara terintegrasi melalui berbagai pengalaman belajar yang bermakna.</li>
                            <li class="mb-2">Membangun ekosistem pembelajaran yang mendukung implementasi Pembelajaran Mendalam melalui pengembangan kapasitas guru.</li>
                            <li class="mb-2">Melestarikan nilai-nilai budaya lokal dalam pembelajaran sebagai upaya membangun identitas dan kebanggaan terhadap warisan Nusantara.</li>
                        </div>
                    </ul>
                    <a href="javascript:void(0)" onclick="toggleMisi()" id="btnReadMore" class="fw-bold text-success text-decoration-none" style="font-size: 0.9rem;">Lihat Selengkapnya...</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-white border rounded-4 d-flex align-items-center justify-content-center shadow-sm" style="height: 320px;">
                    <span class="fw-bold text-secondary">GAMBAR VISI MISI</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="pimpinan" class="py-5 mt-4 text-center">
    <div class="container">
        <h2 class="fw-bold mb-5" style="color: #27ae60;">PIMPINAN SEKOLAH</h2>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <div class="bg-secondary text-white rounded-3 mx-auto mb-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 140px; height: 170px;">
                        <span class="fw-bold">FOTO</span>
                    </div>
                    <h4 class="fw-bold mb-1">Nama Kepala Sekolah</h4>
                    <p class="fw-semibold mb-3" style="color: #27ae60;">Kepala Sekolah RA</p>
                    <p class="fst-italic text-muted px-3 mb-0" style="font-size: 0.95rem;">"Berkomitmen mendampingi setiap langkah tumbuh kembang anak dengan penuh kasih sayang dan kesabaran."</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="guru" class="py-5 my-5 bg-light rounded-4">
    <div class="container py-4 text-center">
        <h2 class="fw-bold mb-5" style="color: #27ae60;">GURU - GURU SEKOLAH</h2>
        <div class="row justify-content-center g-4">
            <?php if(!empty($total_guru)): ?>
                <?php foreach($total_guru as $g): ?>
                <?php $fotoGuru = ! empty($g['foto_guru']) ? base_url('uploads/foto_guru/' . rawurlencode($g['foto_guru'])) : base_url('assets/dashboard/images/avatar-1.jpg'); ?>
                <div class="col-6 col-md-3">
                    <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                        <img src="<?= $fotoGuru ?>"
                             alt="Foto <?= esc($g['nama_guru'] ?? 'guru') ?>"
                             class="rounded-circle mx-auto mb-3 shadow-sm"
                             loading="lazy"
                             style="width: 96px; height: 96px; object-fit: cover; border: 3px solid #eaf8ef;">
                        <h6 class="fw-bold mb-1"><?= esc($g['nama_guru'] ?? '-') ?></h6>
                        <small class="fw-semibold" style="color: #27ae60;"><?= esc($g['jabatan'] ?? 'Tenaga Pengajar') ?></small>
                        <?php if (! empty($g['pendidikan'])) : ?>
                            <small class="d-block text-muted mt-1"><?= esc($g['pendidikan']) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-muted fst-italic">Data guru belum tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="faq" class="py-5 mb-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-5" style="color: #27ae60;">PERTANYAAN UMUM</h2>
        <div class="row g-4">
            <?php for($i=1; $i<=6; $i++): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-2">Pertanyaan <?= $i ?>?</h6>
                        <p class="small text-muted mb-0">Ini adalah contoh jawaban singkat untuk membantu orang tua memahami informasi seputar prosedur atau kegiatan sekolah.</p>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
