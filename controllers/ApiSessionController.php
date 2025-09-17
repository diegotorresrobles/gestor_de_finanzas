<?php

namespace Controllers;

use Classes\Email;
use Models\Cuentas;
use Models\Users;

class ApiSessionController {
    public static function logup() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new Users($_POST);
            $errores = $user->validarLogup();
            if(!empty($errores)) {
                http_response_code(401);
                echo json_encode([
                    "status" => "error",
                    "message" => "Hay errores en el formulario.",
                    "errors" => $errores
                ]);
            } else {
                $user->hashPassword();
                $r = $user->guardar();
                if(!$r) {
                    http_response_code(500);
                    echo json_encode([
                        "status" => "error",
                        "message" => "Error al guardar el usuario."
                    ]);
                }  else {
                    $user = Users::where([
                        'columnas' => 'id',
                        'where' => ['username' => $user->username],
                        'limite' => 1
                    ]);
                    $cuenta = new Cuentas();
                    $cuenta->crearCuentaInicial($user->id);
                    $user->crearSession($user->id);
                    http_response_code(201);
                    echo json_encode([
                        "status" => "ok",
                        "message" => "Cuenta creadaa correctamente.",
                        'redireccionar' => '/app'
                    ]);
                }
            }
        }
    }
    public static function login() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new Users($_POST);
            $errores = $user->validarLogin();
            if(!empty($errores)) {
                http_response_code(401);
                echo json_encode([
                    "status" => "error",
                    "message" => "Los datos ingresados no son correctos.",
                    "errors" => $errores
                ]);
            } else {
                $user->crearSession($user->id);
                http_response_code(200);
                echo json_encode([
                    "status" => "ok",
                    "message" => "Sesión iniciada correctamente",
                    'redireccionar' => '/app'
                ]);
            }
        }
    }
    // public static function recoveryPassword() {
    //     $token = $_GET['token'] ?? '';

    //     if($_SERVER['REQUEST_METHOD'] === 'POST' && !$token) {
    //         $user = new Users($_POST);
    //         $errores = $user->validarCamposRecoveryPassword();
    //         echo json_encode($_SERVER);
    //         if(!empty($errores)) {
    //             echo json_encode(['errores' => $errores]);
    //         } else {
    //             $user = Users::where('*', 'correo', $user->correo);
    //             $user->setToken();
    //             // $user->guardar();
    //             // $mail = Email::enviarEmail($user->token);
    //         }
    //     }
    //     if($_SERVER['REQUEST_METHOD'] === 'POST' && $token) {
    //         $user = Users::where('*', 'token', $token);
    //         $errores = $user->validarRecoveryPassword();
    //         if(!empty($errores)) {
    //             echo json_encode(['errores' => $errores]);
    //         } else {
    //             $user->password = $_POST['password'];
    //             $user->token = null;
    //             $user->hashPassword();
    //             $user->guardar();
    //         }
    //     }
    // }
    public static function profile() {
        $id_user = $_SESSION['id_user'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $user = Users::where([
                'columnas' => '*',
                'where' => ['id' => $id_user],
                'limite' => 1
            ]);
            if($user) {
                echo json_encode($user);
            } else {
                echo json_encode(['error' => 'No se encontro al usuario']);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['_method'] === 'PUT') {
            $user = Users::find($id_user) ?? false;
            if($_POST['id'] ?? false) {
                echo json_encode([
                    "status" => "error",
                    "message" => "No hagas cosas indevidas"
                ]);
                return;
            }
            $user->sincronizar($_POST);
            $errores = $user->validarUpdate($id_user);
            if(!empty($errores)) {
                echo json_encode(['errors' => $errores]);
            } else {
                $user->hashPassword();
                $r = $user->guardar();
                if(!$r) {
                    http_response_code(401);
                    echo json_encode([
                        "status" => "error",
                        "message" => "Los datos ingresados no son correctos",
                        "errors" => $errores
                    ]);
                } else {
                    http_response_code(200);
                    echo json_encode([
                        "status" => "ok",
                        "message" => "Actualizado correctamente",
                        'redireccionar' => false
                    ]);
                }
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $user = Users::find($id_user) ?? false;
            if(!$user) {
                echo json_encode(['error' => 'No se encontro al usuario']);
            } else {
                $r = $user->eliminar($user->id);
                if(!$r) {
                    echo json_encode(['resultado' => false]);
                } else {
                    $_SESSION = [];
                    echo json_encode([
                        'resultado' => true,
                        'titulo' => 'Perfil eliminado',
                        'redireccionar' => '/'
                    ]);
                }
            }
        }
    }
}