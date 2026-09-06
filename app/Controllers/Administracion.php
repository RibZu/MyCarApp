<?php


namespace App\Controllers;

use App\Models\VehiculoModel;

class Administracion extends BaseController
{

  protected $vehiculoModel;

    public function __construct()
    {
        $this->vehiculo = new VehiculoModel();
    }
    public function listar()
    {
         if (session()->get('rol') != 'admin') return redirect()->to('/login');
        
        $busqueda = $this->request->getGet('buscar') ?? '';
        $estado   = $this->request->getGet('estado') ?? '';

        $query = $this->vehiculo;

        if ($busqueda !== '') {
            $query = $query->groupStart()
                           ->like('marca', $busqueda)
                           ->orLike('modelo', $busqueda)
                           ->groupEnd();
        }

        if ($estado !== '') {
            if ($estado === 'baja') {
                $query = $query->where('activo', 0);
            } elseif ($estado === 'disponible') {
                $query = $query->where('activo', 1)->where('estado_alquiler', 'disponible');
            }elseif($estado === 'alquilado'){
                $query = $query->where('activo', 1)->where('estado_alquiler', 'alquilado');
            }
        }

        $vehiculos = $query->findAll();

        return view('Vistas_de_administrador/vehiculo_lista_administracion', [
            'vehiculos' => $vehiculos,
            'contar'    => count($vehiculos),
            'buscar'    => $busqueda,
            'estado'    => $estado,
            'filtrado'  => ($busqueda !== '' || $estado !== ''),
            'exito'     => session()->getFlashdata('success')
        ]);
    }


    public function alta(){

      if (session()->get('rol') != 'admin') return redirect()->to('/login');

    return view('Vistas_de_administrador/vehiculo_alta_administracion');
    
    }

    public function modificar($id){

      if (session()->get('rol') != 'admin') return redirect()->to('/login');
        $vehiculo = $this->vehiculo->find($id);

        return view('Vistas_de_administrador/vehiculo_modificacion_administracion', [
            'vehiculo' => $vehiculo
        ]);

    }

    public function ver($id){

     if (session()->get('rol') != 'admin') return redirect()->to('/login');

        $vehiculo = $this->vehiculo->find($id);

        if (! $vehiculo) {
            return redirect()->to('administracion/listar')->with('errors', ['Vehículo no encontrado.']);
        }

        return view('Vistas_de_administrador/vehiculo_ver_administracion', [
            'vehiculo' => $vehiculo
        ]);
    }


