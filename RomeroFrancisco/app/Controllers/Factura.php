<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FacturaCabeceraModel;
use App\Models\FacturaDetalleModel;

class Factura extends BaseController
{
    protected $facturaModel;
    protected $detalleModel;

    public function __construct()
    {
        $this->facturaModel = new FacturaCabeceraModel();
        $this->detalleModel = new FacturaDetalleModel();
    }

    public function ver($idFactura)
    {
        $factura = $this->facturaModel->find($idFactura);

        $detalles = $this->detalleModel
            ->select('factura_detalle.*, productos.nombre as producto_nombre')
            ->join('productos', 'productos.id_producto = factura_detalle.id_producto')
            ->where('factura_detalle.id_factura_cabecera', $idFactura)
            ->findAll();

        return view('templates/layout', [
            'title' => 'Factura',
            'content' => view('pages/factura/ver', compact('factura', 'detalles'))
        ]);
    }
}
