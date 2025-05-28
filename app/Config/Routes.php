<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
//$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::login');
$routes->post('/autenticar', 'Auth::autenticar');
$routes->get('horarios', 'Horarios::index');
$routes->get('/registro', 'Auth::registro');
$routes->post('/registro', 'Auth::guardarRegistro');
$routes->post('horarios/add','Horarios::add');
$routes->get('horarios/agregar', 'Horarios::agregar');
$routes->get('/horarios/editar/(:num)', 'Horarios::editar/$1');
$routes->post('/horarios/actualizar', 'Horarios::actualizar');
$routes->get('horarios/delete/(:num)', 'Horarios::delete/$1');
$routes->post('/logout', 'Auth::logout');
$routes->get('/hola', 'Auth::autenticar');
$routes->get('recuperar_contrasena', 'Auth::recuperar_contrasena');
$routes->post('enviar_recuperacion', 'Auth::enviar_recuperacion');
$routes->get('resetear_contrasena', 'Auth::resetear_contrasena');
$routes->post('procesar_resetear_contrasena', 'Auth::procesar_resetear_contrasena');

$routes->get('horarios/checkTime', 'Horarios::checkTime');

$routes->get('/vista_admin', 'AdminController::index');  // Para mostrar la vista de administración
$routes->post('/admin/guardarUsuario', 'AdminController::guardarUsuario');  // Para guardar un nuevo usuario
$routes->get('admin/eliminar_directivo/(:num)', 'AdminController::eliminarDirectivo/$1');

$routes->get('admin/editarDirectivo/(:num)', 'AdminController::editarDirectivo/$1');
$routes->post('admin/guardarEdicionDirectivo', 'AdminController::guardarEdicionDirectivo');

// Ruta para acceder a la vista de gestión de usuarios (directivo)
$routes->get('/gestionar_usuarios', 'DirectivoController::gestionarUsuarios');

// Ruta para agregar un nuevo usuario (directivo)
$routes->post('/directivo/agregarUsuario', 'DirectivoController::agregarUsuario');

// Ruta para eliminar un usuario (directivo)
$routes->get('/directivo/eliminarUsuario/(:num)', 'DirectivoController::eliminarUsuario/$1');


$routes->get('/horarios_lector', 'Horarios::horariosLector');
$routes->get('/admin/horarios', 'Horarios::horariosAdmin');

$routes->get('/directivo/editarUsuario/(:num)', 'DirectivoController::editarUsuario/$1');
$routes->post('/directivo/actualizarUsuario', 'DirectivoController::actualizarUsuario');
