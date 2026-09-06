<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Dashboard de Reportes
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xl py-4">
    <div class="mb-5">
        <h2 class="fw-extrabold text-dark mb-1">Centro de Reportes</h2>
        <p class="text-muted">Genera reportes operativos y analiza el historial de la flota.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-3 p-3 mb-3">
                        <i class="bi bi-car-front-fill fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Historial por Vehículo</h5>
                    <p class="text-muted small">Consulta todos los clientes que han alquilado un vehículo específico.</p>
                    
                    <form action="<?= base_url('administracion/reportes/vehiculo') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <select name="vehiculo_id" class="form-select" required>
                                <option value="" disabled selected>Seleccione un vehículo...</option>
                                <?php foreach ($vehiculos as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= esc($v['marca']) ?> <?= esc($v['modelo']) ?> (<?= esc($v['matricula'] ?? $v['anio']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-semibold rounded-pill">Generar Reporte</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-3 p-3 mb-3">
                        <i class="bi bi-person-lines-fill fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Historial por Cliente</h5>
                    <p class="text-muted small">Visualiza todos los vehículos que han sido alquilados por un cliente.</p>
                    
                    <form action="<?= base_url('administracion/reportes/cliente') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <select name="usuario_id" class="form-select" required>
                                <option value="" disabled selected>Seleccione un cliente...</option>
                                <?php foreach ($clientes as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= esc($c['nombre_apellido']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-semibold rounded-pill">Generar Reporte</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 bg-dark text-white">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-10 text-warning rounded-3 p-3 mb-3" style="width: fit-content;">
                        <i class="bi bi-activity fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Alquileres Activos</h5>
                    <p class="text-white-50 small mb-auto">Listado en tiempo real de los vehículos que actualmente se encuentran en curso (estado: alquiler).</p>
                    
                    <div class="mt-4">
                        <a href="<?= base_url('administracion/reportes/actuales') ?>" class="btn btn-warning w-100 fw-semibold rounded-pill">Ver Monitor en Vivo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>