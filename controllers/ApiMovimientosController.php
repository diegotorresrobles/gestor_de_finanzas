<?php

namespace Controllers;

use Models\Cuentas;
use Models\Moviminetos;

class ApiMovimientosController {
    static public function movimientos() : void {
        $method = $_POST['_method'] ?? false;
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id_user = $_SESSION['id'];
            $movimientos = Moviminetos::where([
                'columnas' => '*',
                'where' => [
                    'id_user' => $id_user
                ],
                'limite' => 100
            ]);
            if(!$movimientos) {
                jsonRes([
                    'status' => 'error',
                    'message' => 'No hay registros'
                ]);
            } else {
                jsonRes([
                    'status' => 'success',
                    'message' => 'Movimientos: ',
                    'data' => $movimientos
                ]);
            }
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !$method) {
            $id_user = $_SESSION['id'];
            $movimiento = new Moviminetos($_POST);
            $movimiento->id_user = $id_user;

            $cuenta = Cuentas::where([
                'columnas' => '*',
                'limite' => 1,
                'where' => [
                    'id_user' => $id_user
                ]
            ]);

            $movimiento->cuenta = $cuenta->id;
            $alertas = $movimiento->validarDatosNew();
            if(!empty($alertas)) {
                jsonRes([
                    'status' => 'error',
                    'message' => 'Verificar datos',
                    'data' => [
                        'alertas' => $alertas
                    ]
                ]);
            } else {
                $movimiento->calcularSaldoNuevo($cuenta);
                $r = $movimiento->guardar();
                if(!$r) {

                } else {
                    jsonRes([
                        'status' => 'success',
                        'message' => 'Movimiento creado',
                        'data' => [
                            'alertas' => [
                                'exito' => 'Movimiento creado correctamente'
                            ]
                        ]
                    ]);
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
            $movimiento = Moviminetos::where([
                'columnas' => '*',
                'limite' => 1,
                'where' => [
                    'id_user' => $id_user,
                    'id' => $_POST['id']
                ]
            ]);
            if(!$movimiento) {
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
                $cuenta = Cuentas::where([
                    'columnas' => '*',
                    'limite' => 1,
                    'where' => [
                        'id_user' => $id_user
                    ]
                ]);
                
                $movimiento->calcularSaldoNuevoDel($cuenta);
                $r = $movimiento->eliminar($movimiento->id);
                if(!$r) {

                } else {
                    jsonRes([
                    'status' => 'success',
                    'message' => 'Movimiento eliminado',
                    'data' => [
                        'alertas' => [
                            'exito' => 'Movimiento eliminado correctamente'
                        ]
                    ]
                ]);
                }
            }
        }
    }
}