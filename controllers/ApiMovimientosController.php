<?php

namespace Controllers;

use Models\Cuentas;
use Models\Movimientos;
use Models\TiposMovimientos;

class ApiMovimientosController {
    static public function index() {
        $id_user = $_SESSION['id_user'] ?? null;
        $metodo = $_SERVER['REQUEST_METHOD'];
        $postMethod = $_POST['_method'] ?? null;
        if($metodo === 'GET') {
            $id = $_GET['id'] ?? null;
            if(!$id) {
                $movimientos = Movimientos::where([
                    'columnas' => '*',
                    'where' => ['id_user' => $id_user],
                    'order' => 'id DESC',
                    'cursor_col' => 'id',
                    'limite' => 20
                ]);
                if(!$movimientos) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'No se encontro el registro'
                    ]);
                } else {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'ok',
                        'message' => '',
                        'movimientos' => $movimientos
                    ]);
                }
            } else {
                $movimientos = Movimientos::where([
                    'columnas' => '*',
                    'where' => ['id' => $id],
                    'limite' => 1
                ]);
                if(!$movimientos) {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'No se encontro el registro',
                        'movimientos' => null
                    ]);
                } else {
                    if($movimientos->id_user !== $id_user) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'No se encontro el registro'
                        ]);
                    } else {
                        http_response_code(200);
                        echo json_encode([
                            'status' => 'ok',
                            'message' => '',
                            'movimientos' => $movimientos
                        ]);
                    }
                }
            }
        }
        if ($metodo === 'POST' && !$postMethod) {
            $movimiento = new Movimientos($_POST);
            $errores = $movimiento->validarNew();
            if (!empty($errores)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => '',
                    'errors' => $errores
                ]);
            } else {
                $cuenta = Cuentas::where([
                    'columnas' => '*',
                    'where' => ['id' => $movimiento->cuenta],
                    'limite' => 1
                ]);
                $tipoMovimiento = TiposMovimientos::where([
                    'columnas' => '*',
                    'where' => ['id' => $movimiento->tipo],
                    'limite' => 1
                ]);
                if(strtolower($tipoMovimiento->nombre) === 'ingreso') {
                    $cuenta->saldo_actual = $cuenta->saldo_actual + $movimiento->monto;
                } else {
                    $cuenta->saldo_actual = $cuenta->saldo_actual - $movimiento->monto;
                }
                $r = $movimiento->guardar();
                if (!$r) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Error al registrar el movimiento'
                    ]);
                } else {
                    $r = $cuenta->guardar();
                    if(!$r) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Error al actualizar la cuenta'
                        ]);
                    } else {
                        http_response_code(200);
                        echo json_encode([
                            'status' => 'ok',
                            'message' => 'Movimiento agregado correctamente'
                        ]);
                    }
                }
            }
        } else if ($postMethod === 'PUT') {
            $movimiento = Movimientos::where([
                'where' => ['id' => $_POST['id']],
                'limite' => 1
            ]);
            $cuenta = Cuentas::where([
                'columnas' => '*',
                'where' => ['id' => $movimiento->cuenta],
                'limite' => 1
            ]);
            $tipoMovimiento = TiposMovimientos::where([
                'columnas' => '*',
                'where' => ['id' => $movimiento->tipo],
                'limite' => 1
            ]);
            if(strtolower($tipoMovimiento->nombre) === 'ingreso') {
                $cuenta->saldo_actual = $cuenta->saldo_actual - $movimiento->monto;
            } else {
                $cuenta->saldo_actual = $cuenta->saldo_actual + $movimiento->monto;
            }
            $movimiento->sincronizar($_POST);
            $tipoMovimiento = TiposMovimientos::where([
                'columnas' => '*',
                'where' => ['id' => $movimiento->tipo],
                'limite' => 1
            ]);
            if(strtolower($tipoMovimiento->nombre) === 'ingreso') {
                $cuenta->saldo_actual = $cuenta->saldo_actual + $movimiento->monto;
            } else {
                $cuenta->saldo_actual = $cuenta->saldo_actual - $movimiento->monto;
            }
            $r = $movimiento->guardar();
            $cuenta->guardar();
            if(!$r) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al actualizar el movimiento'
                ]);
            } else {
                http_response_code(200);
                echo json_encode([
                    'status' => 'ok',
                    'message' => 'Movimiento actualizado correctamente'
                ]);
            }
        }
    }
    static public function tipos() {
        $id_user = $_SESSION['id_user'] ?? null;
        $metodo = $_SERVER['REQUEST_METHOD'];
        if($metodo === 'GET') {
            $tipos_movimientos = TiposMovimientos::getAll();
            if(!$tipos_movimientos) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'ok',
                    'message' => '',
                    'tipos_movimientos' => null
                ]);
            } else {
                http_response_code(200);
                echo json_encode([
                    'status' => 'ok',
                    'message' => '',
                    'tipos_movimientos' => $tipos_movimientos
                ]);
            }
        }
    }
}