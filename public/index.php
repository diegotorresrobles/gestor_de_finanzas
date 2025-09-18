<?php

use Controllers\ApiAuthController;
use Controllers\AppController;
use Controllers\AuthController;
use MVC\Router;

require_once '../includes/app.php';

$router = new Router;

$router->get('/', [AppController::class, 'index']);
// Auth
$router->get('/logup', [AuthController::class, 'logup']);

$router->get('/login', [AuthController::class, 'login']);
$router->get('/api/login', [ApiAuthController::class, 'login']);
$router->post('/api/login', [ApiAuthController::class, 'login']);

$router->validarRutas();