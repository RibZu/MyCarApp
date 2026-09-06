<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculoModel extends Model{
    protected $table = 'vehiculos';
    protected $primaryKey = 'id';

    protected $allowedFields = ['marca', 'modelo', 'anio', 'imagen' ,'numero_plazas', 'motor','kilometraje','precio_dia','estado_alquiler','activo'];

    protected $validationRules = [
        'marca'           => 'required|alpha_space|min_length[2]|max_length[50]',
        'modelo'          => 'required|min_length[1]|max_length[50]|regex_match[/^[a-zA-Z0-9\s\.\-_]+$/]',
        'anio'            => 'required|integer|exact_length[4]|greater_than[1900]|less_than[2100]',
        'numero_plazas'   => 'required|integer|greater_than[0]|less_than[100]',
        'motor'           => 'required|min_length[2]|max_length[100]|regex_match[/^[a-zA-Z0-9\s\.,\-\/]+$/]',
        'kilometraje'     => 'required|integer|greater_than_equal_to[0]|less_than[10000000]',
        'precio_dia'      => 'required|numeric|greater_than[0]',
        'estado_alquiler' => 'required|in_list[disponible,alquilado]',
    ];

    protected $validationMessages = [
        'marca' => [
            'required'    => 'La marca del vehículo es obligatoria.',
            'alpha_space' => 'La marca solo puede contener letras y espacios.',
            'min_length'  => 'La marca debe tener al menos 2 caracteres.',
            'max_length'  => 'La marca no puede superar los 50 caracteres.',
        ],
        'modelo' => [
            'required'    => 'El modelo del vehículo es obligatorio.',
            'regex_match' => 'El modelo solo puede contener letras, números, espacios, puntos, guiones y guiones bajos.',
            'min_length'  => 'El modelo debe tener al menos 1 carácter.',
            'max_length'  => 'El modelo no puede superar los 50 caracteres.',
        ],
        'anio' => [
            'required'     => 'El año del vehículo es obligatorio.',
            'integer'      => 'El año debe ser un número entero.',
            'exact_length' => 'El año debe tener exactamente 4 dígitos.',
            'greater_than' => 'El año debe ser posterior a 1900.',
            'less_than'    => 'El año debe ser anterior a 2100.',
        ],
        'numero_plazas' => [
            'required'     => 'El número de plazas es obligatorio.',
            'integer'      => 'El número de plazas debe ser un número entero.',
            'greater_than' => 'El número de plazas debe ser mayor a 0.',
            'less_than'    => 'El número de plazas no puede ser superior a 99.',
        ],
        'motor' => [
            'required'    => 'El tipo de motor es obligatorio.',
            'regex_match' => 'El motor solo puede contener letras, números, espacios, comas, puntos, barras y guiones.',
            'min_length'  => 'El motor debe tener al menos 2 caracteres.',
            'max_length'  => 'El motor no puede superar los 100 caracteres.',
        ],
        'kilometraje' => [
            'required'              => 'El kilometraje es obligatorio.',
            'integer'               => 'El kilometraje debe ser un número entero.',
            'greater_than_equal_to' => 'El kilometraje no puede ser un número negativo.',
            'less_than'             => 'El kilometraje es demasiado alto (máximo 10.000.000 km).',
        ],
        'precio_dia' => [
            'required'     => 'El precio de alquiler por día es obligatorio.',
            'numeric'      => 'El precio por día debe ser un número válido.',
            'greater_than' => 'El precio por día debe ser un valor mayor a 0.',
        ],
        'estado_alquiler' => [
            'required' => 'El estado de alquiler es obligatorio.',
            'in_list'  => 'El estado de alquiler debe ser "disponible" o "alquilado".',
        ]
    ];
}

?>