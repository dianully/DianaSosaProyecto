<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\GenerosModel;

class Productos extends BaseController
{
    protected $productos;
    protected $generos;
    protected $helpers = ['form', 'url'];

    public function __construct()
    {
        $this->productos = new ProductosModel();
        $this->generos = new GenerosModel();

        // Inicializar la sesión para asegurar que esté disponible
        $session = session();

        // Restringir acceso solo a administradores
        if (!$session->has('id_rol') || $session->get('id_rol') != 1) {
            $session->setFlashdata('error', 'Debes ser administrador para acceder a esta página.');
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Acceso denegado'); // Alternativa más estricta
            // O usar redirección: return redirect()->to('/ingresar');
        }
    }

    // Listar productos activos
    public function index($activo = 1)
    {
        // Inicializar la consulta
        $productos = $this->productos->where('activo', $activo);

        // Obtener y aplicar filtros
        $search = $this->request->getGet('search');
        $genres = $this->request->getGet('genres');
        $minPrice = $this->request->getGet('min_price') ? floatval($this->request->getGet('min_price')) : null;
        $maxPrice = $this->request->getGet('max_price') ? floatval($this->request->getGet('max_price')) : null;

        if ($search) {
            $productos->like('nombre', $search);
        }
        if ($genres && is_array($genres) && !empty($genres)) {
            $productos->whereIn('id_generos', $genres);
        }
        if ($minPrice !== null) {
            $productos->where('precio_venta >=', $minPrice);
        }
        if ($maxPrice !== null) {
            $productos->where('precio_venta <=', $maxPrice);
        }

        // Ejecutar la consulta
        $productos = $productos->findAll();
        
        // Obtener géneros para los filtros
        $generos = $this->generos->where('activo', 1)->findAll();
        $generosMap = $this->getGenerosMap($activo);
        
        // Pasar datos a la vista, incluyendo los filtros seleccionados
        $selectedGenres = $genres ? $genres : [];
        $data = [
            'datos' => $productos,
            'generosMap' => $generosMap,
            'generos' => $generos,
            'selectedGenres' => $selectedGenres,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice
        ];
        
        return $this->renderView('Productos', 'pages/productos/productos', $data);
    }

    // Listar productos eliminados
    public function eliminados($activo = 0)
    {
        $productos = $this->productos->where('activo', $activo)->findAll();
        $generosMap = $this->getGenerosMap();
        return $this->renderView('Productos Eliminados', 'pages/productos/eliminados', ['datos' => $productos, 'generosMap' => $generosMap]);
    }

    // Mostrar formulario para agregar producto
    public function nuevo()
    {
        $generos = $this->generos->where('activo', 1)->findAll();
        return $this->renderView('Agregar Producto', 'pages/productos/nuevo', ['generos' => $generos]);
    }

    // Guardar nuevo producto
    public function insertar()
    {
        $postData = $this->request->getPost();
        $imagenFile = $this->request->getFile('url_imagen');

        if (!$this->validateAndSaveProduct($postData, $imagenFile, true)) {
            $generos = $this->generos->where('activo', 1)->findAll();
            return $this->renderView('Agregar Producto', 'pages/productos/nuevo', [
                'generos' => $generos,
                'validation' => \Config\Services::validation()
            ]);
        }

        return redirect()->to(base_url('Productos'))->with('success', 'Producto agregado correctamente.');
    }

    // Mostrar formulario para editar producto
    public function editar($id)
    {
        $producto = $this->productos->where('id_producto', $id)->first();
        if (empty($producto)) {
            return redirect()->to(base_url('Productos'))->with('error', 'Producto no encontrado.');
        }

        $generos = $this->generos->where('activo', 1)->findAll();
        $data = [
            'datos' => $producto,
            'generos' => $generos,
            'imagenActual' => $producto['url_imagen'] ? base_url('public/assets/img/productos_img/' . $producto['url_imagen']) : null
        ];
        return $this->renderView('Editar Producto', 'pages/productos/editar', $data);
    }

