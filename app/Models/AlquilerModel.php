<?php

namespace App\Models;

use CodeIgniter\Model;

class AlquilerModel extends Model
{
    protected $table            = 'alquileres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['vehiculo_id', 'usuario_id', 'fecha_desde', 'cantidad_dias', 'fecha_hasta', 'estado'];

    // Reglas de validación nativas siguiendo las pautas de la clase
    protected $validationRules = [
        'vehiculo_id'   => 'required|integer',
        'usuario_id'    => 'required|integer',
        'fecha_desde'   => 'required|valid_date[Y-m-d]',
        'cantidad_dias' => 'required|integer|greater_than[0]',
        'fecha_hasta'   => 'required|valid_date[Y-m-d]',
        'estado'        => 'required|in_list[reserva,alquiler,finalizado]'
    ];

    protected $validationMessages = [
        'fecha_desde' => [
            'required'   => 'La fecha de inicio es obligatoria.',
            'valid_date' => 'Formato de fecha inválido.'
        ],
        'cantidad_dias' => [
            'required'     => 'La cantidad de días es obligatoria.',
            'greater_than' => 'Debes alquilar por al menos 1 día.'
        ]
    ];
}