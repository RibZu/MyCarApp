<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Historial de Clientes por Vehículo
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xl py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Historial del Vehículo</h2>
            <p class="text-muted small">Listado de todos los clientes que han reservado o utilizado esta unidad.</p>
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
                        <th class="ps-4 py-3">Cliente / Conductor</th>
                        <th class="py-3">Teléfono de Contacto</th>
                        <th class="py-3">Período de Uso</th>
                        <th class="py-3">Días Totales</th>
                        <th class="py-3">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($alquileres)): ?>
                        <?php foreach ($alquileres as $item): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-light rounded-circle p-2 text-primary">
                                            <i class="bi bi-person-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block"><?= esc($item['nombre_apellido']) ?></span>
                                            <span class="text-muted small">ID Usuario: #<?= $item['usuario_id'] ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="tel:<?= esc($item['telefono']) ?>" class="text-decoration-none text-secondary">
                                        <i class="bi bi-telephone me-1"></i> <?= esc($item['telefono']) ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="text-dark fw-semibold">
                                        <?= date('d/m/Y', strtotime($item['fecha_desde'])) ?>
                                        <i class="bi bi-arrow-right text-muted mx-1"></i>
                                        <?= date('d/m/Y', strtotime($item['fecha_hasta'])) ?>
                                    </span>
                                </td>
                                <td><?= $item['cantidad_dias'] ?> días</td>
                                <td>
                                    <?php if ($item['estado'] === 'reserva'): ?>
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">Reserva</span>
                                    <?php elseif ($item['estado'] === 'alquiler'): ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning-emphasis px-3 py-2 rounded-pill fw-bold">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill fw-bold">Finalizado</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-car-front display-6 d-block mb-2 text-black-50"></i>
                                Este vehículo no registra alquileres previos en el sistema.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>