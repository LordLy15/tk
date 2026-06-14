<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi RA Perwanida</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    <link rel="shortcut icon" type="image/svg+xml" href="<?= base_url('assets/dashboard/images/logo-ra.svg') ?>">
    
    <style>
        /* Menyembunyikan scrollbar vertikal tapi halaman tetap bisa di-scroll */
        html, body {
        scrollbar-width: none; /* Untuk Firefox */
        -ms-overflow-style: none; /* Untuk Internet Explorer dan Edge */
        overflow-x: hidden;
        }

        html::-webkit-scrollbar, body::-webkit-scrollbar {
        display: none; /* Untuk Chrome, Safari, Opera, dan Edge berbasis Chromium */
        }
        
        html { scroll-behavior: smooth; }
        body { font-family: 'Quicksand', sans-serif; background-color: #ffffff; overflow-x: hidden; }
        section { scroll-margin-top: 100px; }  
        .navbar { 
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%) !important;
            padding: 12px 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-bottom: 3px solid #f1c40f; 
        }

        .navbar-brand img { max-height: 55px; background: white; padding: 2px; border-radius: 50%; }
        .navbar-brand span { color: white !important; font-weight: 700; font-size: 1.1rem; }
        
        .nav-link { 
            color: rgba(255,255,255,0.9) !important; 
            font-weight: 600; 
            margin: 0 8px; 
            transition: 0.3s; 
        }
        .nav-link:hover { color: #f1c40f !important; }

        /* PERUBAHAN DISINI: Optimasi Hover Desktop agar tidak konflik dengan fungsi Klik Mobile */
        @media (min-width: 992px) {
            .nav-item.dropdown:hover .dropdown-menu { 
                display: block; 
                margin-top: 0; 
            }
            .nav-item.dropdown .dropdown-toggle {
                pointer-events: none;
            }
        }

        .dropdown-menu { 
            border: none; 
            border-top: 4px solid #f1c40f; 
            border-radius: 0 0 10px 10px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            padding: 0;
            overflow: hidden;
        }

        .dropdown-item { 
            font-weight: 600; 
            color: #555; 
            padding: 10px 20px; 
            border-bottom: 1px solid #f8f9fa;
        }
        
        .dropdown-item:hover { 
            background-color: #f8f9fa; 
            color: #27ae60; 
        }

        .footer { background: #f8f9fa; padding: 50px 0; border-top: 5px solid #27ae60; }

        .social-container {
            display: flex;
            gap: 15px;
            margin-top: 15px;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .social-container { justify-content: flex-start; }
            .footer-social-icons {
                justify-content: flex-start !important;
                padding-left: 20px !important;
            }
        }

        .social-icon-link {
            transition: transform 0.3s ease;
            display: inline-block;
        }
        .social-icon-link:hover {
            transform: scale(1.2);
        }

        /* Style Lihat Selengkapnya */
        #moreMisi { display: none; }
        .btn-read-more {
            color: #27ae60;
            cursor: pointer;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        /* Tampilan Menu Mobile Full-Width */
@media (max-width: 991px) {
    .navbar-collapse {
        position: absolute;
        top: 100%; /* Muncul tepat di bawah garis kuning navbar */
        left: 0;
        width: 100%; /* Memenuhi layar 100% */
        background-color: #ffffff; /* Background putih agar bersih */
        padding: 10px 25px 25px;
        box-shadow: 0 15px 25px rgba(0,0,0,0.15);
        z-index: 1000;
    }
    
    .navbar-nav {
        text-align: left !important; /* Menu rata kiri untuk mobile */
    }
    
    .navbar-nav .nav-link {
        color: #2c3e50 !important; /* Mengubah warna teks menjadi gelap */
        padding: 12px 10px;
        border-bottom: 1px solid #f1f2f6; /* Garis pemisah antar menu */
    }
    
    .navbar-nav .nav-link:hover {
        color: #27ae60 !important;
        background-color: #f9f9f9;
        border-radius: 5px;
    }

    /* Penyesuaian Dropdown di Mobile */
    .dropdown-menu {
        border: none;
        box-shadow: none;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin: 5px 0 10px 15px; /* Menjorok sedikit ke dalam */
        padding: 5px 0;
    }
    
    .dropdown-item {
        border-bottom: none;
        padding: 8px 15px;
    }
}

@media (max-width: 576px) {
    .navbar-brand img {
        max-height: 42px !important;
    }
    .navbar-brand span {
        font-size: 0.95rem !important;
    }
    .navbar-brand small {
        font-size: 0.62rem !important;
    }
    .navbar-toggler {
        padding: 4px 8px !important;
        font-size: 0.9rem !important;
    }
}

/* Fix text spacing / justify issue on mobile and tablet viewports */
@media (max-width: 768px) {
    .article-content, .article-content *, .news-card p, #tentang p, #visi-misi p, .faq-card p {
        text-align: left !important;
    }
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid px-3 px-md-5">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url(); ?>">
            <img src="<?= base_url('assets/logo.png'); ?>" alt="Logo RA Perwanida" class="me-3">
            <div class="lh-1">
                <span class="d-block">RA PERWANIDA</span>
                <small style="color: #ffffff; font-size: 0.7rem;">TEMPURSARI</small>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto text-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>">Beranda</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navTentang" role="button" data-bs-toggle="dropdown">
                        Tentang
                    </a>
                    <ul class="dropdown-menu shadow-sm">
                        <li><a class="dropdown-item" href="<?= base_url('#tentang') ?>">Tentang Kami</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('#visi-misi') ?>">Visi Misi</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('#pimpinan') ?>">Pimpinan Sekolah</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('#guru') ?>">Guru Guru</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('#lokasi') ?>">Lokasi Sekolah</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navProgram" role="button" data-bs-toggle="dropdown">
                        Program Sekolah
                    </a>
                    <ul class="dropdown-menu shadow-sm">
                        <li><a class="dropdown-item" href="<?= base_url('#program') ?>">Program Sekolah</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('#seragam') ?>">Seragam Sekolah</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('pendaftaran') ?>">Pendaftaran</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('#kegiatan') ?>">Kegiatan Sekolah</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('#berita') ?>">Berita & Kegiatan</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="https://wa.me/628123456789" target="_blank">Kontak</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
    <?= $this->renderSection('content') ?>
</main>

<footer id="kontak" class="footer mt-5">
    <div class="container">
        <div class="row text-center text-md-start d-flex align-items-start">
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                    <img src="<?= base_url('assets/logo.png'); ?>" alt="Logo" width="60" class="me-3">
                    <div class="text-start">
                        <h5 class="fw-bold mb-1" style="color: #27ae60; line-height: 1.2;">RA PERWANIDA</h5>
                        <p class="small text-muted mb-0" style="line-height: 1.3;">Mendidik dengan ilmu, menuntun dengan adab.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="fw-bold" style="color: #27ae60;">Alamat</h5>
                <p class="small text-muted">Tempursari RT 04/03 Desa Tempursari Kecamatan Sambi 
                Kabupaten Boyolali 57376</p>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="fw-bold" style="color: #27ae60;">Hubungi Kami</h5>
                <a href="https://wa.me/628123456789" class="btn btn-success btn-sm rounded-pill px-4 shadow-sm mb-3">
                    <i class="fab fa-whatsapp me-2"></i>Chat WhatsApp
                </a>
                
                <div class="d-flex gap-3 justify-content-center footer-social-icons mt-2">
                    <a href="https://instagram.com/raperwanidatempursari?igshid=YmMyMTA2M2Y=" target="_blank" class="social-icon-link" title="Instagram">
                        <i class="fab fa-instagram fs-4" style="color: #E1306C;"></i>
                    </a>
                    <a href="https://www.facebook.com/raperwanida.tempursari" target="_blank" class="social-icon-link" title="Facebook">
                        <i class="fab fa-facebook fs-4" style="color: #1877F2;"></i>
                    </a>
                    <a href="https://youtube.com/channel/UCVB9WzzeCXluCUKBkkw0PIw" target="_blank" class="social-icon-link" title="YouTube">
                        <i class="fab fa-youtube fs-4" style="color: #FF0000;"></i>
                    </a>
                    <a href="https://www.tiktok.com/@raperwanidatempursari?_t=8VyC9v5qgV8&_r=1" target="_blank" class="social-icon-link" title="TikTok">
                        <i class="fab fa-tiktok fs-4" style="color: #000000;"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4" id="lokasi">
                <h5 class="fw-bold" style="color: #27ae60;">Lokasi Sekolah</h5>
                <div class="position-relative overflow-hidden rounded-3 shadow-sm" style="height: 130px; border: 1px solid rgba(0,0,0,0.08);">
                    <iframe src="https://maps.google.com/maps?q=RA%20Perwanida%20Tempursari%20Sambi%20Boyolali&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

        </div>
        <hr>
        <div class="text-center">
            <p class="small text-muted mb-0">© 2026 RA PERWANIDA TEMPURSARI. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleMisi() {
        var moreText = document.getElementById("moreMisi");
        var btnText = document.getElementById("btnReadMore");

        if (moreText.style.display === "none" || moreText.style.display === "") {
            moreText.style.display = "inline";
            btnText.innerHTML = "Sembunyikan";
        } else {
            moreText.style.display = "none";
            btnText.innerHTML = "Lihat Selengkapnya...";
        }
    }

    /* PERUBAHAN DISINI: Script Pembersih Event agar Dropdown tidak tersangkut saat Resize Layar */
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                menu.classList.remove('show');
            });
            document.querySelectorAll('.dropdown-toggle.show').forEach(function(toggle) {
                toggle.classList.remove('show');
                toggle.setAttribute('aria-expanded', 'false');
            });
        }
    });
</script>

</body>
</html>
