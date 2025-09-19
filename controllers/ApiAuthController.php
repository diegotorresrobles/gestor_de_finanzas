<?php

namespace Controllers;

use Classes\Email;
use Models\Users;

class ApiAuthController {
    static public function logup() : void {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newUser = new Users($_POST);
            $alertas = $newUser->validarDatosLogup();
            if(!empty($alertas)) {
                jsonRes([
                    'status' => 'error',
                    'message' => 'Error en los datos',
                    'data' => ['alertas' => $alertas]
                ]);
            } else {
                $alertas = $newUser->verificarDatos();
                if($alertas) {
                    jsonRes([
                        'status' => 'error',
                        'message' => 'Usuario existente',
                        'data' => ['alertas' => $alertas]
                    ]);
                } else {
                    $newUser->hashPassword();
                    $mail = new Email;
                    $mailSend = $mail->enviarEmailVerificacion($newUser);
                    if(!$mailSend) {
                        jsonRes([
                            'status' => 'error',
                            'message' => 'Error al registrar la cuenta, intentalo de nuevo en un momento'
                        ]);
                    } else {
                        $r = $newUser->guardar();
                        if($r) {
                            jsonRes([
                                'status' => 'success',
                                'message' => 'Cuenta creada correctamente, revisa tu correo para verificarla'
                            ]);
                        } else {
                            jsonRes([
                                'status' => 'error',
                                'message' => 'Error al crear la cuenta'
                            ]);
                        }
                    }
                }
            }
        }
    }
    static public function verificar() : void {
        $token = $_GET['token'] ?? null;
        if(!$token) {
            jsonRes([
                'status' => 'error',
                'message' => 'Token invalido'
            ]);
        } else {
            $user = Users::where([
                'columnas' => '*',
                'limite' => 1,
                'where' => [
                    'token' => $token
                ] 
            ]);
            if(!$user) {
                jsonRes([
                    'status' => 'error',
                    'message' => 'Token invalido'
                ]);
            } else {
                $user->token = null;
                $user->confirmado = 1;
                $r = $user->guardar();
                if($r) {
                    jsonRes([
                        'status' => 'success',
                        'message' => 'Cuenta verificada'
                    ]);
                }
            }
        }
    }
    static public function login() : void {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new Users($_POST);
            $alertas = $user->validarDatosLogin();
            if(!empty($alertas)) {
                jsonRes([
                    'status' => 'error',
                    'message' => 'Error en los datos',
                    'data' => ['alertas' => $alertas]
                ]);
            } else {
                $alertas = $user->verificarDatosLogin();
                if(!empty($alertas)) {
                    jsonRes([
                        'status' => 'error',
                        'message' => 'Error en los datos',
                        'data' => ['alertas' => $alertas]
                    ]);
                } else {
                    jsonRes([
                        'status' => 'success',
                        'message' => 'Sesión iniciada'
                    ]);
                }
            }
        }
    }
}