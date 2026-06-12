<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<style>
    /* Global styles for Company Profile */
    .section-title-wrapper {
        position: relative;
        margin-bottom: 3.5rem;
    }
    .section-tagline {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #27ae60;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 0.5rem;
    }
    .section-main-title {
        color: #2c3e50;
        font-weight: 800;
        font-size: 2.2rem;
        position: relative;
        display: inline-block;
        padding-bottom: 0.75rem;
    }
    .section-title-line {
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #27ae60, #2ecc71);
        border-radius: 2px;
        margin: 0 auto;
    }

    /* About Section */
    .about-img-container {
        position: relative;
    }
    .about-img-container::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border: 4px solid rgba(39, 174, 96, 0.2);
        top: 15px;
        left: 15px;
        border-radius: 1.5rem;
        z-index: -1;
    }

    /* Visi Misi Section */
    .visi-misi-card {
        border-left: 5px solid #27ae60 !important;
        background-color: #ffffff;
        transition: all 0.3s ease;
    }
    .visi-misi-card:hover {
        transform: translateX(5px);
        box-shadow: 0 10px 25px rgba(39, 174, 96, 0.08) !important;
    }

    /* Pimpinan Section Redesign (Jerome Bell Style - Match Teachers) */
    .pimpinan-card {
        background: #16432b;
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 28px;
        overflow: hidden;
        min-height: 480px;
        height: auto;
        display: flex;
        flex-direction: column;
        position: relative;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        text-align: left;
    }
    .pimpinan-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(39, 174, 96, 0.2) !important;
        border-color: rgba(39, 174, 96, 0.3);
    }
    .pimpinan-img-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 270px;
        overflow: hidden;
    }
    .pimpinan-img-card {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .pimpinan-card:hover .pimpinan-img-card {
        transform: scale(1.05);
    }
    .pimpinan-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(22, 67, 43, 0) 40%, #16432b 70%);
        z-index: 2;
        pointer-events: none;
    }
    .pimpinan-card-content {
        position: relative;
        margin-top: auto;
        padding: 20px 24px 24px 24px;
        z-index: 3;
        background: transparent;
        display: flex;
        flex-direction: column;
    }
    .pimpinan-card-name {
        color: #ffffff;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 4px;
        text-align: left;
        letter-spacing: 0.1px;
    }
    .pimpinan-card-role {
        color: #2ecc71;
        font-size: 0.82rem;
        font-weight: 600;
        text-align: left;
        margin-bottom: 12px;
    }
    .pimpinan-card-quote {
        color: rgba(255, 255, 255, 0.75);
        font-style: italic;
        font-size: 0.88rem;
        line-height: 1.5;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 12px;
        margin-bottom: 0;
    }

    /* Guru Section Redesign (Jerome Bell Style - Premium Dark Green Overlay) */
    .teacher-card {
        background: #16432b;
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 28px;
        overflow: hidden;
        height: 380px;
        display: flex;
        flex-direction: column;
        position: relative;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    .teacher-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(39, 174, 96, 0.2) !important;
        border-color: rgba(39, 174, 96, 0.3);
    }
    .teacher-card-img-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 270px;
        overflow: hidden;
    }
    .teacher-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .teacher-card:hover .teacher-card-img {
        transform: scale(1.05);
    }
    .teacher-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(22, 67, 43, 0) 40%, #16432b 70%);
        z-index: 2;
        pointer-events: none;
    }
    .teacher-card-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #1e5237 0%, #16432b 100%);
    }
    .teacher-card-placeholder-svg {
        width: 100%;
        height: 100%;
    }
    .teacher-card-content {
        position: relative;
        margin-top: auto;
        padding: 20px 24px 24px 24px;
        z-index: 3;
        background: transparent;
        display: flex;
        flex-direction: column;
    }
    .teacher-card-name {
        color: #ffffff;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 4px;
        text-align: left;
        letter-spacing: 0.1px;
        text-transform: capitalize;
    }
    .teacher-card-role {
        color: #2ecc71;
        font-size: 0.82rem;
        font-weight: 600;
        text-transform: none;
        letter-spacing: 0.2px;
        text-align: left;
        margin-bottom: 16px;
        line-height: 1.4;
    }
    .teacher-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 15px;
    }
    .teacher-card-edu {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        font-weight: 500;
    }
    .teacher-card-edu i {
        color: #f1c40f;
        margin-right: 6px;
        font-size: 0.85rem;
    }
    .teacher-card-badge {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    .teacher-card:hover .teacher-card-badge {
        background-color: #2ecc71;
        color: #16432b;
        border-color: #2ecc71;
    }

    /* FAQ Section */
    .faq-card {
        border: 1px solid rgba(0, 0, 0, 0.05);
        background: #ffffff;
        transition: all 0.3s ease;
        border-radius: 20px;
    }
    .faq-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.05) !important;
        border-color: rgba(39, 174, 96, 0.15);
    }
    .faq-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: rgba(39, 174, 96, 0.1);
        color: #27ae60;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        margin-bottom: 15px;
    }
