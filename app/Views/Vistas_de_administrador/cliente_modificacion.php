<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Editar Cliente
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h2 class="fw-bold text-dark">Modificar Cliente</h2>
    <p class="text-muted">Actualizando los datos de: <strong><?= esc($cliente['nombre_apellido']) ?></strong></p>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/clientes/actualizar/' . $cliente['id']) ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Nombre y Apellido</label>
                <input type="text" name="nombre_apellido" class="form-control" value="<?= old('nombre_apellido', esc($cliente['nombre_apellido'])) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" value="<?= old('email', esc($cliente['email'])) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="<?= old('telefono', esc($cliente['telefono'])) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Nueva Contraseña (Opcional)</label>
                <input type="text" name="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
            </div>
            <div class="col-md-12">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="<?= old('direccion', esc($cliente['direccion'])) ?>">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 border-top pt-3">
            <a href="<?= base_url('admin/clientes') ?>" class="btn btn-light border">Cancelar</a>
            <button type="submit" class="btn btn-dark">Actualizar Datos</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>