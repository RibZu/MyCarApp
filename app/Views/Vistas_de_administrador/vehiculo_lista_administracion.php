<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Gestión de Vehículos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
   
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Gestión de Vehículos</h2>
            <p class="text-muted mb-0 small"><?= $contar ?> vehículos registrados en la flota</p>
        </div>
        <div>
            <a href="<?= base_url('administracion/alta') ?>" class="btn btn-dark btn-lg px-4 py-2.5 rounded-3 fw-semibold shadow-sm d-inline-flex align-items-center gap-2" style="background-color: #0b0f19; border: none; font-size: 0.95rem;">
                <i class="bi bi-plus-circle-fill"></i> Añadir Vehículo
            </a>
        </div>
    </div>



    <!-- Sección de Filtros -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
        <form action="<?= base_url('administracion/listar') ?>" method="GET" class="row g-3 align-items-center">
            
            <div class="col-md-5 col-lg-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="buscar" class="form-control border-start-0 bg-light" placeholder="Buscar por marca o modelo..." value="<?= $buscar ?>">
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <select name="estado" class="form-select bg-light">
                    <option value="">Todos los Estados</option>
                    <option value="disponible" <?= $estado === 'disponible' ? 'selected' : '' ?>>Disponible</option>
                    <option value="baja" <?= $estado === 'baja' ? 'selected' : '' ?>>Baja</option>
                    <option value="alquilado" <?= $estado === 'alquilado' ? 'selected' : '' ?>>Alquilado</option>
                </select>
            </div>

            <div class="col-md-4 col-lg-3 d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100 fw-semibold rounded-3 d-inline-flex align-items-center justify-content-center gap-2" style="background-color: #0b0f19; border: none; font-size: 0.9rem; padding: 10px;">
                    <i class="bi bi-funnel-fill"></i> Filtrar
                </button>
                <?php if ($filtrado): ?>
                    <a href="<?= base_url('administracion/listar') ?>" class="btn btn-light border text-muted w-100 fw-semibold rounded-3 d-inline-flex align-items-center justify-content-center gap-2" style="font-size: 0.9rem; padding: 10px;">
                        <i class="bi bi-x-circle-fill"></i> Limpiar
                    </a>
                <?php endif; ?>
            </div>

        </form>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-family: 'Inter', sans-serif;">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="text-muted fw-semibold small py-3" style="letter-spacing: 0.5px;">VEHÍCULO</th>
                        <th class="text-muted fw-semibold small py-3" style="letter-spacing: 0.5px;">ESTADO</th>
                        <th class="text-muted fw-semibold small py-3" style="letter-spacing: 0.5px;">KILOMETRAJE</th>
                        <th class="text-muted fw-semibold small py-3" style="letter-spacing: 0.5px;">PRECIO / DÍA</th>
                        <th class="text-muted fw-semibold small py-3 text-end pe-4" style="letter-spacing: 0.5px;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($vehiculos)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-car-front fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                No hay vehículos registrados en la flota.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($vehiculos as $v): ?>
                            <tr class="border-bottom">
                          
                                <td>
                                    <div class="d-flex align-items-center gap-3 py-2">
                                    
                                    
                                        <div>
                                            <span class="d-block fw-bold text-dark mb-0.5" style="font-size: 0.95rem;"><?= $v['marca'] ?> <?= $v['modelo'] ?></span>
                                            <span class="text-muted small"><?= $v['anio'] ?> &bull; <?= $v['motor'] ?></span>
                                        </div>
                                    </div>
                                </td>
                                
                              
                                <td>
                                    <?php if ($v['activo'] == 0): ?>
                                        <span class="badge rounded-pill px-3 py-1.5 fw-semibold border border-danger border-opacity-10 text-danger bg-danger bg-opacity-10" style="font-size: 0.75rem;">
                                            Baja 
                                        </span>
                                    <?php elseif ($v['estado_alquiler'] === 'disponible'): ?>
                                        <span class="badge rounded-pill px-3 py-1.5 fw-semibold border border-success border-opacity-10 text-success bg-success bg-opacity-10" style="font-size: 0.75rem;">
                                            Disponible
                                        </span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill px-3 py-1.5 fw-semibold border border-warning border-opacity-10 text-warning bg-warning bg-opacity-10" style="font-size: 0.75rem;">
                                            Alquilado
                                        </span>
                                    <?php endif; ?>
                                </td>
                                
                                <td>
                                    <span class="text-dark fw-medium" style="font-size: 0.9rem;"><?= number_format($v['kilometraje'], 0, ',', '.') ?> km</span>
                                </td>
                                
                              
                                <td>
                                    <span class="text-dark fw-semibold" style="font-size: 0.9rem;">$<?= number_format($v['precio_dia'], 2, ',', '.') ?></span>
                                </td>
                                
                          
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-2">
                                       
                                        
                                      
                                        <a href="<?= base_url('administracion/ver/' . $v['id']) ?>" class="btn btn-sm btn-light border text-muted px-2.5 py-1.5 rounded-2 d-inline-flex align-items-center gap-1.5" title="Ver detalle" style="font-size: 0.825rem; font-weight: 500;">
                                            <i class="bi bi-eye-fill text-primary"></i> Ver
                                        </a>
                                       
                                        <?php if ($v['activo'] != 0): ?>
                                            <a href="<?= base_url('administracion/modificar/' . $v['id']) ?>" class="btn btn-sm btn-light border text-muted px-2.5 py-1.5 rounded-2 d-inline-flex align-items-center gap-1.5" title="Modificar" style="font-size: 0.825rem; font-weight: 500;">
                                                <i class="bi bi-pencil-fill text-warning"></i> Modificar
                                            </a>
                                            <?php if ($v['estado_alquiler'] === 'alquilado'): ?>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#errorAlquiladoModal" class="btn btn-sm btn-light border text-muted px-2.5 py-1.5 rounded-2 d-inline-flex align-items-center gap-1.5" title="Eliminar" style="font-size: 0.825rem; font-weight: 500;">
                                                    <i class="bi bi-trash-fill text-danger opacity-50"></i> Eliminar
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= base_url('administracion/eliminar/' . $v['id']) ?>" data-bs-toggle="modal" data-bs-target="#confirmarBajaModal" class="btn btn-sm btn-light border text-muted px-2.5 py-1.5 rounded-2 d-inline-flex align-items-center gap-1.5" title="Eliminar" style="font-size: 0.825rem; font-weight: 500;">
                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
      
        <div class="card-footer bg-white border-top px-4 py-3 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <span class="text-muted small">Mostrando 1-<?= $contar ?> de <?= $contar ?> vehículos</span>
        </div>
    </div>


    <?php if ($exito): ?>
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-body text-center p-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-check-lg" style="font-size: 2.5rem; line-height: 1;"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">¡Excelente!</h4>
                        <p class="text-muted mb-4" style="font-size: 0.95rem;"><?= $exito ?></p>
                        <button type="button" class="btn btn-success rounded-pill px-4 py-2 fw-semibold shadow-sm w-100" data-bs-dismiss="modal">Entendido</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Modal de Advertencia (Vehículo Alquilado) -->
    <div class="modal fade" id="errorAlquiladoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-body text-center p-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle mb-4" style="width: 80px; height: 80px;">
                        <i class="bi bi-exclamation-octagon-fill" style="font-size: 2.5rem; line-height: 1;"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">No se puede eliminar</h4>
                    <p class="text-muted mb-4" style="font-size: 0.95rem;">El vehículo se encuentra alquilado actualmente y no puede darse de baja del sistema.</p>
                    <button type="button" class="btn btn-danger rounded-pill px-4 py-2 fw-semibold shadow-sm w-100" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Baja -->
    <div class="modal fade" id="confirmarBajaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-body text-center p-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle mb-4" style="width: 80px; height: 80px;">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 2.5rem; line-height: 1;"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">¿Confirmar baja?</h4>
                    <p class="text-muted mb-4" style="font-size: 0.95rem;">¿Estás seguro de que deseas dar de baja este vehículo? Quedará guardado en el historial pero no estará disponible para nuevos alquileres.</p>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border rounded-pill px-4 py-2 fw-semibold w-100" data-bs-dismiss="modal">Cancelar</button>
                        <a id="btnConfirmarBajaAceptar" href="#" class="btn btn-danger rounded-pill px-4 py-2 fw-semibold w-100">Confirmar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
<?= $this->endSection() ?>