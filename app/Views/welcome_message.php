<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Panel Principal de Acceso
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row text-center mt-4">
    <div class="col-12 mb-5">
        <h1 class="fw-bold display-4">Bienvenido a MyCarApp</h1>
        <p class="text-muted">El sistema más rápido para gestionar tu flota y alquileres.</p>
        
        <?php if(session()->get('isLoggedIn')): ?>
            <div class="alert alert-success d-inline-block rounded-pill px-4 shadow-sm border-0">
                ¡Hola, <strong><?= session()->get('nombre') ?></strong>! Estás en modo <strong><?= strtoupper(session()->get('rol')) ?></strong>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="row g-4 justify-content-center">
    
    <?php if(!session()->get('isLoggedIn')): ?>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 border-top border-primary border-4 rounded-4">
            <div class="card-body p-4 text-center">
                <h4 class="card-title text-primary"><i class="bi bi-person-badge fs-2 mb-2 d-block"></i> Autenticación</h4>
                <p class="text-muted small mb-4">Ingresa al sistema o crea una cuenta nueva en pocos minutos.</p>
                <a href="<?= base_url('login') ?>" class="btn btn-outline-primary w-100 mb-2 rounded-pill fw-semibold">Iniciar Sesión</a>
                <a href="<?= base_url('registro') ?>" class="btn btn-outline-success w-100 rounded-pill fw-semibold">Registro Cliente</a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(session()->get('isLoggedIn') && session()->get('rol') === 'admin'): ?>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 border-top border-dark border-4 rounded-4 bg-light">
            <div class="card-body p-4 text-center">
                <h4 class="card-title text-dark"><i class="bi bi-shield-lock-fill fs-2 mb-2 d-block"></i> Administrador</h4>
                <p class="text-muted small mb-4">Gestión completa del sistema, altas, bajas y listados.</p>
                <a href="<?= base_url('admin/clientes') ?>" class="btn btn-dark w-100 mb-2 rounded-pill fw-semibold shadow-sm">ABM Clientes</a>
                <a href="<?= base_url('administracion/listar') ?>" class="btn btn-secondary w-100 rounded-pill fw-semibold shadow-sm">ABM Vehículos</a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 border-top border-success border-4 rounded-4">
            <div class="card-body p-4 text-center">
                <h4 class="card-title text-success"><i class="bi bi-car-front-fill fs-2 mb-2 d-block"></i> Alquileres</h4>
                <p class="text-muted small mb-4">Explora nuestro catálogo de flota de vehículos disponibles.</p>
                <a href="<?= base_url('vehiculo/listar') ?>" class="btn btn-success w-100 mb-2 rounded-pill fw-semibold shadow-sm">Ver Catálogo</a>
                
                <?php if(session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('mi-perfil') ?>" class="btn btn-outline-secondary w-100 rounded-pill fw-semibold">Mi Perfil</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>