<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarritoModel;
use App\Models\CatalogoModel;
use App\Models\GenerosModel;
use App\Models\ProductosModel;
use Config\Database;

class Catalogo extends BaseController
{
    protected $carritoModel;
    protected $catalogoModel;
    protected $generosModel;
    protected $db;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->catalogoModel = new CatalogoModel();
        $this->generosModel = new GenerosModel();
        $this->db = Database::connect();
    }

    // Vista principal tipo catálogo estético
    public function index()
    {
        return $this->catalogoInicio();
    }

    public function catalogoInicio()
    {
        $generos = $this->generosModel->where('activo', 1)->findAll();
        $productosPorGenero = [];

        foreach ($generos as $genero) {
            $productos = $this->catalogoModel
                ->where('activo', 1)
                ->where('id_generos', $genero['id_generos'])
                ->limit(3)
                ->find();

            $productosPorGenero[$genero['nombre']] = $productos;
        }

        return view('templates/layout', [
            'title' => 'Catálogo',
            'content' => view('pages/catalogo/catalogo_inicio', [
                'generos' => $generos,
                'productosPorGenero' => $productosPorGenero
            ])
        ]);
    }

    public function detalle($id_producto)
    {
        $producto = $this->catalogoModel
            ->where('id_producto', $id_producto)
            ->where('activo', 1)
            ->first();

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Producto no encontrado');
        }

        return view('templates/layout', [
            'title' => esc($producto['nombre']),
            'content' => view('pages/catalogo/detalle', ['producto' => $producto])
        ]);
    }

    public function genero($id_genero)
    {
        $genero = $this->generosModel->find($id_genero);

        if (!$genero || $genero['activo'] == 0) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Género no encontrado');
        }

        $productos = $this->catalogoModel
            ->where('activo', 1)
            ->where('id_generos', $id_genero)
            ->orderBy('fecha_alta', 'DESC')
            ->findAll();

        return view('templates/layout', [
            'title' => 'Juegos de ' . esc($genero['nombre']),
            'content' => view('pages/catalogo/catalogo_genero', [
                'productos' => $productos,
                'genero' => $genero
            ])
        ]);
    }

    public function agregar()
    {
        $idUsuario = session()->get('id_usuario');
        $idRol = session()->get('id_rol');

        if ($this->request->isAJAX()) {
            $json = $this->request->getJSON(true);
            $idProducto = $json['id_producto'] ?? null;
            $cantidad = (int)($json['cantidad'] ?? 0);
        } else {
            $idProducto = $this->request->getPost('id_producto');
            $cantidad = (int)$this->request->getPost('cantidad');
        }

        if (!$idUsuario || $idRol != 2) {
            return redirect()->back()->with('error', 'Debes iniciar sesión como cliente.');
        }

        if (!$idProducto || $cantidad < 1) {
            return redirect()->back()->with('error', 'Cantidad inválida.');
        }

        $producto = $this->catalogoModel->find($idProducto);
        if (!$producto || !$producto['activo']) {
            return redirect()->back()->with('error', 'Producto no disponible.');
        }

        if ($producto['cantidad'] < $cantidad) {
            return redirect()->back()->with('error', 'No hay suficiente stock.');
        }

        if ($this->carritoModel->addProductToCarrito($idUsuario, $idProducto, $cantidad)) {
            $this->catalogoModel->reducirStock($idProducto, $cantidad);
            return redirect()->to('/carrito')->with('success', 'Producto agregado al carrito.');
        }

        return redirect()->back()->with('error', 'Error al agregar al carrito.');
    }

    public function toggle($idProducto)
    {
        $idUsuario = session()->get('id_usuario');
        $idRol = session()->get('id_rol');

        if (!$idUsuario) {
            return $this->response->setJSON(['success' => false, 'message' => 'Debes iniciar sesión para agregar productos al carrito.']);
        }

        if ($idRol != 2) {
            return $this->response->setJSON(['success' => false, 'message' => 'Solo los clientes pueden agregar productos al carrito.']);
        }

        $producto = $this->catalogoModel->find($idProducto);

        if (!$producto || $producto['activo'] == 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'El producto no existe o no está disponible.']);
        }

        $cantidadAAgregar = 1;
        $itemEnCarrito = $this->carritoModel->isProductInCarrito($idUsuario, $idProducto);

        if ($itemEnCarrito) {
            $nuevaCantidad = $producto['cantidad'] + $itemEnCarrito['cantidad'];
            $this->carritoModel->removeProductFromCarrito($idUsuario, $idProducto);
            $this->catalogoModel->update($idProducto, [
                'cantidad' => $nuevaCantidad,
                'activo' => ($nuevaCantidad > 0 ? 1 : 0)
            ]);

            return $this->response->setJSON(['success' => true, 'action' => 'removed', 'message' => 'Producto quitado del carrito.']);
        } else {
            if ($this->catalogoModel->verificarStock($idProducto, $cantidadAAgregar)) {
                if ($this->carritoModel->addProductToCarrito($idUsuario, $idProducto, $cantidadAAgregar)) {
                    $this->catalogoModel->reducirStock($idProducto, $cantidadAAgregar);
                    return $this->response->setJSON(['success' => true, 'action' => 'added', 'message' => 'Producto agregado al carrito.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'No se pudo agregar el producto al carrito.']);
                }
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'No hay suficiente stock disponible.']);
            }
        }
    }
}
