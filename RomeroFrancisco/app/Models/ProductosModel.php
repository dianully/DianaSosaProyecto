<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductosModel extends Model
{
    protected $table            = 'productos';
    protected $primaryKey       = 'id_producto';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Atributos de la tabla productos
    protected $allowedFields = ['nombre', 'precio_venta', 'descripcion', 'cantidad', 'url_imagen', 'id_generos', 'activo'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
    'nombre'        => 'required|min_length[3]|max_length[100]',
    'precio_venta'  => 'required|numeric|greater_than[0]',
    'descripcion'   => 'permit_empty|max_length[500]',
    'cantidad'      => 'required|integer|greater_than_equal_to[0]',
    'url_imagen'    => 'permit_empty|max_length[500]', // Solo limitamos la longitud del nombre del archivo
    'id_generos'    => 'required|integer|is_not_unique[generos.id_generos]',
    'activo'        => 'permit_empty|integer|in_list[0,1]'
];

protected $validationMessages = [
    'nombre' => [
        'required'   => 'El nombre del producto es obligatorio.',
        'min_length' => 'El nombre debe tener al menos 3 caracteres.',
        'max_length' => 'El nombre no puede exceder los 100 caracteres.'
    ],
    'precio_venta' => [
        'required'    => 'El precio de venta es obligatorio.',
        'numeric'     => 'El precio de venta debe ser un valor numérico.',
        'greater_than'=> 'El precio de venta debe ser mayor que cero.'
    ],
    'cantidad' => [
        'required'              => 'La cantidad del producto es obligatoria.',
        'integer'               => 'La cantidad debe ser un número entero.',
        'greater_than_equal_to' => 'La cantidad no puede ser negativa.'
    ],
    'url_imagen' => [
        'max_length' => 'El nombre del archivo no puede exceder los 500 caracteres.'
    ],
    'id_generos' => [
        'required'      => 'El género es obligatorio.',
        'integer'       => 'El ID del género debe ser un número entero.',
        'is_not_unique' => 'El género seleccionado no existe.'
    ],
    'activo' => [
        'integer' => 'El estado activo debe ser un número entero (0 o 1).',
        'in_list' => 'El estado activo debe ser 0 o 1.'
    ]
];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}