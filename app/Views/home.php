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

    /* Hero Carousel Sizing & Premium Adjustments */
    .hero-carousel-img {
        height: 520px !important;
        object-fit: cover;
        object-position: center;
    }
    .carousel-inner {
        max-height: 520px !important;
    }
    .banner-desc {
        max-width: 700px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        font-size: 1.1rem;
        line-height: 1.6;
    }
    @media (max-width: 768px) {
        .carousel-inner {
            max-height: 280px !important;
        }
        .hero-carousel-img {
            height: 280px !important;
        }
        .carousel-caption {
            padding-bottom: 20px !important;
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
        .carousel-caption h1 {
            font-size: 1.3rem !important;
            line-height: 1.35 !important;
            margin-bottom: 12px !important;
            font-weight: 700 !important;
        }
        .banner-desc {
            font-size: 0.82rem !important;
            line-height: 1.4 !important;
            margin-bottom: 10px !important;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            max-width: 90% !important;
            margin-left: auto;
            margin-right: auto;
        }
        .carousel-caption .btn {
            padding: 6px 16px !important;
            font-size: 0.8rem !important;
        }
    }
    @media (max-width: 576px) {
        .carousel-inner {
            max-height: 190px !important;
        }
        .hero-carousel-img {
            height: 190px !important;
        }
        .carousel-caption {
            padding-bottom: 12px !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        .carousel-caption h1 {
            font-size: 0.95rem !important;
            line-height: 1.3 !important;
            margin-bottom: 6px !important;
            font-weight: 700 !important;
        }
        .banner-desc {
            font-size: 0.7rem !important;
            line-height: 1.35 !important;
            margin-bottom: 8px !important;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            max-width: 95% !important;
            margin-left: auto;
            margin-right: auto;
        }
        .carousel-caption .btn {
            padding: 4px 10px !important;
            font-size: 0.68rem !important;
        }
    }

    /* Responsive image wrappers */
    .about-img {
        height: 100% !important;
        object-fit: cover;
    }
    @media (max-width: 768px) {
        .img-wrapper-responsive {
            height: 240px !important;
        }
    }

    /* Pimpinan & Guru Cards Mobile Compatibility */
    @media (max-width: 576px) {
        .pimpinan-card {
            height: 280px !important;
            min-height: 280px !important;
            border-radius: 16px !important;
        }
        .teacher-card {
            height: 240px !important;
            min-height: 240px !important;
            border-radius: 16px !important;
        }
        .pimpinan-img-container {
            height: 170px !important;
        }
        .teacher-card-img-container {
            height: 140px !important;
        }
        .pimpinan-card-content {
            padding: 10px 12px 12px 12px !important;
        }
        .teacher-card-content {
            padding: 8px 10px 10px 10px !important;
        }
        .pimpinan-card-name {
            font-size: 0.78rem !important;
            margin-bottom: 2px !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .teacher-card-name {
            font-size: 0.78rem !important;
            margin-bottom: 1px !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .pimpinan-card-role {
            font-size: 0.65rem !important;
            margin-bottom: 6px !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .teacher-card-role {
            font-size: 0.65rem !important;
            margin-bottom: 4px !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .pimpinan-card-quote {
            font-size: 0.58rem !important;
            line-height: 1.25 !important;
            padding-top: 6px !important;
            margin-top: 4px !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        }
        .teacher-card-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            padding-top: 6px !important;
            margin-top: 2px !important;
        }
        .teacher-card-edu {
            font-size: 0.6rem !important;
        }
        .teacher-card-edu i {
            margin-right: 3px !important;
            font-size: 0.68rem !important;
        }
        .teacher-card-badge {
            padding: 3px 6px !important;
            font-size: 0.55rem !important;
            border-radius: 6px !important;
        }
        .pimpinan-card-overlay, .teacher-card-overlay {
            background: linear-gradient(to bottom, rgba(22, 67, 43, 0) 30%, #16432b 65%) !important;
        }
    }

    /* Berita & Kegiatan Section Styles */
    .news-card {
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(39, 174, 96, 0.1) !important;
        border-color: rgba(39, 174, 96, 0.2);
    }
    .news-img-wrapper {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    .news-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .news-card:hover .news-img {
        transform: scale(1.05);
    }
    .news-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 10;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 50px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* News Card Mobile Compatibility */
    @media (max-width: 576px) {
        .news-card {
            border-radius: 14px !important;
        }
        .news-img-wrapper {
            height: 110px !important;
        }
        .news-badge {
            top: 8px !important;
            left: 8px !important;
            font-size: 0.65rem !important;
            padding: 3px 8px !important;
        }
        .news-card .card-body {
            padding: 10px !important;
        }
        .news-card .card-body .d-flex {
            margin-bottom: 2px !important;
            gap: 4px !important;
        }
        .news-card .card-body .d-flex span,
        .news-card .card-body .d-flex i {
            font-size: 0.68rem !important;
        }
        .news-card h5 {
            font-size: 0.82rem !important;
            margin-bottom: 4px !important;
            line-height: 1.25 !important;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .news-card p {
            font-size: 0.68rem !important;
            line-height: 1.35 !important;
            margin-bottom: 10px !important;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .news-card .btn {
            padding: 4px 4px !important;
            font-size: 0.64rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            white-space: nowrap !important;
        }
        .news-card .btn i {
            margin-left: 4px !important;
        }
    }
</style>

<div class="container py-4">
    <!-- Hero Banner Carousel -->
    <div id="heroCarousel" class="carousel slide carousel-fade mb-5" data-bs-ride="carousel" data-bs-interval="4000">
        <!-- Indicators -->
        <?php if (!empty($banners) && count($banners) > 1): ?>
            <div class="carousel-indicators">
                <?php foreach ($banners as $index => $b): ?>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>"></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Slides -->
        <div class="carousel-inner rounded-4 shadow-sm overflow-hidden" style="max-height: 520px;">
            <?php if (!empty($banners)): ?>
                <?php foreach ($banners as $index => $b): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="position-relative">
                            <!-- Dark Overlay -->
                            <div class="position-absolute w-100 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.7) 100%); z-index: 1;"></div>
                            <img src="<?= base_url('uploads/banners/' . esc($b['gambar'])) ?>" class="d-block w-100 hero-carousel-img" alt="<?= esc($b['judul']) ?>" style="height: 520px; object-fit: cover;">
                            
                            <!-- Caption Content -->
                            <div class="carousel-caption d-flex flex-column justify-content-end text-start h-100 pb-5 px-4 px-md-5" style="z-index: 2; left: 0; right: 0; bottom: 0;">
                                <div class="container-fluid">
                                    <h1 class="display-5 fw-bold text-white mb-2" style="font-family: 'Quicksand', sans-serif; text-shadow: 0 2px 4px rgba(0,0,0,0.5);"><?= esc($b['judul']) ?></h1>
                                    <?php if (!empty($b['deskripsi'])): ?>
                                        <p class="banner-desc text-white-50 mb-3"><?= esc($b['deskripsi']) ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($b['link_url'])): ?>
                                        <a href="<?= esc($b['link_url']) ?>" target="_blank" class="btn btn-success px-4 py-2.5 rounded-pill fw-bold shadow d-inline-flex align-items-center gap-2" style="background-color: #27ae60; border-color: #27ae60;">
                                            Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default Placeholder Slide -->
                <div class="carousel-item active">
                    <div class="position-relative">
                        <div class="position-absolute w-100 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.7) 100%); z-index: 1;"></div>
                        <img src="<?= base_url('assets/images/gambar-sekolah.jpeg') ?>" class="d-block w-100 hero-carousel-img" alt="Selamat Datang" style="height: 520px; object-fit: cover;">
                        <div class="carousel-caption d-flex flex-column justify-content-end text-start h-100 pb-5 px-4 px-md-5" style="z-index: 2; left: 0; right: 0; bottom: 0;">
                            <div class="container-fluid">
                                <h1 class="display-5 fw-bold text-white mb-2" style="font-family: 'Quicksand', sans-serif; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Selamat Datang di RA Perwanida Tempursari</h1>
                                <p class="banner-desc text-white-50 mb-3">Mendidik dengan ilmu, menuntun dengan adab. Membangun generasi unggul yang cerdas, sehat, dan mandiri sejak usia dini.</p>
                                <a href="#tentang" class="btn btn-success px-4 py-2.5 rounded-pill fw-bold shadow d-inline-flex align-items-center gap-2" style="background-color: #27ae60; border-color: #27ae60;">
                                    Kenali Kami <i class="fa-solid fa-arrow-down"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Controls -->
        <?php if (!empty($banners) && count($banners) > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" style="z-index: 3;">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" style="z-index: 3;">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        <?php endif; ?>
    </div>
</div>

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
                <div class="about-img-container img-wrapper-responsive" style="height: 340px;">
                    <img src="<?= base_url('assets/images/gambar-sekolah.jpeg') ?>" 
                        alt="Gedung RA Perwanida" 
                        class="img-fluid rounded-4 shadow w-100 about-img">
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
                <div class="bg-white border rounded-4 shadow-sm overflow-hidden img-wrapper-responsive" style="height: 340px;">
                    <img src="<?= base_url('assets/images/foto-guru.jpeg') ?>" class="w-100 h-100 about-img" alt="Ilustrasi Visi Misi: Anak-anak aktif dan cerdas">
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
            <div class="col-10 col-sm-8 col-md-6 col-lg-4">
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
                
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
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

<section id="berita" class="py-5">
    <div class="container py-4">
        <div class="section-title-wrapper text-center">
            <span class="section-tagline">Info Terkini</span>
            <h2 class="section-main-title">BERITA & KEGIATAN</h2>
            <div class="section-title-line"></div>
        </div>

        <div class="row justify-content-center g-3 g-sm-4 mt-2">
            <?php if (!empty($latest_berita)) : ?>
                <?php foreach ($latest_berita as $item) : ?>
                    <div class="col-6 col-md-6 col-lg-4">
                        <div class="card news-card h-100 shadow-sm border-0">
                            <!-- Image Wrapper -->
                            <div class="news-img-wrapper">
                                <?php if ($item['gambar']) : ?>
                                    <img src="<?= base_url('uploads/berita/' . esc($item['gambar'])) ?>" alt="<?= esc($item['judul']) ?>" class="news-img">
                                <?php else : ?>
                                    <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-newspaper text-muted fa-3x"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Category Badge -->
                                <?php if ($item['kategori'] === 'Berita') : ?>
                                    <span class="badge news-badge bg-success" style="background-color: #27ae60 !important;">
                                        <i class="fas fa-newspaper me-1"></i> Berita
                                    </span>
                                <?php else : ?>
                                    <span class="badge news-badge bg-warning text-dark" style="background-color: #f1c40f !important;">
                                        <i class="fas fa-calendar-alt me-1"></i> Kegiatan
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                                    <i class="far fa-calendar-alt text-success"></i>
                                    <span><?= date('d M Y', strtotime($item['tanggal'])) ?></span>
                                </div>
                                <h5 class="fw-bold mb-3" style="color: #2c3e50; line-height: 1.4; font-family: 'Quicksand', sans-serif;">
                                    <?= esc($item['judul']) ?>
                                </h5>
                                <p class="text-muted small mb-4 flex-grow-1" style="text-align: justify; line-height: 1.6;">
                                    <?php
                                        $clean_content = preg_replace('/<[^>]+>/', ' ', $item['konten']);
                                        $clean_content = html_entity_decode($clean_content);
                                        $clean_content = preg_replace('/\s+/', ' ', $clean_content);
                                        $clean_content = trim($clean_content);
                                        echo esc(substr($clean_content, 0, 120)) . (strlen($clean_content) > 120 ? '...' : '');
                                    ?>
                                </p>
                                <a href="<?= base_url('berita/' . $item['slug']) ?>" class="btn btn-outline-success rounded-pill w-100 py-2 fw-semibold mt-auto" style="border-color: #27ae60; color: #27ae60;">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12 text-center py-5">
                    <div class="text-muted">
                        <i class="far fa-folder-open fa-3x mb-3 text-secondary"></i>
                        <p class="mb-0">Belum ada berita atau kegiatan terbaru.</p>
                    </div>
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
