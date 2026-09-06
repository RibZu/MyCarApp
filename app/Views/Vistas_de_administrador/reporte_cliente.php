<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Historial de Alquileres por Cliente
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xl py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Historial del Cliente</h2>
            <p class="text-muted small">Listado cronológico de todos los vehículos reservados o alquilados por este usuario.</p>
        </div>
        <a href="<?= base_url('administracion/reportes') ?>" class="btn btn-outline-secondary rounded-pill fw-semibold px-4">
            <i class="bi bi-arrow-left me-1"></i> Volver a Reportes
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="min-width: 800px;">
                <thead class="bg-light text-muted small fw-bold text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Vehículo</th>
                        <th class="py-3">Fecha Desde</th>
                        <th class="py-3">Fecha Hasta</th>
                        <th class="py-3">Días</th>
                        <th class="py-3">Estado del Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($alquileres)): ?>
                        <?php foreach ($alquileres as $item): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-light rounded-3 p-2 text-secondary">
                                            <i class="bi bi-car-front-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block"><?= esc($item['marca']) ?> <?= esc($item['modelo']) ?></span>
                                            <span class="text-muted small">ID Vehículo: #<?= $item['vehiculo_id'] ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><?= date('d/m/Y', strtotime($item['fecha_desde'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($item['fecha_hasta'])) ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-semibold px-2 py-1">
                                        <?= $item['cantidad_dias'] ?> <?= $item['cantidad_dias'] == 1 ? 'día' : 'días' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($item['estado'] === 'reserva'): ?>
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">Reserva Pendiente</span>
                                    <?php elseif ($item['estado'] === 'alquiler'): ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning-emphasis px-3 py-2 rounded-pill fw-bold">En Curso</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill fw-bold">Finalizado</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x display-6 d-block mb-2 text-black-50"></i>
                                El cliente seleccionado no posee registros de alquileres históricos.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>