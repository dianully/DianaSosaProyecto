<?php

namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table = 'carrito';
    protected $primaryKey = 'id_carrito';
    protected $allowedFields = ['id_usuario', 'id_productos', 'cantidad', 'fecha_agregado', 'activo'];
    protected $returnType = 'array';

    public function isProductInCarrito($idUsuario, $idProducto)
    {
        return $this->where(['id_usuario' => $idUsuario, 'id_productos' => $idProducto, 'activo' => 1])->first();
    }

    public function addProductToCarrito($idUsuario, $idProducto, $cantidad)
    {
        $data = [
            'id_usuario'     => $idUsuario,
            'id_productos'   => $idProducto,
            'cantidad'       => $cantidad,
            'fecha_agregado' => date('Y-m-d H:i:s'),
            'activo'         => 1
        ];
        return $this->insert($data, false);
    }

    public function removeProductFromCarrito($idUsuario, $idProducto)
    {
        $item = $this->isProductInCarrito($idUsuario, $idProducto);
        return $item ? $this->update($item['id_carrito'], ['activo' => 0, 'cantidad' => 0]) : false;
    }

    public function getCarritoByUser($idUsuario)
    {
        return $this->select('carrito.*, productos.nombre, productos.precio_venta, productos.url_imagen')
            ->join('productos', 'productos.id_producto = carrito.id_productos')
            ->where(['carrito.id_usuario' => $idUsuario, 'carrito.activo' => 1])
            ->findAll();
    }

    public function calcularTotalCarrito($idUsuario)
    {
        $items = $this->getCarritoByUser($idUsuario);
        return array_reduce($items, fn($sum, $item) => $sum + ($item['precio_venta'] * $item['cantidad']), 0);
    }
}