    // Actualizar producto existente
    public function actualizar()
    {
        $id_producto = $this->request->getPost('id_producto');
        $postData = $this->request->getPost();
        $imagenFile = $this->request->getFile('url_imagen');
        $productoExistente = $this->productos->find($id_producto);

        if (!$this->validateAndSaveProduct($postData, $imagenFile, false, $id_producto, $productoExistente)) {
            $generos = $this->generos->where('activo', 1)->findAll();
            return $this->renderView('Editar Producto', 'pages/productos/editar', [
                'datos' => $productoExistente,
                'generos' => $generos,
                'validation' => \Config\Services::validation()
            ]);
        }

        return redirect()->to(base_url('Productos'))->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar producto (marcar como inactivo)
    public function eliminar($id)
    {
        $this->productos->update($id, ['activo' => 0]);
        return redirect()->to(base_url('Productos'))->with('success', 'Producto eliminado correctamente.');
    }

    // Reingresar producto (marcar como activo)
    public function reingresar($id)
    {
        $this->productos->update($id, ['activo' => 1]);
        return redirect()->to(base_url('Productos'))->with('success', 'Producto reingresado correctamente.');
    }

    // Método privado para renderizar vistas
    private function renderView($title, $view, $data = [])
    {
        return view('templates/layout', [
            'title' => $title,
            'content' => view($view, $data)
        ]);
    }

    // Método privado para obtener el mapeo de géneros
    private function getGenerosMap($activo = null)
    {
        $query = $this->generos->select('id_generos, nombre');
        if ($activo !== null) {
            $query->where('activo', $activo);
        }
        $generosList = $query->findAll();
        $generosMap = [];
        foreach ($generosList as $genero) {
            $generosMap[$genero['id_generos']] = $genero['nombre'];
        }
        return $generosMap;
    }

    // Método privado para validar y guardar productos
    private function validateAndSaveProduct($postData, $imagenFile, $isInsert = true, $id = null, $existingProduct = null)
    {
        // Depuración
        log_message('debug', 'Datos recibidos: ' . print_r($postData, true));
        if ($imagenFile) {
            log_message('debug', 'Archivo recibido: ' . $imagenFile->getName() . ', ¿Válido? ' . ($imagenFile->isValid() ? 'Sí' : 'No'));
        }

        // Validar datos
        $dataToValidate = $postData;
        $dataToValidate['url_imagen'] = $imagenFile ? $imagenFile->getName() : ($existingProduct['url_imagen'] ?? null);
        if (!$this->productos->validate($dataToValidate)) {
            log_message('error', 'Validación falló: ' . print_r(\Config\Services::validation()->getErrors(), true));
            return false;
        }

        $nombreImagen = $existingProduct['url_imagen'] ?? null;
        if ($imagenFile && $imagenFile->isValid() && !$imagenFile->hasMoved()) {
            // Validación manual de la imagen
            if ($imagenFile->getSize() > 2048 * 1024) {
                \Config\Services::validation()->setError('url_imagen', 'La imagen excede el tamaño máximo de 2MB.');
                return false;
            }
            $mimeType = $imagenFile->getMimeType();
            if (!in_array($mimeType, ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'])) {
                \Config\Services::validation()->setError('url_imagen', 'Tipo de archivo no permitido. Use JPG, JPEG, PNG o GIF.');
                return false;
            }
            $extension = $imagenFile->getClientExtension();
            if (!in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                \Config\Services::validation()->setError('url_imagen', 'Extensión no permitida. Use JPG, JPEG, PNG o GIF.');
                return false;
            }

            $nombreImagen = $imagenFile->getRandomName();
            if (!$imagenFile->move('./public/assets/img/productos_img', $nombreImagen)) {
                \Config\Services::validation()->setError('url_imagen', 'Error al subir la imagen: ' . $imagenFile->getErrorString());
                return false;
            }
            log_message('debug', 'Imagen movida correctamente a: ./public/assets/img/productos_img/' . $nombreImagen);
        } elseif (!$isInsert && $imagenFile && !empty($existingProduct['url_imagen']) && file_exists('./public/assets/img/productos_img/' . $existingProduct['url_imagen'])) {
            unlink('./public/assets/img/productos_img/' . $existingProduct['url_imagen']);
            log_message('debug', 'Imagen antigua eliminada: ' . $existingProduct['url_imagen']);
        }

        $dataToSave = $postData;
        $dataToSave['activo'] = 1;
        $dataToSave['url_imagen'] = $nombreImagen;
        if (!$isInsert) {
            unset($dataToSave['id_producto']);
            return $this->productos->update($id, $dataToSave);
        }

        return $this->productos->save($dataToSave);
    }
}