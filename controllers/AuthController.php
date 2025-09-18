<?php

namespace Controllers;

use MVC\Router;

class AuthController {
    static public function logup(Router $r) : void {
        $r->render('auth/logup');
    }
    static public function login(Router $r) : void {
        $r->render('auth/login');
    }
}