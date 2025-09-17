<?php

namespace Controllers;

use MVC\Router;

class AppController {
    public static function index(Router $r) {
        $r->render('app/index', [
            
        ]);
    }
}