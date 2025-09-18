<?php

namespace Controllers;

class ApiAuthController {
    static public function logup() : void {
    }
    static public function login() : void {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo json_encode(['post' => true]);
        }
    }
}