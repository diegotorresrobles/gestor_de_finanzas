<?php
namespace Models;

class Moviminetos extends ActiveRecord {
    protected static $columnasDB = ['id', 'id_user', 'cuenta', 'tipo', 'monto', 'categoria', 'descripcion', 'fecha', 'metodo_pago'];
    protected static $tabla = 'movimientos';
    protected static $alertas = [];

    public $id;
    public $id_user;
    public $cuenta;
    public $tipo;
    public $monto;
    public $categoria;
    public $descripcion;
    public $fecha;
    public $metodo_pago;

    public function __construct($datos = []) {
        $this->id = $datos['id'] ?? null;
        $this->id_user = $datos['id_user'] ?? '';
        $this->cuenta = $datos['cuenta'] ?? '';
        $this->tipo = $datos['tipo'] ?? '';
        $this->monto = $datos['monto'] ?? '';
        $this->categoria = $datos['categoria'] ?? '';
        $this->descripcion = $datos['descripcion'] ?? '';
        $this->fecha = $datos['fecha'] ?? date('Y-m-d H:s:m');
        $this->metodo_pago = $datos['metodo_pago'] ?? '';
    }

    public function validarDatosNew() {
        if (!$this->monto) {
            self::$alertas['error']['monto'] = 'El campo es obligatorio';
        }
        if ($this->monto && !preg_match('/^[-]?\d+(\.\d+)?$/', $this->monto)) {
            self::$alertas['error']['monto'] = 'El formato no es valido';
        }
        if (!$this->tipo) {
            self::$alertas['error']['monto'] = 'El campo es obligatorio';
        }
        return self::$alertas;
    }
    public function calcularSaldoNuevo($cuenta) {
        switch ($this->tipo) {
            case '1':
                $cuenta->saldo_actual = $cuenta->saldo_actual + $this->monto;
                break;
                
            case '2':
                $cuenta->saldo_actual = $cuenta->saldo_actual - $this->monto;
                break;
            
            default:
                echo json_encode('error');
                break;
        }
        $cuenta->guardar();
    }
    public function calcularSaldoNuevoDel($cuenta) {
        switch ($this->tipo) {
            case '1':
                $cuenta->saldo_actual = $cuenta->saldo_actual - $this->monto;
                break;
                
            case '2':
                $cuenta->saldo_actual = $cuenta->saldo_actual + $this->monto;
                break;
            
            default:
                echo json_encode('error');
                break;
        }
        $cuenta->guardar();
    }
}