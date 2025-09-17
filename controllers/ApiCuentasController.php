<?php

namespace Controllers;

use Models\Cuentas;

class ApiCuentasController {
    public static function index() {
        $id_user = $_SESSION['id_user'] ?? null;
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $cuentas = Cuentas::where([
                'columnas' => '*',
                'where' => ['id_user' => $id_user],
                'limite' => 1
            ]);
            if(!$cuentas) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'ok',
                    'message' => '',
                    'cuentas' => null
                ]);
            } else {
                http_response_code(200);
                echo json_encode([
                    'status' => 'ok',
                    'message' => '',
                    'cuentas' => $cuentas
                ]);
            }
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_user = $_SESSION['id_user'] ?? null;
            $cuentas = new Cuentas($_POST);
            $cuentas->id_user = $id_user;
            $r = $cuentas->guardar();
            if(!$r) {
                echo json_encode([
                    'resultado' => false
                ]);
            } else {
                http_response_code(200);
                echo json_encode([
                    'resultado' => true,
                    'titulo' => 'Cuenta creada',
                    'redireccionar' => '/cuentas'
                ]);
            }
        }
    }
}