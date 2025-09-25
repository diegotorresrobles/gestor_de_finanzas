<?php

namespace Controllers;

use MVC\Router;

class AppController {
    static public function index(Router $r) : void {
        $r->render('app/index');
    }
}