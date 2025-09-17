<?php

namespace Models;

class TiposMovimientos extends ActiveRecord {
    public static $tabla = 'tipos_movimientos';
    public static $columnasDB = ['id', 'nombre'];
    public static $errores = [];

    public $id;
    public $nombre;

    public function __construct()
    {
    }

    public static function getAll() {
        $q = "SELECT * FROM " . self::$tabla;
        $r = self::consultaSQL($q);
        return $r;
    }
}