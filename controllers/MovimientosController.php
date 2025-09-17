<?php

namespace Controllers;

use MVC\Router;

class MovimientosController {
    static public function index(Router $r) {
        $r->render('app/movimientos/index');
    }
    static public function update(Router $r) {
        $r->render('app/movimientos/update');
    }
}