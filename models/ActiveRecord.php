<?php
namespace Models;

class ActiveRecord {
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';
    protected static $alertas = [];

    public static function setDB($db) {
        self::$db = $db;
    }

    public function guardar() {
        if(!$this->id) {
            return $this->crear();
        } else {
            return $this->actualizar();
        }
    }

    public function crear() {
        $datos = $this->sanitizarDatos();

        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= join(', ' ,array_keys($datos)) . ") ";
        $query .= "VALUES ('" . join('\', \'', array_values($datos)) . "')";

        $this->id = self::$db->insert_id;
        $resultado = self::$db->query($query);
        return $resultado;
    }
    public function actualizar() {
        $datos = $this->sanitizarDatos();

        $valores = [];
        foreach($datos as $key => $value) {
            $valores[] = "$key = '$value'";
        }

        $query = "UPDATE " . static::$tabla . " SET " ;
        $query .= join(', ' ,$valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' LIMIT 1";

        $resultado = self::$db->query($query);
        return $resultado;
    }
    public function eliminar($id) {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = '{$id}'";

        $resultado = self::$db->query($query);
        return $resultado;
    }
    public function datos() {
        $datos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $datos[$columna] = $this->$columna;
        }
        return $datos;
    }
    public function sanitizarDatos() {
        $datos = $this->datos();
        $sanitizado = [];
        foreach($datos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
    public static function consultaSQL($q) : array {
        $consulta = self::$db->query($q);
        $array = [];
        while($r = $consulta->fetch_assoc()) {
            $array[] = static::crearOBJ($r);
        }
        $consulta->free();
        return $array;
    }
    public static function crearOBJ($datos) {
        $obj = new static;
        foreach($datos as $key => $value) {
            if(property_exists($obj, $key)) {
                $obj->$key = $value;
            }
        }
        return $obj;
    }
    public function sincronizar($args = []) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
    //* Cosultas
    public static function get($id) {
        $q = "SELECT * FROM " . static::$tabla . " WHERE id = '{$id}'";
        $r = self::consultaSQL($q);
        return $r;
    }
    public static function getByIdUser($id_user) {
        $q = "SELECT * FROM " . static::$tabla . " WHERE id_user = '{$id_user}'";
        $r = self::consultaSQL($q);
        return $r;
    }
    public static function find($id) : object {
        $q = "SELECT * FROM " . static::$tabla . " WHERE id = '{$id}' LIMIT 1";
        $r = self::consultaSQL($q);
        return array_shift($r);
    }
    public static function query($q) {
        $r = self::consultaSQL($q);
        return array_shift($r);
    }
    public static function where($config = []) {
        // Defaults
        $defaults = [
            'columnas'    => '*',
            'where'       => [],          // array de condiciones
            'order'       => 'id DESC',   // por defecto ordena por id
            'limite'      => 20,
            'cursor'      => null,
            'cursor_col'  => 'id'
        ];

        $config = array_merge($defaults, $config);

        // Validar límite
        $limite = (int) $config['limite'];
        if ($limite <= 0) $limite = 20;

        // Construir WHERE dinámico
        $whereClauses = [];
        if (!empty($config['where'])) {
            foreach ($config['where'] as $col => $val) {
                $safeCol = self::$db->escape_string($col);
                $safeVal = "'" . self::$db->escape_string($val) . "'";
                $whereClauses[] = "{$safeCol} = {$safeVal}";
            }
        } else {
            $whereClauses[] = "1"; // always true
        }

        // Condición de cursor
        if ($config['cursor'] !== null) {
            $cursorVal = "'" . self::$db->escape_string($config['cursor']) . "'";
            if (stripos($config['order'], 'DESC') !== false) {
                $whereClauses[] = "{$config['cursor_col']} < {$cursorVal}";
            } else {
                $whereClauses[] = "{$config['cursor_col']} > {$cursorVal}";
            }
        }

        // Unir condiciones
        $whereSql = implode(" AND ", $whereClauses);

        // Query final
        $q = "SELECT {$config['columnas']} 
            FROM " . static::$tabla . " 
            WHERE {$whereSql} 
            ORDER BY {$config['order']} 
            LIMIT {$limite}";
        $r = self::consultaSQL($q);
        if ($config['limite'] === 1 && count($r) === 1) {
            return array_shift($r);
        }
        return $r;
    }
    //* Set
    public static function setAlerta($alerta, $txt) {
        static::$alertas[$alerta] = $txt;
    }
    //* Get
    public static function getAlertas() {
        return static::$alertas;
    }
}