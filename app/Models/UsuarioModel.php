<?php
namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';

  
    protected $allowedFields = ['nombre_apellido', 'direccion', 'telefono', 'email', 'password', 'rol', 'fecha_alta', 'activo'];
}
?>
