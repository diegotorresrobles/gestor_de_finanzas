<?php

namespace Controllers;

use Models\Cuentas;

class ApiCuentasController {
    static public function cuentas() : void {
        $method = $_POST['_method'] ?? false;
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id_user = $_SESSION['id'];
            $cuentas = Cuentas::where([
                'columnas' => '*',
                'where' => [
                    'id_user' => $id_user
                ],
                'limite' => 1
            ]);
            if(!$cuentas) {
                jsonRes([
                    'status' => 'error',
                    'message' => 'No hay registros'
                ]);
            } else {
                jsonRes([
                    'status' => 'success',
                    'message' => 'Cuentas: ',
                    'data' => $cuentas
                ]);
            }
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !$method) {
            $id_user = $_SESSION['id'];
            $cuenta = Cuentas::where([
                'columnas' => '*',
                'limite' => 1,
                'where' => [
                    'id_user' => $id_user
                ]
            ]);
            if($cuenta) {
                jsonRes([
                    'status' => 'error',
                    'message' => 'Cuenta existente',
                    'data' => [
                        'alertas' => [
                            'error' => 'Cuenta existente'
                        ]
                    ]
                ]);
            } else {
                $cuentas = new Cuentas($_POST);
                $cuentas->id_user = $id_user;
                $alertas = $cuentas->validarDatosNew();
                if(!empty($alertas)) {
                    jsonRes([
                        'status' => 'error',
                        'message' => 'No hay registros',
                        'data' => [
                            'alertas' => $alertas
                        ]
                    ]);
                } else {
                    $r = $cuentas->guardar();
                    if(!$r) {
    
                    } else {
                        jsonRes([
                            'status' => 'success',
                            'message' => 'Cuenta creada',
                            'data' => [
                                'alertas' => [
                                    'exito' => 'Cuenta creada correctamente'
                                ]
                            ]
                        ]);
                    }
                }
            }
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $method === 'PUT') {
            $id_user = $_SESSION['id'];
            $cuenta = Cuentas::where([
                'columnas' => '*',
                'limite' => 1,
                'where' => [
                    'id_user' => $id_user,
                    'id' => $_POST['id']
                ]
            ]);
            if(!$cuenta) {
                jsonRes([
                    'status' => 'error',
                    'message' => 'No se encontro el registro',
                    'data' => [
                        'alertas' => [
                            'error' => 'No se encontro el registro'
                        ]
                    ]
                ]);
            } else {
                $cuenta->sincronizar($_POST);
                $r = $cuenta->guardar();
                if(!$r) {

                } else {
                    jsonRes([
                    'status' => 'success',
                    'message' => 'Cuenta actualizada',
                    'data' => [
                        'alertas' => [
                            'exito' => 'Cuenta actualizada correctamente'
                        ]
                    ]
                ]);
                }
            }
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $method === 'DELETE') {
            $id_user = $_SESSION['id'];
            $cuenta = Cuentas::where([
                'columnas' => '*',
                'limite' => 1,
                'where' => [
                    'id_user' => $id_user,
                    'id' => $_POST['id']
                ]
            ]);
            if(!$cuenta) {
                jsonRes([
                    'status' => 'error',
                    'message' => 'No se encontro el registro',
                    'data' => [
                        'alertas' => [
                            'error' => 'No se encontro el registro'
                        ]
                    ]
                ]);
            } else {
                $r = $cuenta->eliminar($cuenta->id);
                if(!$r) {

                } else {
                    jsonRes([
                    'status' => 'success',
                    'message' => 'Cuenta eliminada',
                    'data' => [
                        'alertas' => [
                            'exito' => 'Cuenta eliminada correctamente'
                        ]
                    ]
                ]);
                }
            }
        }
    }
}