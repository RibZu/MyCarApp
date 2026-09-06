<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Mi Perfil
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="mb-4 text-center">
            <h2 class="fw-bold text-dark"><i class="bi bi-person-circle"></i> Mi Perfil</h2>
            <p class="text-muted">Administra tu información personal y de contacto.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 mb-5">
            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-3">
                    <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 text-center fw-semibold">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('mi-perfil/actualizar') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-semibold">Nombre y Apellido</label>
                        <input type="text" name="nombre_apellido" class="form-control" value="<?= old('nombre_apellido', esc($usuario['nombre_apellido'])) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-semibold">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" value="<?= old('email', esc($usuario['email'])) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-semibold">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?= old('telefono', esc($usuario['telefono'])) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-semibold">Nueva Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para no cambiarla">
                        <div class="form-text text-muted small">Mínimo 6 caracteres si decides cambiarla.</div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-secondary fw-semibold">Dirección Completa</label>
                        <input type="text" name="direccion" class="form-control" value="<?= old('direccion', esc($usuario['direccion'])) ?>">
                    </div>
                </div>

                <div class="row bg-light rounded-3 p-3 mx-0 mb-4 border border-1 border-light-subtle">
                    <div class="col-md-6 text-center text-md-start">
                        <span class="d-block text-muted small mb-1">Privilegios en la plataforma:</span>
                        <span class="badge <?= $usuario['rol'] == 'admin' ? 'bg-dark' : 'bg-primary' ?> text-uppercase py-2 px-3">
                            Cuenta de <?= esc($usuario['rol']) ?>
                        </span>
                    </div>
                    <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                        <span class="d-block text-muted small mb-1">Miembro activo desde:</span>
                        <span class="fw-bold text-dark fs-5"><?= date('d/m/Y', strtotime($usuario['fecha_alta'])) ?></span>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                        <i class="bi bi-floppy"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>