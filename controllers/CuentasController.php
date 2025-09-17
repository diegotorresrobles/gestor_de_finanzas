<?php

namespace Controllers;

use MVC\Router;

class CuentasController {
    public static function index(Router $r) {
        $r->render('app/cuentas/index');
    }
}