</style>

<section id="tentang" class="py-5 mt-3">
    <div class="container py-4">
        <div class="row align-items-center gx-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <span class="section-tagline">Profil Singkat</span>
                <h2 class="fw-bold mb-4" style="color: #27ae60;">TENTANG KAMI</h2>
                <p class="text-muted lh-lg" style="text-align: justify; font-size: 1.05rem;">
                    Selamat datang di RA PERWANIDA. Kami adalah lembaga pendidikan anak usia dini yang berfokus pada pengembangan karakter dan kreativitas. Dengan lingkungan yang aman dan menyenangkan, kami membantu buah hati Anda tumbuh menjadi pribadi yang berakhlak mulia dan cerdas.
                </p>
            </div>
            <div class="col-md-6">
                <div class="about-img-container">
                    <img src="<?= base_url('assets/images/gambar-sekolah.jpeg') ?>" 
                        alt="Gedung RA Perwanida" 
                        class="img-fluid rounded-4 shadow w-100" 
                        style="height: 340px; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="visi-misi" class="py-5 bg-light rounded-4 my-4">
    <div class="container py-4">
        <div class="row flex-row-reverse align-items-center gx-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <span class="section-tagline">Arah & Landasan</span>
                <h2 class="fw-bold mb-4" style="color: #27ae60;">VISI MISI</h2>
                <div class="text-muted lh-lg" style="font-size: 1.05rem;">
                    <div class="card border-0 shadow-sm p-3 mb-3 visi-misi-card">
                        <p class="mb-0"><strong>Visi:</strong> "Terwujudnya Pribadi Unggul yang Cerdas, Sehat, Mandiri"</p>
                    </div>
                    <p style="text-align: justify;" class="mb-3">
                        Raudhatul Athfal mencerminkan komitmen untuk mengembangkan seluruh potensi anak secara optimal dan seimbang. "Pribadi Unggul" menggambarkan harapan bahwa setiap anak dapat berkembang menjadi individu yang menonjol dalam berbagai aspek kehidupan.
                    </p> 
                    
                    <p class="mb-2"><strong>Misi:</strong></p>
                    <ul class="ps-3 mb-3">
                        <li class="mb-2">Menyelenggarakan pembelajaran berkesadaran yang mengembangkan kemampuan anak untuk memahami proses belajarnya melalui refleksi sederhana.</li>
                        <li class="mb-2">Menciptakan pembelajaran bermakna dengan mengaitkan setiap pengalaman belajar dengan kehidupan nyata anak dan lingkungan terdekat.</li>
                        
                        <div id="moreMisi">
                            <li class="mb-2">Memastikan pembelajaran menggembirakan melalui penciptaan suasana belajar yang positif, aman, dan menyenangkan.</li>
                            <li class="mb-2">Mengembangkan delapan dimensi profil lulusan secara terintegrasi melalui berbagai pengalaman belajar yang bermakna.</li>
                            <li class="mb-2">Membangun ekosistem pembelajaran yang mendukung implementasi Pembelajaran Mendalam melalui pengembangan kapasitas guru.</li>
                            <li class="mb-2">Melestarikan nilai-nilai budaya lokal dalam pembelajaran sebagai upaya membangun identitas dan kebanggaan terhadap warisan Nusantara.</li>
                        </div>
                    </ul>
                    <a href="javascript:void(0)" onclick="toggleMisi()" id="btnReadMore" class="btn-read-more">Lihat Selengkapnya...</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-white border rounded-4 shadow-sm overflow-hidden" style="height: 340px;">
                    <img src="<?= base_url('assets/images/foto-guru.jpeg') ?>" class="w-100 h-100" style="object-fit: cover;" alt="Ilustrasi Visi Misi: Anak-anak aktif dan cerdas">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="pimpinan" class="py-5 text-center">
    <div class="container py-4">
        <div class="section-title-wrapper">
            <span class="section-tagline">Sambutan Hangat</span>
            <h2 class="section-main-title">PIMPINAN SEKOLAH</h2>
            <div class="section-title-line"></div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="pimpinan-card">
                    <div class="pimpinan-img-container">
                        <img src="<?= base_url('assets/images/foto-kepala.JPG') ?>" 
                             alt="Foto Kepala Sekolah" 
                             class="pimpinan-img-card"
                             loading="lazy">
                    </div>
                    <div class="pimpinan-card-overlay"></div>
                    
                    <div class="pimpinan-card-content">
                        <h4 class="pimpinan-card-name">Nama Kepala Sekolah</h4>
                        <div class="pimpinan-card-role">Kepala Sekolah RA</div>
                        <p class="pimpinan-card-quote">
                            "Berkomitmen mendampingi setiap langkah tumbuh kembang anak dengan penuh kasih sayang dan kesabaran untuk mencetak generasi yang berakhlak mulia."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="guru" class="py-5 bg-light rounded-4 my-4" style="background-color: #f5f9f6 !important;">
    <div class="container py-4 text-center">
        <div class="section-title-wrapper">
            <span class="section-tagline">Tenaga Pendidik</span>
            <h2 class="section-main-title">GURU - GURU SEKOLAH</h2>
            <div class="section-title-line"></div>
        </div>

        <div class="row justify-content-center g-4">
            <?php if(!empty($total_guru)): ?>
                <?php foreach($total_guru as $g): ?>
                
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="teacher-card">
                        <div class="teacher-card-img-container">
                            <?php if (! empty($g['foto_guru'])) : ?>
                                <img src="<?= base_url('uploads/foto_guru/' . rawurlencode($g['foto_guru'])) ?>"
                                     alt="Foto <?= esc($g['nama_guru'] ?? 'guru') ?>"
                                     class="teacher-card-img"
                                     loading="lazy">
                            <?php else : ?>
                                <div class="teacher-card-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 270" class="teacher-card-placeholder-svg" preserveAspectRatio="none">
                                        <defs>
                                            <linearGradient id="rect-grad-<?= $g['id'] ?>" x1="0%" y1="0%" x2="0%" y2="100%">
                                                <stop offset="0%" stop-color="#1e5237" />
                                                <stop offset="100%" stop-color="#16432b" />
                                            </linearGradient>
                                        </defs>
                                        <rect width="240" height="270" fill="url(#rect-grad-<?= $g['id'] ?>)" />
                                        <path d="M0,270 Q120,230 240,270 Z" fill="#27ae60" opacity="0.08" />
                                        <circle cx="120" cy="110" r="38" fill="#27ae60" opacity="0.15" />
                                        <path d="M120,162 C85,162 65,182 65,222 C65,223 66,225 67,225 L173,225 C174,225 175,223 175,222 C175,182 155,162 120,162 Z" fill="#27ae60" opacity="0.15" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="teacher-card-overlay"></div>
                        
                        <div class="teacher-card-content">
                            <h5 class="teacher-card-name"><?= esc($g['nama_guru'] ?? '-') ?></h5>
                            <p class="teacher-card-role"><?= esc($g['nip_nik'] ? 'NIP. ' . $g['nip_nik'] : 'Tenaga Pendidik') ?></p>
                            
                            <div class="teacher-card-footer">
                                <div class="teacher-card-edu">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                    <span><?= esc($g['pendidikan'] ?? '-') ?></span>
                                </div>
                                <span class="teacher-card-badge"><?= esc($g['jabatan'] ?? 'Staff') ?></span>
                            </div>
                        </div>
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

