<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Panel de Control - Gestión de Alquileres
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/ListaAlquiler.css') ?>">

<div class="fleet-wrap">

    <!-- Header -->
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2 class="fleet-title mb-1">Gestión de Alquileres</h2>
            <p class="fleet-sub mb-0">Administra las solicitudes entrantes, aprueba reservas y procesa las devoluciones de la flota.</p>
        </div>
    </div>

    <!-- Flash messages -->
    <?php if (session()->getFlashdata('exito')): ?>
        <div class="alert alert-fleet alert-dismissible fade show mb-4" style="background:#ecfdf5; color:#065f46;">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span><?= session()->getFlashdata('exito') ?></span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-fleet alert-dismissible fade show mb-4" style="background:#fef2f2; color:#991b1b;">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span><?= session()->getFlashdata('error') ?></span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php
        // KPIs rápidos a partir del listado (no requiere cambios en el controlador)
        $totalReserva = $totalAlquiler = $totalFinalizado = 0;
        if (!empty($alquileres)) {
            foreach ($alquileres as $a) {
                if ($a['estado'] === 'reserva') $totalReserva++;
                elseif ($a['estado'] === 'alquiler') $totalAlquiler++;
                else $totalFinalizado++;
            }
        }
    ?>

    <!-- KPI strip -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div class="kpi-icon" style="background:#eff6ff; color:#2563eb;"><i class="bi bi-clock-history"></i></div>
                <div>
                    <div class="kpi-num"><?= $totalReserva ?></div>
                    <div class="kpi-label">Reservas pendientes</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div class="kpi-icon" style="background:#fffbeb; color:#b45309;"><i class="bi bi-play-circle-fill"></i></div>
                <div>
                    <div class="kpi-num"><?= $totalAlquiler ?></div>
                    <div class="kpi-label">Vehículos en curso</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div class="kpi-icon" style="background:#f8fafc; color:#94a3b8;"><i class="bi bi-check2-all"></i></div>
                <div>
                    <div class="kpi-num"><?= $totalFinalizado ?></div>
                    <div class="kpi-label">Finalizados</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="fleet-card">
        <div class="table-responsive">
            <table class="table fleet-table align-middle mb-0" style="min-width: 900px;">
                <thead>
                    <tr>
                        <th class="ps-4">Vehículo</th>
                        <th>Cliente</th>
                        <th>Período / Días</th>
                        <th>Estado actual</th>
                        <th class="pe-4 text-end">Acciones de control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($alquileres)): ?>
                        <?php foreach ($alquileres as $item): ?>
                            <tr class="row-<?= esc($item['estado']) ?>">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="vehicle-icon"><i class="bi bi-car-front-fill"></i></div>
                                        <div>
                                            <div class="vehicle-name"><?= esc($item['marca']) ?> <?= esc($item['modelo']) ?></div>
                                            <div class="vehicle-meta">Año <?= $item['anio'] ?> &middot; <?= esc($item['motor']) ?></div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="client-name"><?= esc($item['cliente_nombre']) ?></div>
                                    <div class="client-phone"><i class="bi bi-telephone me-1"></i><?= esc($item['cliente_telefono']) ?></div>
                                </td>

                                <td>
                                    <div class="period-dates">
                                        <?= date('d/m/Y', strtotime($item['fecha_desde'])) ?>
                                        <i class="bi bi-arrow-right text-muted mx-1"></i>
                                        <?= date('d/m/Y', strtotime($item['fecha_hasta'])) ?>
                                    </div>
                                    <span class="days-pill"><?= $item['cantidad_dias'] ?> <?= $item['cantidad_dias'] == 1 ? 'día' : 'días' ?></span>
                                </td>

                                <td>
                                    <?php if ($item['estado'] === 'reserva'): ?>
                                        <span class="status-pill status-reserva"><span class="dot"></span> Reserva pendiente</span>
                                    <?php elseif ($item['estado'] === 'alquiler'): ?>
                                        <span class="status-pill status-alquiler"><span class="dot"></span> En curso</span>
                                    <?php else: ?>
                                        <span class="status-pill status-finalizado"><span class="dot"></span> Finalizado</span>
                                    <?php endif; ?>
                                </td>

                                <td class="pe-4 text-end">
                                    <?php if ($item['estado'] === 'reserva'): ?>
                                        <form action="<?= base_url('alquiler/aprobarAlquiler/' . $item['id']) ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-fleet-primary">
                                                <i class="bi bi-check-lg me-1"></i> Registrar alquiler
                                            </button>
                                        </form>
                                    <?php elseif ($item['estado'] === 'alquiler'): ?>
                                        <form action="<?= base_url('alquiler/procesarDevolucion/' . $item['id']) ?>" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-fleet-danger">
                                                <i class="bi bi-arrow-down-left-circle me-1"></i> Procesar devolución
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="no-action"><i class="bi bi-lock me-1"></i>Sin acciones</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>No se encontraron registros de alquileres o reservas en este momento.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?= $this->endSection() ?>