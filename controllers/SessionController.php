<?php

namespace Controllers;

use MVC\Router;

class SessionController {
    public static function logup(Router $r) {
        $auth = $_SESSION['login'] ?? false;
        if($auth) {
            header('Location: /app');
        }
        $r->render('auth/logup');
    }
    public static function login(Router $r) {
        $auth = $_SESSION['login'] ?? false;
        if($auth) {
            header('Location: /app');
        }
        $r->render('auth/login');
    }
    public static function recoveryPassword(Router $r) {
        $auth = $_SESSION['login'] ?? false;
        if($auth) {
            header('Location: /app');
        }
        $r->render('auth/password');
    }
    public static function logout() {
        $_SESSION = [];
        header('Location: /login');
    }
    public static function profile(Router $r) {
        // prec($_SESSION);
        $r->render('app/profile/index');
    }
}