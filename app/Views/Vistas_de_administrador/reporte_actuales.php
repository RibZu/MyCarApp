<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Monitor de Alquileres Activos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xl py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Vehículos Alquilados Hoy</h2>
            <p class="text-muted small">Monitor en tiempo real de unidades en circulación con sus respectivos clientes asociados.</p>
        </div>
        <a href="<?= base_url('administracion/reportes') ?>" class="btn btn-outline-secondary rounded-pill fw-semibold px-4">
            <i class="bi bi-arrow-left me-1"></i> Volver a Reportes
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="min-width: 850px;">
                <thead class="bg-dark text-white small fw-bold text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Vehículo en Uso</th>
                        <th class="py-3">Cliente Responsable</th>
                        <th class="py-3">Fecha de Entrega</th>
                        <th class="py-3">Fecha Pactada de Devolución</th>
                        <th class="py-3">Progreso del Período</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($alquileres)): ?>
                        <?php foreach ($alquileres as $item): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-2">
                                            <i class="bi bi-key-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block"><?= esc($item['marca']) ?> <?= esc($item['modelo']) ?></span>
                                            <span class="text-muted small">Código de Registro: #<?= $item['id'] ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= esc($item['nombre_apellido']) ?></div>
                                    <span class="text-muted small">ID Cliente: #<?= $item['usuario_id'] ?></span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($item['fecha_desde'])) ?></td>
                                <td>
                                    <span class="text-danger fw-bold">
                                        <?= date('d/m/Y', strtotime($item['fecha_hasta'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-warning-emphasis fw-bold px-3 py-1.5 rounded-pill">
                                        <span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span> En Ruta
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-shield-check display-6 d-block mb-2 text-success"></i>
                                Todo el parque automotor se encuentra en base. No hay vehículos alquilados en este momento.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>