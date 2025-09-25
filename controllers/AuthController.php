<?php

namespace Controllers;

use MVC\Router;

class AuthController {
    static public function logup(Router $r) : void {
        $r->render('auth/logup');
    }
    static public function verificar(Router $r) : void {
        $r->render('auth/verificar');
    }
    static public function login(Router $r) : void {
        $r->render('auth/login');
    }
    static public function logout() : void {
        session_unset();
        session_destroy();
        $_SESSION = [];

        header('Location: /login');
    }
}