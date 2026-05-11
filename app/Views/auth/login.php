<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card shadow border-0 mt-5">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Login Guru TK</h3>
                
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form action="/auth/login" method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Masuk ke Dashboard</button>
                </form>
            </div>
        </div>
        <p class="text-center mt-3 text-muted"><small>Gunakan akun yang sudah terdaftar di sistem.</small></p>
    </div>
</div>

<?= $this->endSection() ?>