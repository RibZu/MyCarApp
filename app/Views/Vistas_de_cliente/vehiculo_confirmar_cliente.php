<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Confirmar Reserva
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<div class="row justify-content-center" style="font-family: 'Inter', sans-serif;">
    <div class="col-12">
        
        <div class="mb-4">
            <a href="<?= base_url('vehiculo/listar') ?>" class="text-decoration-none text-muted small fw-semibold">
                <i class="bi bi-arrow-left"></i> Volver al catálogo
            </a>
            <h2 class="fw-bold text-dark mt-2 mb-1" style="letter-spacing: -0.5px;">Confirmación de Reserva</h2>
            <p class="text-muted small">Revisa el vehículo, selecciona tus fechas en el calendario central y procesa tu ticket a la derecha.</p>
        </div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="row g-3">
            
            <div class="col-xl-3 col-lg-4 col-md-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100">
                    <div style="position: relative; height: 180px; background-color: #f8fafc;">
                        <?php if (!empty($auto['imagen'])): ?>
                            <img src="<?= base_url('assets/images/' . $auto['imagen']) ?>" alt="<?= $auto['marca'] ?>" class="w-100 h-100" style="object-fit: cover;">
                        <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-secondary opacity-25">
                                <i class="bi bi-car-front-fill" style="font-size: 3.5rem;"></i>
                            </div>
                        <?php endif; ?>
                        <span class="badge bg-dark px-3 py-2 rounded-pill shadow-sm" style="position: absolute; top: 15px; left: 15px; font-size: 0.75rem;">Año <?= $auto['anio'] ?></span>
                    </div>
                    
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-dark mb-3"><?= esc($auto['marca']) ?> <span class="text-secondary fw-normal"><?= esc($auto['modelo']) ?></span></h4>
                        
                        <div class="row g-2 text-muted small border-bottom pb-3 mb-3">
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="bi bi-people-fill text-primary"></i>
                                <span><?= $auto['numero_plazas'] ?> Plazas</span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="bi bi-fuel-pump-fill text-primary"></i>
                                <span><?= esc($auto['motor']) ?></span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="bi bi-speedometer2 text-primary"></i>
                                <span><?= number_format($auto['kilometraje']) ?> km</span>
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="bi bi-shield-check text-primary"></i>
                                <span>Garantía</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3">
                            <span class="text-muted small fw-semibold">Precio por día</span>
                            <span class="fs-5 fw-bold text-dark">$<?= number_format($auto['precio_dia'], 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-5 col-md-12">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                        <h5 class="fw-bold text-dark m-0">Calendario de Disponibilidad</h5>
                        <div class="d-flex gap-2 small">
                            <span><i class="bi bi-square-fill text-danger opacity-25 me-1"></i> Reservado</span>
                            <span><i class="bi bi-square-fill text-primary opacity-25 me-1"></i> Selección</span>
                        </div>
                    </div>
                    
                    <div id="calendar"></div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Tu Ticket</h5>
                       <form action="<?= base_url('vehiculo/guardarReserva') ?>" method="POST" id="form-reserva" data-precio-dia="<?= $auto['precio_dia'] ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="vehiculo_id" value="<?= $auto['id'] ?>">

                            <div class="mb-3">
                                <label for="fecha_desde" class="form-label text-muted fw-semibold small m-1">Fecha Inicio</label>
                                <input type="text" name="fecha_desde" id="fecha_desde" class="form-control bg-light border-0 py-2 rounded-3 text-dark fw-semibold text-center" readonly placeholder="-- / -- / ----" value="<?= old('fecha_desde') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_hasta" class="form-label text-muted fw-semibold small m-1">Fecha Fin</label>
                                <input type="text" name="fecha_hasta" id="fecha_hasta" class="form-control bg-light border-0 py-2 rounded-3 text-dark fw-semibold text-center" readonly placeholder="-- / -- / ----" value="<?= old('fecha_hasta') ?>" required>
                            </div>

                            <div class="mb-4">
                                <label for="cantidad_dias" class="form-label text-muted fw-semibold small m-1">Total de Días</label>
                                <input type="number" name="cantidad_dias" id="cantidad_dias" class="form-control bg-light border-0 py-2 rounded-3 text-dark fw-semibold text-center" readonly placeholder="0" value="<?= old('cantidad_dias') ?>" required>
                            </div>

                            <div class="p-3 rounded-4 mb-4 border" style="background-color: #fafafa; border-style: dashed !important;">
                                <div class="d-flex justify-content-between mb-2 text-muted small">
                                    <span>Duración total:</span>
                                    <span id="lbl-dias" class="fw-semibold">0 días</span>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                    <span class="fw-bold text-dark">Precio Estimado:</span>
                                    <span id="lbl-total" class="fw-extrabold text-primary fs-5">$0.00</span>
                                </div>
                            </div>
                    </div>

                        <button type="submit" class="btn btn-dark w-100 py-3 rounded-3 fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2 mt-3" style="background-color: #0b0f19; border: none;">
                            CONFIRMAR RESERVA <i class="bi bi-arrow-right-circle-fill"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>


<script>
    window.eventosOcupados = <?= $eventosOcupados ?>;
</script>
<script src="<?= base_url('assets/js/calendario-reserva.js') ?>"></script>

<?= $this->endSection() ?>