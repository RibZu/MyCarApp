<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - MyCarApp</title>
   
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🚗</text></svg>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
    <link rel="stylesheet" href="<?= base_url('assets/css/ListaVehiculos.css') ?>">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    <header class="bg-white border-bottom sticky-top py-2 shadow-sm">
        <div class="container-xl d-flex justify-content-between align-items-center">
          
            <a href="<?= base_url() ?>" class="navbar-brand fs-4 fw-extrabold text-primary" style="font-family: 'Inter', sans-serif; letter-spacing: -0.5px;">
                My<span class="text-secondary-emphasis">CarApp</span>
            </a>
            
            <nav class="nav header-nav d-none d-md-flex align-items-center gap-4">
                <a href="<?= base_url() ?>" class="nav-link <?= uri_string() == '' ? 'active fw-semibold text-primary' : 'text-secondary fw-medium hover-primary' ?>">Inicio</a>
                
                <?php if (session()->get('isLoggedIn')): ?>
                    
                    <?php if (session()->get('rol') === 'admin'): ?>
                        <a href="<?= base_url('administracion/listar') ?>" class="nav-link <?= strpos(uri_string(), 'administracion/listar') === 0 ? 'active fw-semibold text-primary' : 'text-secondary fw-medium hover-primary' ?>">
                            <i class="bi bi-car-front-fill"></i> Panel Vehículos
                        </a>
                        <a href="<?= base_url('admin/clientes') ?>" class="nav-link <?= strpos(uri_string(), 'admin/clientes') === 0 ? 'active fw-semibold text-primary' : 'text-secondary fw-medium hover-primary' ?>">
                            <i class="bi bi-people-fill"></i> Panel Clientes
                        </a>
                        
                        <a href="<?= base_url('administracion/alquileres') ?>" class="nav-link <?= strpos(uri_string(), 'administracion/alquileres') === 0 ? 'active fw-semibold text-primary' : 'text-secondary fw-medium hover-primary' ?>">
                            <i class="bi bi-card-checklist"></i> Gestión Alquileres
                        </a>
                        <a href="<?= base_url('administracion/reportes') ?>" class="nav-link <?= strpos(uri_string(), 'administracion/reportes') === 0 ? 'active fw-semibold text-primary' : 'text-secondary fw-medium hover-primary' ?>">
                            <i class="bi bi-bar-chart-fill"></i> Reportes
                        </a>
                        
                    <?php else: ?>
                        <a href="<?= base_url('vehiculo/listar') ?>" class="nav-link <?= strpos(uri_string(), 'vehiculo/listar') === 0 ? 'active fw-semibold text-primary' : 'text-secondary fw-medium hover-primary' ?>">
                            <i class="bi bi-car-front"></i> Ver Catálogo de Flota
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?= base_url('mi-perfil') ?>" class="nav-link <?= strpos(uri_string(), 'mi-perfil') === 0 ? 'active fw-semibold text-primary' : 'text-secondary fw-medium hover-primary' ?>">
                        <i class="bi bi-person-circle"></i> Mi Perfil
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('vehiculo/listar') ?>" class="nav-link <?= strpos(uri_string(), 'vehiculo/listar') === 0 ? 'active fw-semibold text-primary' : 'text-secondary fw-medium hover-primary' ?>">Flota Disponible</a>
                <?php endif; ?>
            </nav>

            <div>
                <?php if (session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger rounded-pill px-4 fw-semibold shadow-sm">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="flex-fill py-5">
        <div class="container-xl">
            <?php if(session()->getFlashdata('msg')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm fw-bold text-center border-0 border-start border-danger border-5 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('msg') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container-xl d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
            <div>
                <span class="fw-bold text-primary fs-5">My<span class="text-secondary-emphasis">CarApp</span></span>
                <p class="text-muted small mb-0 mt-1">Copyright &copy; 2026 MyCarApp</p>
            </div>
            
            <div class="d-flex flex-column align-items-center align-items-md-end gap-2">
                <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Desarrollado por</span>
                <div class="d-flex flex-wrap justify-content-center justify-content-md-end gap-2">
                    <!-- Emanuel Gonzalez -->
                    <div class="d-inline-flex align-items-center bg-light border rounded-pill px-3 shadow-sm" style="padding-top: 6px; padding-bottom: 6px;">
                        <div class="rounded-circle bg-dark d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                            <i class="bi bi-person-fill text-white" style="font-size: 0.85rem;"></i>
                        </div>
                        <span class="fw-semibold text-secondary-emphasis" style="font-size: 0.9rem;">Emanuel Gonzalez</span>
                    </div>
                    
                    <!-- Ismael Farias -->
                    <div class="d-inline-flex align-items-center bg-light border rounded-pill px-3 shadow-sm" style="padding-top: 6px; padding-bottom: 6px;">
                        <div class="rounded-circle bg-dark d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                            <i class="bi bi-person-fill text-white" style="font-size: 0.85rem;"></i>
                        </div>
                        <span class="fw-semibold text-secondary-emphasis" style="font-size: 0.9rem;">Ismael Farias</span>
                    </div>
                    
                    <!-- Simon Riberi -->
                    <div class="d-inline-flex align-items-center bg-light border rounded-pill px-3 shadow-sm" style="padding-top: 6px; padding-bottom: 6px;">
                        <div class="rounded-circle bg-dark d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                            <i class="bi bi-person-fill text-white" style="font-size: 0.85rem;"></i>
                        </div>
                        <span class="fw-semibold text-secondary-emphasis" style="font-size: 0.9rem;">Simon Riberi</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- AVISO DE ÉXITO ---
        <?php if (session()->getFlashdata('exito')): ?>
            Swal.fire({
                icon: 'success',
                title: '¡Operación Exitosa!',
                text: '<?= esc(session()->getFlashdata('exito'), 'js') ?>',
                confirmButtonColor: '#0b0f19', 
                timer: 3500,
                timerProgressBar: true
            });
        <?php endif; ?>

        // --- AVISO DE ERROR SIMPLE ---
        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Acceso Denegado / Error',
                text: '<?= esc(session()->getFlashdata('error'), 'js') ?>',
                confirmButtonColor: '#d33'
            });
        <?php endif; ?>

        // --- AVISO DE ERRORES DE VALIDACIÓN ---
        <?php if (session()->getFlashdata('errors')): ?>
            // Construimos una lista HTML limpia para mostrar todos los errores juntos
            let listaErrores = '<ul style="text-align: left; margin-bottom: 0; font-size: 0.95rem;">';
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                listaErrores += '<li class="mb-1"><?= esc($error, 'js') ?></li>';
            <?php endforeach; ?>
            listaErrores += '</ul>';

            Swal.fire({
                icon: 'warning',
                title: 'Revisa los datos ingresados',
                html: listaErrores,
                confirmButtonColor: '#f8bb86',
                confirmButtonText: 'Corregir datos'
            });
        <?php endif; ?>
        
    });
</script>
</body>
</html>