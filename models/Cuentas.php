<?php

namespace Models;

class Cuentas extends ActiveRecord {
    public static $tabla = 'cuentas';
    public static $columnasDB = ['id', 'id_user', 'nombre', 'tipo', 'saldo_actual'];
    public static $errores = [];

    public $id;
    public $id_user;
    public $nombre;
    public $tipo;
    public $saldo_actual;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->id_user = $args['id_user'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->tipo = $args['tipo'] ?? 1;
        $this->saldo_actual = $args['saldo_actual'] ?? 0;
    }
    public function crearCuentaInicial($id) {
        $this->id_user = $id;
        $this->nombre = 'Efectivo';
        $this->guardar();
    }
}