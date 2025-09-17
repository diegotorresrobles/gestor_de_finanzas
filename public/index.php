<?php

use Controllers\ApiCuentasController;
use Controllers\ApiMovimientosController;
use Controllers\ApiSessionController;
use Controllers\AppController;
use Controllers\CuentasController;
use Controllers\ErrorsController;
use Controllers\MovimientosController;
use Controllers\PaginasController;
use Controllers\SessionController;
use MVC\Router;

require_once '../includes/app.php';

$router = new Router;

// Errores
$router->get('/401', [ErrorsController::class, 'e401']);

// Paginas
$router->get('/', [PaginasController::class, 'index']);

//* Session
$router->get('/logup', [SessionController::class, 'logup']);
$router->post('/api/logup', [ApiSessionController::class, 'logup']);

$router->get('/login', [SessionController::class, 'login']);
$router->post('/api/login', [ApiSessionController::class, 'login']);

$router->get('/logout', [SessionController::class, 'logout']);

//* App
$router->get('/app', [AppController::class, 'index']);

// Cuentas
$router->get('/profile', [SessionController::class, 'profile']);
$router->get('/api/profile', [ApiSessionController::class, 'profile']);
$router->post('/api/profile', [ApiSessionController::class, 'profile']);

// Cuentas dinero
$router->get('/cuentas', [CuentasController::class, 'index']);
$router->get('/api/cuentas', [ApiCuentasController::class, 'index']);
$router->post('/api/cuentas', [ApiCuentasController::class, 'index']);

// Movimientos
$router->get('/movimientos', [MovimientosController::class, 'index']);
$router->get('/api/movimientos', [ApiMovimientosController::class, 'index']);
$router->post('/api/movimientos', [ApiMovimientosController::class, 'index']);
// Update
$router->get('/movimientos/update', [MovimientosController::class, 'update']);
// Tipos
$router->get('/api/tipos-movimientos', [ApiMovimientosController::class, 'tipos']);

$router->validarRutas();