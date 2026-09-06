<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Registro de Cliente
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 mt-4">
            <h3 class="fw-bold text-center mb-4">Crear una Cuenta</h3>

            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('registro/guardar') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="nombre_apellido" class="form-label">Nombre y Apellido *</label>
                    <input type="text" name="nombre_apellido" class="form-control" value="<?= old('nombre_apellido') ?>" required>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?= old('telefono') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="<?= old('direccion') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico *</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="rol" class="form-label">Tipo de Cuenta</label>
                    <select name="rol" id="rol" class="form-select" required>
                        <option value="cliente" <?= old('rol') == 'cliente' ? 'selected' : '' ?>>Cliente</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña *</label>
                    <input type="password" name="password" class="form-control" required>
                    <div class="form-text">Mínimo 6 caracteres.</div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success rounded-pill fw-semibold">Completar Registro</button>
                </div>
            </form>
            <div class="text-center mt-4">
                <span class="text-muted">¿Ya tienes cuenta?</span> <a href="<?= base_url('login') ?>" class="text-decoration-none fw-semibold">Inicia Sesión</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>