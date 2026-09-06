<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Detalle de <?= $vehiculo['marca'] ?> <?= $vehiculo['modelo'] ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="mb-3">
        <a href="<?= base_url('administracion/listar') ?>" class="btn btn-link text-muted fw-bold text-decoration-none d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; letter-spacing: 0.5px; padding-left: 0;">
            <i class="bi bi-arrow-left"></i> VOLVER A LA LISTA
        </a>
    </div>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <h1 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px; font-size: 2.2rem;"><?= $vehiculo['marca'] ?> <?= $vehiculo['modelo'] ?> <?= $vehiculo['anio'] ?></h1>
                
                <?php if ($vehiculo['activo'] == 0): ?>
                    <span class="badge rounded-pill px-3 py-1.5 fw-semibold border border-danger border-opacity-10 text-danger bg-danger bg-opacity-10" style="font-size: 0.8rem;">
                        Baja Lógica
                    </span>
                <?php elseif ($vehiculo['estado_alquiler'] === 'disponible'): ?>
                    <span class="badge rounded-pill px-3 py-1.5 fw-semibold border border-success border-opacity-10 text-success bg-success bg-opacity-10" style="font-size: 0.8rem;">
                        IN SERVICE
                    </span>
                <?php else: ?>
                    <span class="badge rounded-pill px-3 py-1.5 fw-semibold border border-warning border-opacity-10 text-warning bg-warning bg-opacity-10" style="font-size: 0.8rem;">
                        Alquilado
                    </span>
                <?php endif; ?>
            </div>
         
        </div>
        
        <div>
            <?php if ($vehiculo['activo'] == 0): ?>
                <div class="alert alert-warning border-0 mb-0 py-2.5 px-4 rounded-3 d-inline-flex align-items-center gap-2 shadow-sm" style="font-size: 0.95rem; font-weight: 500;">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                    <span>Este vehículo está dado de baja y no se puede modificar.</span>
                </div>
            <?php else: ?>
                <a href="<?= base_url('administracion/modificar/' . $vehiculo['id']) ?>" class="btn btn-dark px-4 py-2.5 rounded-3 fw-semibold shadow-sm d-inline-flex align-items-center gap-2" style="background-color: #0b0f19; border: none; font-size: 0.95rem;">
                    <i class="bi bi-pencil-square"></i> Modificar Vehículo
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-4 mb-5">
        
 
        <div class="col-lg-7 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex align-items-center justify-content-center p-4 p-md-5" style="min-height: 450px;">
                <?php if (!empty($vehiculo['imagen'])): ?>
                    <img src="<?= base_url('assets/images/' . $vehiculo['imagen']) ?>" alt="<?= $vehiculo['marca'] ?> <?= $vehiculo['modelo'] ?>" class="img-fluid rounded-3" style="max-height: 380px; object-fit: contain; filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.08));">
                <?php else: ?>
                    <div class="text-center py-5 text-muted opacity-50">
                        <i class="bi bi-car-front fs-1 d-block mb-3"></i>
                        Sin imagen cargada
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-5 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <div class="d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
                    <i class="bi bi-info-circle text-primary fs-5"></i>
                    <h5 class="fw-bold text-dark mb-0">Información Técnica</h5>
                </div>

                <div class="d-flex flex-column gap-3">
                

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                        <span class="text-muted small">Año</span>
                        <span class="fw-semibold text-dark"><?= $vehiculo['anio'] ?></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                        <span class="text-muted small">Combustible / Motor</span>
                        <span class="fw-semibold text-dark"><?= $vehiculo['motor'] ?></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                        <span class="text-muted small">Kilometraje actual</span>
                        <span class="fw-semibold text-dark"><?= number_format($vehiculo['kilometraje'], 0, ',', '.') ?> km</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                        <span class="text-muted small">Precio por Día</span>
                        <span class="fw-bold text-primary">$<?= number_format($vehiculo['precio_dia'], 2, ',', '.') ?></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pb-1">
                        <span class="text-muted small">Número de Plazas</span>
                        <span class="fw-semibold text-dark"><?= $vehiculo['numero_plazas'] ?> personas</span>
                    </div>

                </div>
            </div>
        </div>

    </div>

<?= $this->endSection() ?>
