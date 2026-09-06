<?= $this->extend('templates/layout') ?>

<?= $this->section('title') ?>
    Registro de Vehículo
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Registro de Vehículo</h2>
            <p class="text-muted mb-0 small">Ingresa las especificaciones operativas para añadir un nuevo activo al sistema de flota.</p>
        </div>
      
        <div class="alert alert-info border-0 d-inline-flex align-items-center gap-2 mb-0 py-2 px-3 rounded-3" style="background-color: #f1f5f9; color: #334155; font-size: 0.85rem;">
            <i class="bi bi-info-circle-fill text-primary"></i>
            <span>Todos los campos marcados con un asterisco (<strong>*</strong>) son obligatorios.</span>
        </div>
    </div>



  
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
        <form action="<?= base_url('administracion/guardar') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

           
            <div class="row border-bottom pb-4 mb-4">
                <div class="col-md-3 mb-3 mb-md-0">
                    <h5 class="fw-bold text-dark mb-1">Identificación</h5>
                    <p class="text-muted small mb-0">Detalles principales para el seguimiento de la flota y gestión del inventario.</p>
                </div>
                <div class="col-md-9">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="marca" class="form-label">Marca *</label>
                            <input type="text" name="marca" id="marca" class="form-control <?= session('errors.marca') ? 'is-invalid' : '' ?>"  placeholder="ej. Toyota" required value="<?= old('marca') ?>">

                            <?php if (session('errors.marca')) { ?>
                                        <div class="invalid-feedback">
                                             <?= session('errors.marca'); ?>
                                        </div>
                            <?php } ?>                           

                            


                        </div>
                        <div class="col-md-6">
                            <label for="modelo" class="form-label">Modelo *</label>
                            <input type="text" name="modelo" id="modelo" class="form-control <?= session('errors.modelo') ? 'is-invalid' : '' ?>" placeholder="ej. Corolla" required value="<?= old('modelo') ?>">

                            <?php if (session('errors.modelo')) { ?>
                                        <div class="invalid-feedback">
                                             <?= session('errors.modelo'); ?>
                                        </div>
                            <?php } ?>

                        </div>
                        <div class="col-md-12">
                            <label for="anio" class="form-label">Año *</label>
                            <input type="number" name="anio" id="anio" class="form-control <?= session('errors.anio') ? 'is-invalid' : '' ?>" placeholder="ej. 2024" min="1900" max="<?= date('Y') + 1 ?>" required value="<?= old('anio') ?>">

                            <?php if (session('errors.anio')) { ?>
                                        <div class="invalid-feedback">
                                             <?= session('errors.anio'); ?>
                                        </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="row border-bottom pb-4 mb-4">
                <div class="col-md-3 mb-3 mb-md-0">
                    <h5 class="fw-bold text-dark mb-1">Clasificación y Técnica</h5>
                    <p class="text-muted small mb-0">Define el rol operativo, capacidad y especificaciones mecánicas del vehículo.</p>
                </div>
                <div class="col-md-9">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="numero_plazas" class="form-label">Número de Plazas *</label>
                            <input type="number" name="numero_plazas" id="numero_plazas" class="form-control <?= session('errors.numero_plazas') ? 'is-invalid' : '' ?>" placeholder="ej. 5" min="1" max="100" required value="<?= old('numero_plazas') ?>">

                            <?php if (session('errors.numero_plazas')) { ?>
                                        <div class="invalid-feedback">
                                             <?= session('errors.numero_plazas'); ?>
                                        </div>
                            <?php } ?>



                        </div>
                        <div class="col-md-6">
                            <label for="motor" class="form-label">Motor *</label>
                            <input type="text" name="motor" id="motor" class="form-control <?= session('errors.motor') ? 'is-invalid' : '' ?>" placeholder="ej. 1.8 Híbrido, 1.6 Nafta" required value="<?= old('motor') ?>">

                            <?php if (session('errors.motor')) { ?>
                                        <div class="invalid-feedback">
                                             <?= session('errors.motor'); ?>
                                        </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">
                            <label for="kilometraje" class="form-label">Kilometraje *</label>
                            <input type="number" name="kilometraje" id="kilometraje" class="form-control <?= session('errors.kilometraje') ? 'is-invalid' : '' ?>" placeholder="ej. 15000" min="0" required value="<?= old('kilometraje') ?>">

                            <?php if (session('errors.kilometraje')) { ?>
                                        <div class="invalid-feedback">
                                             <?= session('errors.kilometraje'); ?>
                                        </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">
                            <label for="precio_dia" class="form-label">Precio por Día *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" name="precio_dia" id="precio_dia" class="form-control <?= session('errors.precio_dia') ? 'is-invalid' : '' ?>" placeholder="ej. 15000.00" min="0" required value="<?= old('precio_dia') ?>">
                                <?php if (session('errors.precio_dia')) { ?>
                                        <div class="invalid-feedback">
                                             <?= session('errors.precio_dia'); ?>
                                        </div>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="estado_alquiler" class="form-label">Estado de Disponibilidad *</label>
                            <select name="estado_alquiler" id="estado_alquiler" class="form-select" required>
                                <option value="" disabled selected>Selecciona Estado</option>
                                <option value="disponible" <?= old('estado_alquiler') === 'disponible' ? 'selected' : '' ?>>Disponible (Activo)</option>
                            </select>
                            <?php if (session('errors.estado_alquiler')) { ?>
                                        <div class="invalid-feedback">
                                             <?= session('errors.estado_alquiler'); ?>
                                        </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

      
            <div class="row pb-4 mb-3">
                <div class="col-md-3 mb-3 mb-md-0">
                    <h5 class="fw-bold text-dark mb-1">Activos Visuales *</h5>
                    <p class="text-muted small mb-0">Sube imágenes en alta resolución del vehículo para la ficha técnica.</p>
                </div>
                <div class="col-md-9">
                  
                    <div class="upload-dropzone">
                        <i class="bi bi-cloud-arrow-up-fill text-primary"></i>
                        <div class="upload-title">Haz clic para subir o arrastra y suelta</div>
                        <div class="upload-subtitle">SVG, PNG, JPG o GIF (máx. 800×400px)</div>
                        <button type="button" class="btn btn-outline-secondary btn-sm px-4 rounded-3 fw-semibold">Seleccionar Archivo</button>
                      
                        <input type="file" name="imagen" class="upload-file-input" accept="image/*" required>
                    </div>
                </div>
            </div>

           
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center border-top pt-4 gap-3 bg-light p-3 rounded-4 shadow-sm" style="margin: 0 -20px -20px -20px;">
               
                <div>
                    <a href="<?= base_url('administracion/listar') ?>" class="btn btn-link text-muted fw-bold text-decoration-none d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                        <i class="bi bi-x-lg"></i> CANCELAR
                    </a>
                </div>
                
                <div class="d-flex w-100 w-sm-auto justify-content-end gap-2">
                    <button type="submit" class="btn btn-dark px-4 py-2 fw-semibold rounded-3 d-inline-flex align-items-center gap-2" style="background-color: #0b0f19; border: none; font-size: 0.9rem;">
                        REGISTRAR VEHÍCULO <i class="bi bi-check-circle-fill"></i>
                    </button>
                </div>
            </div>


        </form>
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
<?= $this->endSection() ?>

