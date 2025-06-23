<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Página principal
$routes->get('/', 'Home::index');

// Páginas informativas
$routes->get('QuienesSomos', 'Home::QuienesSomos');
$routes->get('Comercializacion', 'Home::Comercializacion');
$routes->get('TerminosYUsos', 'Home::TerminosYUsos');
$routes->get('/informacionContacto', 'Contacto::index');

// Autenticación
$routes->get('ingresar', 'FormularioIngreso::index');
$routes->post('ingresar/send', 'FormularioIngreso::send');
$routes->get('registrar', 'Registro::index');
$routes->post('registrar/save', 'Registro::save');
$routes->get('cerrar_sesion', 'CerrarSesion::index');

// Perfil y usuarios
$routes->get('editar_perfil', 'PerfilController::index');
$routes->post('/perfil/guardar', 'PerfilController::guardar');
$routes->get('ver_usuarios', 'VerUsuarios::index');
$routes->get('administrar_usuarios', 'AdministrarUsuariosController::index');
$routes->get('admin_dashboard', 'AdminDashboard::index');

// Gestión de admin
$routes->get('anadir_admin', 'AnadirAdmin::index');
$routes->post('anadir_admin/enviar', 'AnadirAdmin::enviar');

// Contacto y consultas
$routes->post('/contacto/send', 'Contacto::send');
$routes->get('/ver_consultas', 'Contacto::verConsultas');
$routes->get('/contacto/detalles_no_respondidas/(:num)', 'Contacto::detallesNoRespondidas/$1');
$routes->get('/contacto/detalles_respondidas/(:num)', 'Contacto::detallesRespondidas/$1');
$routes->post('/contacto/sendResponse/(:num)', 'Contacto::sendResponse/$1');
$routes->get('/contacto/marcar_como_vista/(:num)', 'Contacto::marcar_como_vista/$1');
$routes->get('/contacto/ver_mi_consulta_respondida/(:num)', 'Contacto::verMiConsultaRespondida/$1');

// Gestión de géneros
$routes->get('Generos', 'Generos::index');
$routes->get('generos/nuevo', 'Generos::nuevo');
$routes->get('generos/eliminados', 'Generos::eliminados');
$routes->get('generos/editar/(:num)', 'Generos::editar/$1');
$routes->post('generos/insertar', 'Generos::insertar');
$routes->post('generos/actualizar', 'Generos::actualizar');
$routes->post('generos/eliminar/(:num)', 'Generos::eliminar/$1');
$routes->post('generos/reingresar/(:num)', 'Generos::reingresar/$1');

// Gestión de productos
$routes->get('Productos', 'Productos::index');
$routes->get('productos/nuevo', 'Productos::nuevo');
$routes->get('productos/eliminados', 'Productos::eliminados');
$routes->get('productos/editar/(:num)', 'Productos::editar/$1');
$routes->post('productos/insertar', 'Productos::insertar');
$routes->post('productos/actualizar', 'Productos::actualizar');
$routes->post('productos/eliminar/(:num)', 'Productos::eliminar/$1');
$routes->post('productos/reingresar/(:num)', 'Productos::reingresar/$1');

// Catálogo
$routes->get('/catalogo', 'Catalogo::index');
$routes->get('/catalogo/toggle/(:num)', 'Catalogo::toggle/$1');
$routes->post('catalogo/agregar', 'Catalogo::agregar');

// Carrito
$routes->get('/carrito', 'Carrito::index');
$routes->get('/carrito/eliminar/(:num)', 'Carrito::eliminar/$1');
$routes->post('/carrito/actualizar', 'Carrito::actualizar');
$routes->get('/carrito/comprar', 'Carrito::comprar');

// Factura
$routes->get('/factura', 'Factura::index');
$routes->get('factura/ver/(:num)', 'Factura::ver/$1');

// 🆕 NUEVAS RUTAS para funcionalidad extendida de la vista inicio
$routes->get('/genero/(:num)', 'Home::filtrarPorGenero/$1'); // Muestra todos los productos de un género
$routes->get('/producto/(:num)', 'Home::detalle/$1'); // Detalle de un producto individual
$routes->post('/producto/agregarCarrito/(:num)', 'Home::agregarCarrito/$1'); // Agregar al carrito desde el detalle

$routes->get('/catalogo/genero/(:num)', 'Catalogo::genero/$1');
$routes->get('/catalogo/detalle/(:num)', 'Catalogo::detalle/$1');

$routes->get('/catalogo/catalogo_inicio', 'Catalogo::catalogoInicio');
$routes->get('/catalogo/filtro_genero/(:num)', 'Catalogo::filtroGenero/$1');
$routes->get('/catalogo/detalle_producto/(:num)', 'Catalogo::detalleProducto/$1');



