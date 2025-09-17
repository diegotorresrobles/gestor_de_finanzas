<?php

namespace Controllers;

use MVC\Router;

class PaginasController {
    public static function index(Router $r) {
        $r->render('index');
    }
}