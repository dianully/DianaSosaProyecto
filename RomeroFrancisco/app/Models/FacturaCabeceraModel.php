<?php

namespace App\Models;

use CodeIgniter\Model;

class FacturaCabeceraModel extends Model
{
    protected $table = 'factura_cabecera';
    protected $primaryKey = 'id_factura_cabecera';
    protected $allowedFields = ['id_usuario', 'fecha_compra', 'total', 'activo'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
}
