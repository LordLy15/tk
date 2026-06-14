<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<section class="py-5 mt-5 min-vh-100 bg-light">
    <div class="container py-4">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="<?= base_url('/#berita') ?>" class="btn btn-outline-success rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2" style="border-color: #27ae60; color: #27ae60;">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <!-- Article Card -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    
                    <!-- Cover Image -->
                    <?php if ($item['gambar']) : ?>
                        <div class="position-relative" style="max-height: 480px; overflow: hidden;">
                            <img src="<?= base_url('uploads/berita/' . esc($item['gambar'])) ?>" 
                                 alt="<?= esc($item['judul']) ?>" 
                                 class="w-100 img-fluid object-fit-cover"
                                 style="max-height: 480px; object-fit: cover;">
                            
                            <!-- Category Badge -->
                            <div class="position-absolute top-0 start-0 m-4">
                                <?php if ($item['kategori'] === 'Berita') : ?>
                                    <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.9rem; background-color: #27ae60 !important;">
                                        <i class="fas fa-newspaper me-1"></i> Berita
                                    </span>
                                <?php else : ?>
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.9rem; background-color: #f1c40f !important;">
                                        <i class="fas fa-calendar-alt me-1"></i> Kegiatan
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="card-body p-4 p-md-5">
                        <!-- Metadata -->
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-4 text-muted small border-bottom pb-3">
                            <div class="d-flex align-items-center gap-1.5">
                                <i class="far fa-calendar-alt text-success"></i>
                                <span><?= date('d M Y', strtotime($item['tanggal'])) ?></span>
                            </div>
                            <div class="d-flex align-items-center gap-1.5">
                                <i class="far fa-user text-success"></i>
                                <span>Penulis: <strong><?= esc($item['penulis']) ?></strong></span>
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="fw-bold mb-4" style="color: #2c3e50; font-family: 'Quicksand', sans-serif; font-size: 2.2rem; line-height: 1.3;">
                            <?= esc($item['judul']) ?>
                        </h1>

                        <!-- Content Body -->
                        <div class="article-content lh-lg text-secondary" style="font-size: 1.1rem; text-align: justify;">
                            <?= $item['konten'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .article-content p {
        margin-bottom: 1.5rem;
    }
    .article-content blockquote {
        border-left: 4px solid #27ae60;
        padding-left: 1.5rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #555;
    }
</style>
<?= $this->endSection() ?>
