<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Iniciar Sesión
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 mt-5">
            <h3 class="fw-bold text-center mb-4">Iniciar Sesión</h3>
            
            <?php if(session()->getFlashdata('msg')): ?>
                <div class="alert alert-danger text-center">
                    <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif; ?>
            
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success text-center">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login/autenticar') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary rounded-pill fw-semibold">Entrar</button>
                </div>
            </form>
            <div class="text-center mt-4">
                <span class="text-muted">¿No tienes cuenta?</span> <a href="<?= base_url('registro') ?>" class="text-decoration-none fw-semibold">Regístrate aquí</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>