<?php

namespace Controllers;

class ErrorsController {
    public static function e401() {
        include_once __DIR__ . '/../views/errors/error401.php';
    }
}