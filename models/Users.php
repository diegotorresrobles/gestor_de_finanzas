<?php

namespace Models;

class Users extends ActiveRecord {
    public static $tabla = 'users';
    public static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'telefono', 'username', 'password', 'fecha_registro', 'token'];
    public static $errores = [];

    public $id;
    public $username;
    public $password;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $fecha_registro;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->username = $args['username'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->fecha_registro = date('Y-m-d H:s:m');
    }
    // Validaciones
    public function validarLogup() {
        if (!$this->nombre) {
            self::$errores['nombre'] = 'El campo no puede ir vacio.';
        }
        if (!$this->apellido) {
            self::$errores['apellido'] = 'El campo no puede ir vacio.';
        }
        if (!$this->email) {
            self::$errores['email'] = 'El campo no puede ir vacio.';
        }
        if ($this->email) {
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                self::$errores['email'] = 'El correo no es valido.';
            }
        }
        if ($this->email && filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $userExist = self::where([
                'columnas' => 'email',
                'where' => ['email' => $this->email],
                'limite' => 1
            ]);
            if ($userExist) {
                self::$errores['email'] = 'El correo ya esta registrado, elige otro.';
            }
        }
        if (!$this->telefono) {
            self::$errores['telefono'] = 'El campo no puede ir vacio.';
        }
        if (!$this->username) {
            self::$errores['username'] = 'El campo no puede ir vacio.';
        }
        if ($this->username && strpos($this->username, ' ')) {
            self::$errores['username'] = 'El nombre de usuario no puede contener espacios';
        }
        if ($this->username) {
            $userExist = self::where([
                'columnas' => 'username',
                'where' => ['username' => $this->username],
                'limite' => 1
            ]);
            if ($userExist) {
                self::$errores['username'] = 'El nombre de usuario ya esta en uso, elige otro.';
            }
        }
        if (!$this->password) {
            self::$errores['password'] = 'El campo no puede ir vacio.';
        }
        if ($this->password) {
            $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s])\S{8,64}$/';
            if (!preg_match($regex, $this->password)) {
                self::$errores['password'] = 'La cantraseña debe tener de 8 a 64 caracteres y al menos: 1 minúscula, 1 mayúscula, 1 dígito y 1 símbolo.';
            }
        }
        return self::$errores;
    }
    public function validarLogin() {
        if (!$this->username) {
            self::$errores['username'] = 'El campo es obligatorio.';
        }
        if (!$this->password) {
            self::$errores['password'] = 'El campo es obligatorio.';
        }
        if ($this->username && $this->password) {
            $user = self::where([
                'columnas' => 'id, username, password',
                'where' => ['username' => $this->username],
                'limite' => 1
            ]);
            if (!$user || !password_verify($this->password, $user->password)) {
                self::$errores['username'] =  'El usuario o contraseña son incorrectos.'; 
            } else {
                $this->id = $user->id;
            }
        }
        return self::$errores;
    }
    public function validarUpdate($id_user) {
        $user = $this->where([
            'columnas' => 'id, email, username',
            'where' => ['id' => $id_user],
            'limite' => 1
        ]) ?? null;
        if (!$this->nombre) {
            self::$errores['nombre'] = 'El campo no puede ir vacio.';
        }
        if (!$this->apellido) {
            self::$errores['apellido'] = 'El campo no puede ir vacio.';
        }
        if (!$this->email) {
            self::$errores['email'] = 'El campo no puede ir vacio.';
        }
        if ($this->email) {
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                self::$errores['email'] = 'El correo no es valido.';
            }
        }
        if ($this->email && filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $userExist = self::where([
                'columnas' => 'email',
                'where' => ['email' => $this->email],
                'limite' => 1
            ]);
            if ($userExist && $userExist->email !== $user->email) {
                self::$errores['email'] = 'El correo ya esta registrado, elige otro.';
            }
        }
        if (!$this->telefono) {
            self::$errores['telefono'] = 'El campo no puede ir vacio.';
        }
        if (!$this->username) {
            self::$errores['username'] = 'El campo no puede ir vacio.';
        }
        if ($this->username && strpos($this->username, ' ')) {
            self::$errores['username'] = 'El nombre de usuario no puede contener espacios';
        }
        if ($this->username) {
            $userExist = self::where([
                'columnas' => 'username',
                'where' => ['username' => $this->username],
                'limite' => 1
            ]);
            if ($userExist && $userExist->username !== $user->username) {
                self::$errores['username'] = 'El nombre de usuario ya esta en uso, elige otro.';
            }
        }
        if (!$this->password) {
            self::$errores['password'] = 'El campo no puede ir vacio.';
        }
        if ($this->password) {
            $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s])\S{8,64}$/';
            if (!preg_match($regex, $this->password)) {
                self::$errores['password'] = 'La cantraseña debe tener de 8 a 64 caracteres y al menos: 1 minúscula, 1 mayúscula, 1 dígito y 1 símbolo.';
            }
        }
        return self::$errores;
    }
    // Funciones
    public function setToken() {
        $this->token = uniqid();
    }
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
    public static function crearSession($id) {
        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $id;
    }
}