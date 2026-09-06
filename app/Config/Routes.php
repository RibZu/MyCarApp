<?php
use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

$routes->get('login', 'LoginController::index');
$routes->post('login/autenticar', 'LoginController::autenticar');
$routes->get('logout', 'LoginController::logout');

$routes->get('registro', 'ClienteController::registro');
$routes->post('registro/guardar', 'ClienteController::guardar_registro');
$routes->get('vehiculo/listar', 'Vehiculo::listar');

$routes->get('administracion/listar', 'Administracion::listar');
$routes->get('administracion/alta', 'Administracion::alta');
$routes->post('administracion/guardar', 'Administracion::guardar');
$routes->get('administracion/eliminar/(:num)', 'Administracion::eliminar/$1');
$routes->get('administracion/modificar/(:num)', 'Administracion::modificar/$1');
$routes->get('administracion/ver/(:num)', 'Administracion::ver/$1');
$routes->post('administracion/actualizar', 'Administracion::actualizar');

$routes->group('admin/clientes', function($routes) {
    $routes->get('/', 'ClienteController::listar');
    $routes->get('alta', 'ClienteController::alta');
    $routes->post('guardar', 'ClienteController::guardar');
    $routes->get('editar/(:num)', 'ClienteController::editar/$1');
    $routes->post('actualizar/(:num)', 'ClienteController::actualizar/$1');
    $routes->get('eliminar/(:num)', 'ClienteController::eliminar/$1');
});

$routes->get('mi-perfil', 'ClienteController::perfil');
$routes->post('mi-perfil/actualizar', 'ClienteController::actualizar_perfil');



// formulario de reserva y confirmacion
$routes->get('vehiculo/confirmar/(:num)', 'Vehiculo::confirmar/$1');
$routes->post('vehiculo/guardarReserva', 'Vehiculo::guardarReserva');

// gestion de Alquileres (Admin)
$routes->get('administracion/alquileres', 'alquilerController::listarAlquileres');
$routes->post('alquiler/aprobarAlquiler/(:num)', 'alquilerController::aprobarAlquiler/$1');
$routes->post('alquiler/procesarDevolucion/(:num)', 'alquilerController::procesarDevolucion/$1');

//dashboard reportes
$routes->get('administracion/reportes', 'AlquilerController::dashboardReportes');
$routes->post('administracion/reportes/vehiculo', 'AlquilerController::reportePorVehiculo');
$routes->post('administracion/reportes/cliente', 'AlquilerController::reportePorCliente');
$routes->get('administracion/reportes/actuales', 'AlquilerController::listadoAlquileresActuales');

?>