<section id="faq" class="py-5">
    <div class="container py-4">
        <div class="section-title-wrapper text-center">
            <span class="section-tagline">Tanya Jawab</span>
            <h2 class="section-main-title">PERTANYAAN UMUM</h2>
            <div class="section-title-line"></div>
        </div>

        <div class="row g-4">
            <?php 
            $faqs = [
                1 => "Bagaimana prosedur pendaftaran murid baru?",
                2 => "Apa saja program ekstrakurikuler yang tersedia?",
                3 => "Bagaimana metode pembelajaran yang diterapkan?",
                4 => "Apakah sekolah menyediakan fasilitas jemputan?",
                5 => "Bagaimana cara memantau perkembangan anak?",
                6 => "Kapan hari libur dan kalender akademik aktif?"
            ];
            foreach($faqs as $i => $q): 
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="faq-card card border-0 shadow-sm h-100 p-4">
                    <div class="faq-icon">
                        <i class="fa-solid fa-circle-question"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2"><?= esc($q) ?></h6>
                    <p class="small text-muted mb-0" style="text-align: justify; line-height: 1.6;">
                        Ini adalah contoh jawaban singkat untuk membantu orang tua memahami informasi seputar prosedur, kegiatan, maupun kebijakan pembelajaran di sekolah RA Perwanida.
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
