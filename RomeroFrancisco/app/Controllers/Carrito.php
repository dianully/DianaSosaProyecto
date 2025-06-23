<?php

namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\CatalogoModel;

class Carrito extends BaseController
{
    protected $carritoModel;
    protected $catalogoModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->catalogoModel = new CatalogoModel();
    }

    public function index()
    {
        $idUsuario = session()->get('id_usuario');
        if (!$idUsuario) return redirect()->to('/login')->with('error', 'Debes iniciar sesión.');

        $items = $this->carritoModel->getCarritoByUser($idUsuario);
        $total = $this->carritoModel->calcularTotalCarrito($idUsuario);

        return view('templates/layout', [
            'title' => 'Carrito de Compras',
            'content' => view('pages/carrito/carrito', compact('items', 'total'))
        ]);
    }

    public function eliminar($idProducto)
    {
        $idUsuario = session()->get('id_usuario');
        $item = $this->carritoModel->isProductInCarrito($idUsuario, $idProducto);
        if ($item) {
            $producto = $this->catalogoModel->find($idProducto);
            if ($producto) {
                $nuevaCantidad = $producto['cantidad'] + $item['cantidad'];
                $this->catalogoModel->update($idProducto, ['cantidad' => $nuevaCantidad, 'activo' => ($nuevaCantidad > 0 ? 1 : 0)]);
            }
            $this->carritoModel->removeProductFromCarrito($idUsuario, $idProducto);
        }
        return redirect()->to('/carrito')->with('message', 'Producto eliminado del carrito.');
    }

    public function comprar()
{
    $idUsuario = session()->get('id_usuario');
    if (!$idUsuario) return redirect()->to('/login');

    $items = $this->carritoModel->getCarritoByUser($idUsuario);
    $total = $this->carritoModel->calcularTotalCarrito($idUsuario);

    $facturaModel = new \App\Models\FacturaCabeceraModel();
    $facturaId = $facturaModel->insert([
        'id_usuario' => $idUsuario,
        'fecha_compra' => date('Y-m-d'),
        'total' => $total,
        'activo' => 1
    ]);

    $detalleModel = new \App\Models\FacturaDetalleModel();
    foreach ($items as $item) {
        $detalleModel->insert([
            'id_factura_cabecera' => $facturaId,
            'id_producto' => $item['id_productos'],
            'cantidad' => $item['cantidad'],
            'precio' => $item['precio_venta']
        ]);

        $this->carritoModel->update($item['id_carrito'], ['activo' => 0]);
    }

    return redirect()->to('/carrito')->with('message', 'Compra realizada exitosamente.')->with('factura_id', $facturaId);
}


}
