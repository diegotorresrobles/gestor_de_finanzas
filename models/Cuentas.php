<?php
namespace Models;

class Cuentas extends ActiveRecord {
    protected static $columnasDB = ['id', 'id_user', 'nombre', 'tipo', 'saldo_actual'];
    protected static $tabla = 'cuentas';
    protected static $alertas = [];

    public $id;
    public $id_user;
    public $nombre;
    public $tipo;
    public $saldo_actual;

    public function __construct($datos = []) {
        $this->id = $datos['id'] ?? null;
        $this->id_user = $datos['id_user'] ?? '';
        $this->nombre = $datos['nombre'] ?? '';
        $this->tipo = $datos['tipo'] ?? '';
        $this->saldo_actual = $datos['saldo_actual'] ?? 0;
    }

    public function validarDatosNew() {
        if(!$this->nombre) {
            self::$alertas['error']['nombre'] = 'El campo es necesario';
        }
        if(!$this->tipo) {
            self::$alertas['error']['tipo'] = 'El campo es necesario';
        }
        return self::$alertas;
    }
    public function validarDatosUpdate() {
        if(!$this->nombre) {
            self::$alertas['error']['nombre'] = 'El campo es necesario';
        }
        if(!$this->tipo) {
            self::$alertas['error']['tipo'] = 'El campo es necesario';
        }
        return self::$alertas;
    }
}