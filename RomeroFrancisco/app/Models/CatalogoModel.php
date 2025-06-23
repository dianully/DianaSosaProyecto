<?php

namespace App\Models;

use CodeIgniter\Model;

class CatalogoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $allowedFields = ['id_producto', 'nombre', 'precio_venta', 'cantidad', 'url_imagen', 'id_generos', 'activo'];
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField = 'fecha_alta';
    protected $updatedField = 'fecha_edit';

    public function verificarStock($idProducto, $cantidad)
    {
        $producto = $this->find($idProducto);
        return $producto && $producto['activo'] && $producto['cantidad'] >= $cantidad;
    }

    public function reducirStock($idProducto, $cantidad)
    {
        $producto = $this->find($idProducto);
        if ($producto && $producto['cantidad'] >= $cantidad) {
            $nuevaCantidad = $producto['cantidad'] - $cantidad;
            $this->update($idProducto, ['cantidad' => $nuevaCantidad, 'activo' => $nuevaCantidad > 0 ? 1 : 0]);
            return true;
        }
        return false;
    }
}
