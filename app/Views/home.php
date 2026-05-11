<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section id="tentang" class="py-5 mt-3">
    <div class="container">
        <div class="row align-items-center gx-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <h2 class="fw-bold text-primary mb-4">TENTANG KAMI</h2>
                <p class="text-muted lh-lg" style="text-align: justify; font-size: 1.05rem;">
                    Selamat datang di TK Ceria. Kami adalah lembaga pendidikan anak usia dini yang berfokus pada pengembangan karakter dan kreativitas. Dengan lingkungan yang aman dan menyenangkan, kami membantu buah hati Anda tumbuh menjadi pribadi yang berakhlak mulia dan cerdas.
                </p>
            </div>
            <div class="col-md-6">
                <div class="bg-secondary text-white rounded-4 d-flex align-items-center justify-content-center shadow" style="height: 320px;">
                    <span class="fw-bold letter-spacing-1">GAMBAR SEKOLAH</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="visi-misi" class="py-5 bg-light">
    <div class="container">
        <div class="row flex-row-reverse align-items-center gx-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <h2 class="fw-bold text-primary mb-4">VISI MISI</h2>
                <div class="text-muted lh-lg" style="font-size: 1.05rem;">
                    <p><strong>Visi:</strong> "Terwujudnya Pribadi Unggul yang Cerdas, Sehat, Mandiri"
<p>Raudhatul Athfal mencerminkan komitmen untuk mengembangkan seluruh potensi anak secara optimal dan seimbang. "Pribadi Unggul" menggambarkan harapan bahwa setiap anak dapat berkembang menjadi individu yang menonjol dalam berbagai aspek kehidupan.
"Cerdas" merujuk pada pengembangan kemampuan berpikir, bernalar, dan memecahkan masalah sesuai tahap perkembangan anak.  "Sehat" mencakup kesehatan fisik dan mental yang prima sebagai fondasi perkembangan yang optimal. "Mandiri" menekankan kemampuan pada diri sendiri, berani mencoba hal baru dan bertanggungjawab. Visi ini menjadi panduan utama bagi seluruh civitas Raudhatul Athfal dalam merancang dan melaksanakan seluruh program pendidikan.</p> 
</p>
                    <p class="mb-2"><strong>Misi:</strong></p>
                    <ul class="ps-3">
                        <li class="mb-2">Menyelenggarakan pembelajaran berkesadaran yang mengembangkan kemampuan anak untuk memahami proses belajarnya melalui refleksi sederhana, pertanyaan terbuka, dan aktivitas yang mendorong kesadaran diri sesuai tahap perkembangan kognitif mereka.</li>
                        <li class="mb-2">Menciptakan pembelajaran bermakna dengan mengaitkan setiap pengalaman belajar dengan kehidupan nyata anak dan lingkungan terdekat, membangun kemitraan aktif dengan keluarga dan masyarakat untuk menciptakan kontinuitas pembelajaran yang autentik.</li>
                        <li class="mb-2">Memastikan pembelajaran menggembirakan melalui penciptaan suasana belajar yang positif, aman, dan menyenangkan, dimana kegembiraan menjadi kondisi emosional yang mendukung optimal learning dan perkembangan holistik anak.</li>
                        <li class="mb-2">Mengembangkan delapan dimensi profil lulusan secara terintegrasi melalui berbagai pengalaman belajar yang memungkinkan anak mengalami dan mengaplikasikan berbagai kompetensi secara bersamaan dalam konteks yang bermakna.</li>
                        <li class="mb-2">5.	Membangun ekosistem pembelajaran yang mendukung implementasi Pembelajaran Mendalam melalui pengembangan kapasitas guru, optimalisasi lingkungan pembelajaran, penguatan kemitraan dengan stakeholder, dan pemanfaatan teknologi yang tepat untuk anak usia dini.</li>
                        <li class="mb-2">6.	Melestarikan nilai-nilai budaya lokal dalam pembelajaran sebagai upaya membangun identitas dan kebanggaan terhadap warisan Nusantara sambil mengembangkan kesadaran global dan apresiasi terhadap keberagaman.</li>
                    </ul>
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
        <h2 class="fw-bold text-primary mb-5">PIMPINAN SEKOLAH</h2>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <div class="bg-secondary text-white rounded-3 mx-auto mb-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 140px; height: 170px;">
                        <span class="fw-bold">FOTO</span>
                    </div>
                    <h4 class="fw-bold mb-1">Nama Kepala Sekolah</h4>
                    <p class="text-primary fw-semibold mb-3">Kepala Sekolah TK</p>
                    <p class="fst-italic text-muted px-3 mb-0" style="font-size: 0.95rem;">"Berkomitmen mendampingi setiap langkah tumbuh kembang anak dengan penuh kasih sayang dan kesabaran."</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="guru" class="py-5 my-5 bg-light rounded-4">
    <div class="container py-4 text-center">
        <h2 class="fw-bold text-primary mb-5">GURU - GURU SEKOLAH</h2>
        <div class="row justify-content-center g-4">
            <?php if(!empty($total_guru)): ?>
                <?php foreach($total_guru as $g): ?>
                <div class="col-6 col-md-3">
                    <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                        <div class="bg-secondary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 90px; height: 90px;">
                            <span class="fs-2">👩‍🏫</span>
                        </div>
                        <h6 class="fw-bold mb-1"><?= $g['nama_guru'] ?></h6>
                        <small class="text-primary fw-semibold">Tenaga Pengajar</small>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-muted fst-italic">Data guru belum tersedia. Silakan tambahkan di dashboard admin.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="faq" class="py-5 mb-5">
    <div class="container">
        <h2 class="fw-bold text-primary text-center mb-5">PERTANYAAN UMUM</h2>
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