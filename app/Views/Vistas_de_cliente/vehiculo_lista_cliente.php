<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Flota Disponible
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php if (session()->getFlashdata('exito')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center gap-3" role="alert" style="background-color: #ecfdf5; color: #065f46;">
            <i class="bi bi-check-circle-fill fs-4 text-success"></i>
            <div>
                <strong class="d-block fw-bold" style="font-size: 0.95rem;">¡Reserva Registrada!</strong>
                <span style="font-size: 0.9rem;"><?= session()->getFlashdata('exito') ?></span>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="mb-4">
        <h2 class="catalog-title">Nuestra Flota Disponible</h2>
        <p class="catalog-desc">Encuentra el vehículo perfecto para tu próximo viaje. Calidad premium garantizada con MyCarApp.</p>
    </div>

    <div class="vehicles-grid">
        <?php foreach ($vehiculos as $v): ?>
            <div class="vehicle-card">
             
                <div class="card-img-wrapper">
                    <?php if (!empty($v['imagen'])): ?>
                        <img src="<?= base_url('assets/images/' . $v['imagen']) ?>" alt="<?= $v['marca'] ?> <?= $v['modelo'] ?>" class="car-image">
                    <?php else: ?>
                        <div class="car-image-placeholder text-white opacity-50"><i class="bi bi-car-front-fill fs-1"></i></div>
                    <?php endif; ?>
                    
                    <div class="card-image-overlay">
                        <span class="badge year-badge mb-1">Año <?= $v['anio'] ?></span>
                        <h4 class="car-title text-white fw-bold mb-0"><?= $v['marca'] ?> <?= $v['modelo'] ?></h4>
                    </div>
                </div>

             
                <div class="card-body-specs">
                    <div class="specs-container">
                        <div class="spec-block">
                            <i class="bi bi-people-fill"></i>
                            <span><?= $v['numero_plazas'] ?> Plazas</span>
                        </div>
                        <div class="spec-block">
                            <i class="bi bi-gear-wide-connected"></i>
                            <span><?= $v['motor'] ?></span>
                        </div>
                        <div class="spec-block">
                            <i class="bi bi-speedometer2"></i>
                            <span><?= $v['kilometraje'] ?> KM</span>
                        </div>
                        <div class="spec-block">
                                <i class="bi bi-circle-fill text-success status-dot"></i>
                                <span class="text-success fw-semibold">Disponible</span>
                        </div>
                    </div>
                </div>

            
                <div class="card-footer-pricing">
                    <div class="price-box">
                        <span class="amount">$<?= number_format($v['precio_dia'], 2, '.', '') ?></span>
                        <span class="period">POR DÍA</span>
                    </div>
                    <a href="<?= base_url('vehiculo/confirmar/' . $v['id']) ?>" class="btn btn-alquilar">Alquilar</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?= $this->endSection() ?>

