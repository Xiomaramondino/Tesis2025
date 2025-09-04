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
$routes->get('recuperar_contrasena', 'Auth::recuperar_contrasena');
$routes->post('enviar_recuperacion', 'Auth::enviar_recuperacion');
$routes->get('resetear_contrasena', 'Auth::resetear_contrasena');
$routes->post('procesar_resetear_contrasena', 'Auth::procesar_resetear_contrasena');

$routes->get('horarios/checkTime', 'Horarios::checkTime');

$routes->get('/vista_admin', 'AdminController::index'); 
$routes->post('/admin/guardarUsuario', 'AdminController::guardarUsuario'); 
$routes->get('admin/eliminar_directivo/(:num)', 'AdminController::eliminarDirectivo/$1');

$routes->get('admin/editarDirectivo/(:num)', 'AdminController::editarDirectivo/$1');
$routes->post('admin/guardarEdicionDirectivo', 'AdminController::guardarEdicionDirectivo');
$routes->get('/admin/confirmarAsociacion/(:alphanum)/(:alpha)', 'AdminController::confirmarAsociacion/$1/$2');

$routes->get('/admin/eliminarSolicitudesExpiradas', 'AdminController::eliminarSolicitudesExpiradas');

$routes->get('/gestionar_usuarios', 'DirectivoController::gestionarUsuarios');


$routes->post('/directivo/agregarUsuario', 'DirectivoController::agregarUsuario');


$routes->get('/directivo/eliminarUsuario/(:num)', 'DirectivoController::eliminarUsuario/$1');


$routes->get('/horarios_lector', 'Horarios::horariosLector');
$routes->get('/admin/horarios', 'Horarios::horariosAdmin');

$routes->get('/directivo/editarUsuario/(:num)', 'DirectivoController::editarUsuario/$1');
$routes->post('/directivo/actualizarUsuario', 'DirectivoController::actualizarUsuario');

$routes->get('registrar_dispositivo', 'AdminController::registrar_dispositivo');
$routes->post('guardar_dispositivo', 'AdminController::guardar_dispositivo');

$routes->get('dispositivo/registerMac', 'Dispositivo::registerMac');
$routes->get('dispositivos/eliminar/(:num)', 'AdminController::eliminar_dispositivo/$1');

$routes->post('/seleccionar-contexto', 'Auth::seleccionarContexto');
$routes->get('/cambiar-colegio', 'Auth::mostrarOpcionesCambio');
$routes->post('/cambiar-contexto', 'Auth::cambiarContexto');

$routes->post('/sonar-timbre', 'TimbreController::activarTimbreManual');

$routes->get('feriados/ver', 'Feriados::ver');

$routes->post('excepciones/registrar', 'Excepciones::registrar');

$routes->post('eventos_especiales/agregar', 'EventosEspecialesController::agregar');

$routes->get('eventos_especiales/delete/(:num)', 'EventosEspecialesController::delete/$1');

$routes->get('excepciones/eliminar/(:num)', 'Excepciones::eliminar/$1');
$routes->post('excepciones/modificar/(:num)', 'Excepciones::modificar/$1');

$routes->get('feriados/lectura', 'Feriados::lectura');