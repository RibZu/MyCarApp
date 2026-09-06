<?php
namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\AlquilerModel;


class ClienteController extends BaseController
{
    protected $usuarioModel;
      protected $AlquilerModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->AlquilerModel = new AlquilerModel();

    }

    public function registro()
    {
        return view('Vistas_de_cliente/registro');
    }

    public function guardar_registro()
    {
        $rules = [
            'nombre_apellido' => 'required|min_length[3]|max_length[100]',
            'email'           => 'required|valid_email|is_unique[usuarios.email]',
            'password'        => 'required|min_length[6]',
            'telefono'        => 'permit_empty|max_length[20]',
            'direccion'       => 'permit_empty|max_length[150]'
        ];

        $messages = [
            'email' => [
                'is_unique' => 'Este correo ya está registrado en el sistema, incluso si la cuenta fue dada de baja.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre_apellido' => $this->request->getPost('nombre_apellido'),
            'direccion'       => $this->request->getPost('direccion'),
            'telefono'        => $this->request->getPost('telefono'),
            'email'           => $this->request->getPost('email'),
            'password'        => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'             => $this->request->getPost('rol'),
            'fecha_alta'      => date('Y-m-d'),
            'activo'          => 1
        ];

        $this->usuarioModel->insert($data);
        return redirect()->to('/login')->with('success', 'Registro exitoso. Ya puedes iniciar sesión.');
    }

   
    public function perfil()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $id = session()->get('usuario_id');
        $usuario = $this->usuarioModel->find($id);

        return view('Vistas_de_cliente/perfil', ['usuario' => $usuario]);
    }

    public function actualizar_perfil()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $id = session()->get('usuario_id');

        $rules = [
            'nombre_apellido' => 'required|min_length[3]|max_length[100]',
            'email'           => "required|valid_email|is_unique[usuarios.email,id,{$id}]",
            'telefono'        => 'permit_empty|max_length[20]',
            'direccion'       => 'permit_empty|max_length[150]'
        ];

        $messages = [
            'email' => [
                'is_unique' => 'Este correo electrónico ya pertenece a otro usuario registrado.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre_apellido' => $this->request->getPost('nombre_apellido'),
            'direccion'       => $this->request->getPost('direccion'),
            'telefono'        => $this->request->getPost('telefono'),
            'email'           => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->usuarioModel->update($id, $data);
        
        // Actualizar sesión por si se cambió el nombre
        session()->set('nombre', $data['nombre_apellido']);

        return redirect()->to('/mi-perfil')->with('success', 'Tu perfil ha sido actualizado correctamente.');
    }


    public function listar()
    {
        if (session()->get('rol') != 'admin') return redirect()->to('/')->with('msg', 'Acceso denegado. No eres Administrador.');

        $clientes = $this->usuarioModel->where('rol', 'cliente')->findAll();
        return view('Vistas_de_administrador/cliente_lista', ['clientes' => $clientes]);
    }

    public function alta()
    {
        if (session()->get('rol') != 'admin') return redirect()->to('/')->with('msg', 'Acceso denegado. No eres Administrador.');
        return view('Vistas_de_administrador/cliente_alta');
    }

    public function guardar()
    {
        if (session()->get('rol') != 'admin') return redirect()->to('/')->with('msg', 'Acceso denegado.');

        $rules = [
            'nombre_apellido' => 'required|min_length[3]',
            'email'           => 'required|valid_email|is_unique[usuarios.email]',
            'password'        => 'required|min_length[6]',
            'rol'             => 'required|in_list[admin,cliente]',
        ];

        $messages = [
            'email' => [
                'is_unique' => 'El correo electrónico ya existe. Si la persona está dada de baja, modifícala en lugar de crearla de nuevo.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre_apellido' => $this->request->getPost('nombre_apellido'),
            'direccion'       => $this->request->getPost('direccion'),
            'telefono'        => $this->request->getPost('telefono'),
            'email'           => $this->request->getPost('email'),
            'password'        => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'             => $this->request->getPost('rol'),
            'fecha_alta'      => date('Y-m-d'),
            'activo'          => 1
        ];

        $this->usuarioModel->insert($data);
        return redirect()->to('/admin/clientes')->with('success', 'Usuario registrado con éxito.');
    }

    public function editar($id)
    {
        if (session()->get('rol') != 'admin') return redirect()->to('/')->with('msg', 'Acceso denegado.');
        
        $cliente = $this->usuarioModel->find($id);
        return view('Vistas_de_administrador/cliente_modificacion', ['cliente' => $cliente]);
    }

    public function actualizar($id)
    {
        if (session()->get('rol') != 'admin') return redirect()->to('/')->with('msg', 'Acceso denegado.');

        $rules = [
            'nombre_apellido' => 'required|min_length[3]',

            'email'           => "required|valid_email|is_unique[usuarios.email,id,{$id}]" 
        ];

        $messages = [
            'email' => [
                'is_unique' => 'El correo ingresado ya pertenece a otro usuario (incluso si está dado de baja).'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre_apellido' => $this->request->getPost('nombre_apellido'),
            'direccion'       => $this->request->getPost('direccion'),
            'telefono'        => $this->request->getPost('telefono'),
            'email'           => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->usuarioModel->update($id, $data);
        return redirect()->to('/admin/clientes')->with('success', 'Datos del usuario actualizados.');
    }

    public function eliminar($id)
    {

        $usuarioAlquiler = $this->AlquilerModel->where('usuario_id', $id)
                                               ->where('estado', 'alquiler')
                                               ->first();

        if ($usuarioAlquiler) {
            return redirect()->to('/admin/clientes')->with('error', 'No se puede dar de baja al usuario porque tiene un alquiler activo.');
        }

        if (session()->get('rol') != 'admin') return redirect()->to('/')->with('msg', 'Acceso denegado.');

      
       
        
        $this->usuarioModel->update($id, ['activo' => 0]);
        return redirect()->to('/admin/clientes')->with('success', 'El usuario fue dado de baja exitosamente.');
    }
}