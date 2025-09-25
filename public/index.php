<?php

use Controllers\ApiAuthController;
use Controllers\ApiCuentasController;
use Controllers\ApiMovimientosController;
use Controllers\AppController;
use Controllers\AuthController;
use MVC\Router;

require_once '../includes/app.php';

$router = new Router;

$router->get('/', [AppController::class, 'index']);
// Auth
$router->get('/logup', [AuthController::class, 'logup']);
$router->post('/api/logup', [ApiAuthController::class, 'logup']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/api/login', [ApiAuthController::class, 'login']);

$router->get('/account-verify', [AuthController::class, 'verificar']);
$router->get('/api/account-verify', [ApiAuthController::class, 'verificar']);
$router->post('/api/account-verify', [ApiAuthController::class, 'verificar']);

$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/api/cuentas', [ApiCuentasController::class, 'cuentas']);
$router->post('/api/cuentas', [ApiCuentasController::class, 'cuentas']);

$router->get('/api/movimientos', [ApiMovimientosController::class, 'movimientos']);
$router->post('/api/movimientos', [ApiMovimientosController::class, 'movimientos']);

$router->validarRutas();