    public function guardar()
    {

          if (session()->get('rol') != 'admin') return redirect()->to('/login');

        $reglasImagen = [
            'imagen' => [
                'label'  => 'Imagen del vehículo',
                'rules'  => 'uploaded[imagen]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png,image/gif,image/webp]|max_size[imagen,2048]',
                'errors' => [
                    'uploaded' => 'La imagen del vehículo es obligatoria.',
                    'is_image' => 'El archivo seleccionado no es una imagen válida.',
                    'mime_in'  => 'El formato debe ser JPG, JPEG, PNG, GIF o WEBP.',
                    'max_size' => 'La imagen no puede pesar más de 2MB.'
                ]
            ]
        ];

        if (! $this->validate($reglasImagen)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imagen = $this->request->getFile('imagen');
        $nombreImagen = $imagen->getRandomName();
        $imagen->move(FCPATH . 'assets/images/', $nombreImagen);  

       
        $datosFormularioVehiculoAlta = [
            'marca'           => $this->request->getPost('marca'),
            'modelo'          => $this->request->getPost('modelo'),
            'anio'            => $this->request->getPost('anio'),
            'numero_plazas'   => $this->request->getPost('numero_plazas'),
            'motor'           => $this->request->getPost('motor'),
            'kilometraje'     => $this->request->getPost('kilometraje'),
            'precio_dia'      => $this->request->getPost('precio_dia'),
            'estado_alquiler' => $this->request->getPost('estado_alquiler'),
            'imagen'          => $nombreImagen,
            'activo'          => 1
        ];

     
        if ($this->vehiculo->insert($datosFormularioVehiculoAlta) === false) {

           
            if ($nombreImagen && file_exists(FCPATH . 'assets/images/' . $nombreImagen)) {
                unlink(FCPATH . 'assets/images/' . $nombreImagen);
            }

            $errores = $this->vehiculo->errors();
            return redirect()->back()->withInput()->with('errors', $errores);
        }

        return redirect()->to('administracion/listar')->with('success', '¡Vehículo registrado con éxito!');
    }

    public function eliminar($id){

             if (session()->get('rol') != 'admin') return redirect()->to('/login');
        $vehiculo = $this->vehiculo->find($id);

        if ($vehiculo) {
            if ($vehiculo['estado_alquiler'] === 'alquilado') {
                return redirect()->to('administracion/listar')->with('error', 'No se puede dar de baja el vehículo porque se encuentra alquilado.');
            }

            $vehiculo['activo'] = 0; 
            $this->vehiculo->update($id, $vehiculo);
        }

        return redirect()->to('administracion/listar')->with('success', '¡Vehículo dado de baja con éxito!');
    }

    public function actualizar(){

             if (session()->get('rol') != 'admin') return redirect()->to('/login');

        $id = $this->request->getPost('id');
        $vehiculo = $this->vehiculo->find($id);

        if (! $vehiculo) {
            return redirect()->to('administracion/listar')->with('errors', ['Vehículo no encontrado.']);
        }

        $imagen = $this->request->getFile('imagen');

        $reglasImagen = [
            'imagen' => [
                'label'  => 'Imagen del vehículo',
                'rules'  => 'uploaded[imagen]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png,image/gif,image/webp]|max_size[imagen,2048]',
                'errors' => [
                    'uploaded' => 'La imagen del vehículo es obligatoria.',
                    'is_image' => 'El archivo seleccionado no es una imagen válida.',
                    'mime_in'  => 'El formato debe ser JPG, JPEG, PNG, GIF o WEBP.',
                    'max_size' => 'La imagen no puede pesar más de 2MB.'
                ]
            ]
        ];

        if (! $this->validate($reglasImagen)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nombreImagen = $imagen->getRandomName();
        $imagen->move(FCPATH . 'assets/images/', $nombreImagen);

        if (!empty($vehiculo['imagen']) && file_exists(FCPATH . 'assets/images/' . $vehiculo['imagen'])) {
            try {
                @unlink(FCPATH . 'assets/images/' . $vehiculo['imagen']);
            } catch (\Throwable $e) {
            
            }
        }

        $datosFormularioVehiculoModificacion = [
            'marca'           => $this->request->getPost('marca'),
            'modelo'          => $this->request->getPost('modelo'),
            'anio'            => $this->request->getPost('anio'),
            'numero_plazas'   => $this->request->getPost('numero_plazas'),
            'motor'           => $this->request->getPost('motor'),
            'kilometraje'     => $this->request->getPost('kilometraje'),
            'precio_dia'      => $this->request->getPost('precio_dia'),
            'estado_alquiler' => $this->request->getPost('estado_alquiler'),
            'imagen'          => $nombreImagen // Guardar la imagen nueva (o conservar la anterior)
        ];

        if ($this->vehiculo->update($id, $datosFormularioVehiculoModificacion) === false) {
            if ($nombreImagen !== $vehiculo['imagen'] && file_exists(FCPATH . 'assets/images/' . $nombreImagen)) {
                try {
                    @unlink(FCPATH . 'assets/images/' . $nombreImagen);
                } catch (\Throwable $e) {
                
                }
            }

            $errores = $this->vehiculo->errors();
            return redirect()->back()->withInput()->with('errors', $errores);
        }

        return redirect()->to('administracion/listar')->with('success', '¡Vehículo actualizado con éxito!');
    }




}

?>