<?php

namespace Models;

class Movimientos extends ActiveRecord {
    public static $tabla = 'movimientos';
    public static $columnasDB = ['id', 'id_user', 'cuenta', 'tipo', 'monto', 'categoria', 'descripcion', 'fecha', 'metodo_pago'];
    public static $errores = [];

    public $id;
    public $id_user;
    public $cuenta;
    public $tipo;
    public $monto;
    public $categoria;
    public $descripcion;
    public $fecha;
    public $metodo_pago;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->id_user = $_SESSION['id_user'] ?? '';
        $this->cuenta = $args['cuenta'] ?? '';
        $this->tipo = $args['tipo'] ?? '';
        $this->monto = $args['monto'] ?? '';
        $this->categoria = $args['categoria'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->fecha = $args['fecha'] ?? date('Y-m-d');
        $this->metodo_pago = $args['metodo_pago'] ?? '';
    }
    public function validarNew() {
        $id_user = $_SESSION['id_user'] ?? null;
        if(!$this->monto) {
            self::$errores['monto'] = 'El campo es obligatorio';
        }
        if(!$this->tipo) {
            self::$errores['tipo'] = 'El campo es obligatorio';
        }
        if($this->tipo) {
            $tipo = TiposMovimientos::where([
                'columnas' => '*',
                'where' => ['id' => $this->tipo],
                'limite' => 1
            ]);
            if(!$tipo) {
                self::$errores['tipo'] = 'El tipo no es valido';
            }
        }
        if(!$this->cuenta) {
            self::$errores['cuenta'] = 'El campo es obligatorio';
        }
        if($this->cuenta) {
            $cuenta = Cuentas::where([
                'columnas' => '*',
                'where' => ['id' => $this->cuenta],
                'limite' => 1
            ]);
            if(!$cuenta || $cuenta->id_user !== $id_user) {
                self::$errores['cuenta'] = 'Error en la cuenta';
            }
        }
        return self::$errores;
    }
    public function validarFormEdit() {
        if(!$this->cuenta) {
            self::$errores['cuenta'] = 'El campo "Cuenta" es obligatorio';
        }
        if(!$this->tipo) {
            self::$errores['tipo'] = 'El campo "Tipo de movimiento" es obligatorio';
        }
        if(!$this->monto) {
            self::$errores['monto'] = 'El campo "Monto" es obligatorio';
        }
        if($this->monto & $this->monto < 0) {
            self::$errores['monto'] = 'El monto debe ser mayor a 0';
        }
        return self::$errores;
    }
}