<?php
namespace App\Controllers;

use App\Models\UsuarioModel;

class LoginController extends BaseController
{
    public function index()
    {
        return view('Vistas_de_autenticacion/login');
    }

    public function autenticar()
    {
        $session = session();
        $model = new UsuarioModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->where('activo', 1)->first();

        if ($user) {
            $pass = $user['password'];
            $verify_pass = password_verify($password, $pass) || $password === $pass;
            
            if ($verify_pass) {
                $ses_data = [
                    'usuario_id' => $user['id'],
                    'nombre'     => $user['nombre_apellido'],
                    'email'      => $user['email'],
                    'rol'        => $user['rol'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                
                if ($user['rol'] == 'admin') {
                    return redirect()->to('/admin/clientes');
                } else {
                    return redirect()->to('/vehiculo/listar');
                }
            } else {
                $session->setFlashdata('msg', 'Contraseña incorrecta.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'El email no existe o la cuenta fue dada de baja.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}