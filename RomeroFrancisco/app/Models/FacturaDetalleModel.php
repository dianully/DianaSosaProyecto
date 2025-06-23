<?php

namespace App\Models;

use CodeIgniter\Model;

class FacturaDetalleModel extends Model
{
    protected $table = 'factura_detalle';
    protected $primaryKey = 'id_factura_detalle';
    protected $allowedFields = ['id_factura_cabecera', 'id_producto', 'cantidad', 'precio'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
}
