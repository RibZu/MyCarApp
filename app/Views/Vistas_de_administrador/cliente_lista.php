<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Listado de Clientes
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark">Gestión de Clientes</h2>
        <p class="text-muted">Listado general de clientes registrados en el sistema.</p>
    </div>
    <a href="<?= base_url('admin/clientes/alta') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nuevo Cliente
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre y Apellido</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($clientes) && is_array($clientes)): ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= esc($cliente['id']) ?></td>
                            <td><?= esc($cliente['nombre_apellido']) ?></td>
                            <td><?= esc($cliente['email']) ?></td>
                            <td><?= esc($cliente['telefono']) ?: '<span class="text-muted">No asignado</span>' ?></td>
                            <td>
                                <?php if ($cliente['activo'] == 1): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Baja Lógica</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/clientes/editar/' . $cliente['id']) ?>" class="btn btn-sm btn-outline-secondary">
                                    Editar
                                </a>
                                <?php if ($cliente['activo'] == 1): ?>
                                    <a href="<?= base_url('admin/clientes/eliminar/' . $cliente['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de que deseas dar de baja a este cliente?');">
                                        Dar de Baja
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No hay clientes registrados en el sistema actualmente.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>