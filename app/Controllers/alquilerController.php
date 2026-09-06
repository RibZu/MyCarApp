<?php
namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Models\VehiculoModel;
use App\Models\UsuarioModel;

class AlquilerController extends BaseController{

    public function listarAlquileres()  {
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado.');
        }
        $alquilerModel = new AlquilerModel();

        // Hacemos un JOIN para traer los datos del Alquiler + el Vehículo + el Cliente
        $alquileres = $alquilerModel->select('alquileres.*, vehiculos.marca, vehiculos.modelo, vehiculos.anio, vehiculos.motor, usuarios.nombre_apellido as cliente_nombre, usuarios.telefono as cliente_telefono')
            ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
            ->join('usuarios', 'usuarios.id = alquileres.usuario_id')
            ->orderBy('alquileres.fecha_desde', 'DESC')
            ->findAll();

        // Cargamos la vista pasándole los alquileres que encontramos
        return view('Vistas_de_administrador/alquiler_lista_admin', [
            'alquileres' => $alquileres
        ]);
    }

    public function aprobarAlquiler($id = null)
    {
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado. Área exclusiva de administración.');
        }


        if ($id === null) {
            // Se usa base_url() explícito para evitar problemas de ruteo
            return redirect()->to(base_url('administracion/alquileres'))->with('error', 'ID de reserva no proporcionado.');
        }

        $alquilerModel = new AlquilerModel();
        $vehiculoModel = new VehiculoModel();

        // 1. Buscamos la reserva
        $alquiler = $alquilerModel->find($id);

        if ($alquiler) {
            // 2. Actualizamos el estado de la reserva a "alquiler"
            $alquilerModel->update($id, ['estado' => 'alquiler']);

            // 3. Actualizamos el estado del vehículo para que ya no aparezca disponible
            $vehiculoModel->update($alquiler['vehiculo_id'], ['estado_alquiler' => 'alquilado']);

            return redirect()->to(base_url('administracion/alquileres'))->with('exito', 'La reserva ha sido aprobada y registrada como alquiler activo.');
        }

        return redirect()->to(base_url('administracion/alquileres'))->with('error', 'No se encontró la reserva solicitada.');
    }


    public function procesarDevolucion($id = null)  {
            if (!session()->get('isLoggedIn') || session()->get('rol') !== 'admin') {
                return redirect()->to(base_url('/'))->with('error', 'Acceso denegado. Área exclusiva de administración.');
            }

        if ($id === null) {
            return redirect()->to(base_url('administracion/alquileres'))->with('error', 'ID de alquiler no proporcionado.');
        }

        $alquilerModel = new AlquilerModel();
        $vehiculoModel = new VehiculoModel();

        $alquiler = $alquilerModel->find($id);

        if ($alquiler) {
            //fecha actual
            $fechaActual = date('Y-m-d');
            
            // Si la fecha actual es menor a la fecha_hasta, bloqueamos la devolución
            if ($fechaActual < $alquiler['fecha_hasta']) {
                return redirect()->to(base_url('administracion/alquileres'))->with('error', 'No se puede procesar la devolución antes de la fecha final pactada (' . $alquiler['fecha_hasta'] . ').');
            }

            // Si pasamos la validación, procedemos con el cierre
            $alquilerModel->update($id, ['estado' => 'finalizado']);
            $vehiculoModel->update($alquiler['vehiculo_id'], ['estado_alquiler' => 'disponible']);

            return redirect()->to(base_url('administracion/alquileres'))->with('exito', 'Devolución procesada correctamente.');
        }

        return redirect()->to(base_url('administracion/alquileres'))->with('error', 'No se encontró el alquiler.');
    }

    // Dado un vehículo, mostrar clientes que lo alquilaron
    public function reportePorVehiculo() 
    {
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado. Área exclusiva de administración.');
        }
        // 1. Capturamos el ID que viene del <select> del formulario
        $vehiculo_id = $this->request->getPost('vehiculo_id');

        // Opcional: Validar que realmente se haya enviado un ID
        if (!$vehiculo_id) {
            return redirect()->to(base_url('administracion/reportes'))->with('error', 'Por favor, seleccione un vehículo válido.');
        }

        $alquilerModel = new AlquilerModel();
        $datos['alquileres'] = $alquilerModel->select('alquileres.*, usuarios.nombre_apellido, usuarios.telefono')
            ->join('usuarios', 'usuarios.id = alquileres.usuario_id')
            ->where('alquileres.vehiculo_id', $vehiculo_id)
            ->findAll();
            
        return view('Vistas_de_administrador/reporte_vehiculo', $datos);
    }

    // Dado un cliente, historial de vehículos alquilados
    public function reportePorCliente() 
    {
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado. Área exclusiva de administración.');
        }
        // 1. Capturamos el ID que viene del <select> del formulario
        $usuario_id = $this->request->getPost('usuario_id');

        // Opcional: Validar que realmente se haya enviado un ID
        if (!$usuario_id) {
            return redirect()->to(base_url('administracion/reportes'))->with('error', 'Por favor, seleccione un cliente válido.');
        }

        $alquilerModel = new AlquilerModel();
        $datos['alquileres'] = $alquilerModel->select('alquileres.*, vehiculos.marca, vehiculos.modelo')
            ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
            ->where('alquileres.usuario_id', $usuario_id)
            ->findAll();
            
        return view('Vistas_de_administrador/reporte_cliente', $datos);
    }

    
    public function listadoAlquileresActuales() {
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado. Área exclusiva de administración.');
        }
        $alquilerModel = new AlquilerModel();
        $datos['alquileres'] = $alquilerModel->select('alquileres.*, vehiculos.marca, vehiculos.modelo, usuarios.nombre_apellido')
            ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
            ->join('usuarios', 'usuarios.id = alquileres.usuario_id')
            ->where('alquileres.estado', 'alquiler')
            ->findAll();
            
        return view('Vistas_de_administrador/reporte_actuales', $datos);
    }

    // Dashboard para seleccionar reportes
    public function dashboardReportes()  {
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado. Área exclusiva de administración.');
        }

        $vehiculoModel = new VehiculoModel();
        $usuarioModel = new UsuarioModel();

        // Traemos los datos para llenar los selectores del formulario
        $datos = [
            // Asumiendo que guardas el rol como 'cliente' en tu BD
            'clientes'  => $usuarioModel->where('rol', 'cliente')->findAll(), 
            'vehiculos' => $vehiculoModel->findAll()
        ];

        return view('Vistas_de_administrador/reportes_admin', $datos);
    }
}   