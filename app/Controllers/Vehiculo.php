<?php


namespace App\Controllers;

use App\Models\VehiculoModel;
use App\Models\AlquilerModel;

class Vehiculo extends BaseController   {
    protected $vehiculoModel;

    public function __construct()
    {
        $this->vehiculo= new VehiculoModel();
    }

    public function listar()
    {
        $vehiculos = $this->vehiculo->where('activo',1)->findAll();

    
        return view('Vistas_de_cliente/vehiculo_lista_cliente', [
            'vehiculos' => $vehiculos
        ]);

    }
    

    // Mostrar formulario de confirmación con el auto seleccionado
    public function confirmar($id = null) {
       
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'cliente') {
            return redirect()->to(base_url('/vehiculo/listar'))->with('error', 'Acción denegada. Solo los clientes registrados pueden realizar reservas.');
        }

        
        if ($id === null) {
            return redirect()->to(base_url('vehiculo/listar'));
        }

        $auto = $this->vehiculo->where('id', $id)->where('activo', 1)->first();

        if (!$auto) {
            return redirect()->to(base_url('vehiculo/listar'));
        }
        $alquilerModel = new \App\Models\AlquilerModel();

        // Buscamos todas las reservas activas de este auto (no finalizadas)
        $alquileresPrevios = $alquilerModel->where('vehiculo_id', $id)
                                        ->where('estado !=', 'finalizado')
                                        ->findAll();

        // Formateamos el arreglo para FullCalendar
        $eventosOcupados = [];
        foreach ($alquileresPrevios as $alquiler) {
            // Sumamos 1 día a fecha_hasta para que FullCalendar pinte el último día inclusive
            $dateHasta = new \DateTime($alquiler['fecha_hasta']);
            $dateHasta->modify('+1 day');

            $eventosOcupados[] = [
                'title'           => 'RESERVADO',
                'start'           => $alquiler['fecha_desde'],
                'end'             => $dateHasta->format('Y-m-d'), 
                'backgroundColor' => '#fee2e2',
                'textColor'       => '#991b1b',
                'borderColor'     => '#fee2e2',
                'allDay'          => true
            ];
        }

        // Enviamos todo estructurado a tu vista
        return view('Vistas_de_cliente/vehiculo_confirmar_cliente', [
            'auto'            => $auto,
            'eventosOcupados' => json_encode($eventosOcupados) // Lo pasamos codificado en JSON
        ]);
    }

    

    // ACCIÓN POST: Procesar y validar la reserva en la base de datos
    public function guardarReserva()
    {
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'cliente') {
            return redirect()->to(base_url('/login'))->with('error', 'Acción denegada. Solo los clientes registrados pueden realizar reservas.');
        }
        $alquilerModel = new AlquilerModel();

        // Recuperar ID del vehículo de manera segura
        $vehiculo_id = $this->request->getPost('vehiculo_id');
        $auto = $this->vehiculo->find($vehiculo_id);

        if (!$auto) {
            return redirect()->to(base_url('vehiculo/listar'));
        }
        $usuario_id = session()->get('usuario_id'); 

        if (!$usuario_id) {
            return redirect()->to(base_url('login'))->with('error', 'La sesión ha expirado. Por favor, inicia sesión nuevamente.');
        }

        $fecha_desde = $this->request->getPost('fecha_desde');
        $cantidad_dias = intval($this->request->getPost('cantidad_dias'));

        // Calcular dinámicamente la fecha_hasta sumando los días a la fecha_desde
        $fecha_hasta = '';
        if (!empty($fecha_desde) && $cantidad_dias > 0) {
            $date = new \DateTime($fecha_desde);
            $diasAModificar = $cantidad_dias - 1;
            $date->modify("+$diasAModificar days");
            $fecha_hasta = $date->format('Y-m-d');
        } else {
            return redirect()->back()->withInput()->with('errors', ['Debe seleccionar un rango de fechas válido en el calendario.']);
        }


        // proteccion en caso del calendario sea manipulado y se envie una fecha no disponible
        $choqueReserva = $alquilerModel->where('vehiculo_id', $vehiculo_id)
                                      ->where('estado !=', 'finalizado') // Ignoramos alquileres viejos o devueltos
                                      ->where('fecha_desde <=', $fecha_hasta)
                                      ->where('fecha_hasta >=', $fecha_desde)
                                      ->first();
        if ($choqueReserva) {
            // Frenamos el proceso si las fechas se pisan en el servidor
            return redirect()->back()->withInput()->with('errors', ['Lo sentimos, este vehículo ya ha sido reservado o alquilado por otro usuario en el rango de fechas seleccionado.']);
        }



        $datosReserva = [
            'vehiculo_id'   => $vehiculo_id,
            'usuario_id'    => $usuario_id,
            'fecha_desde'   => $fecha_desde,
            'cantidad_dias' => $cantidad_dias,
            'fecha_hasta'   => $fecha_hasta,
            'estado'        => 'reserva'
        ];

        // Intentar guardar usando las validaciones del AlquilerModel
        if ($alquilerModel->insert($datosReserva) === false) {
            // Si falla la validación, volvemos enviando los errores y repoblando con old()
            return redirect()->back()->withInput()->with('errors', $alquilerModel->errors());
        }

        return redirect()->to(base_url('vehiculo/listar'))->with('exito', '¡Tu reserva se ha registrado con éxito!');
    }



    

                                                                                                                                                                                                           

}




?>