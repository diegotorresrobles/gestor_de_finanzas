<?php
namespace Models;

class Users extends ActiveRecord {
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'telefono', 'username', 'password', 'fecha_registro', 'token', 'confirmado'];
    protected static $tabla = 'users';
    protected static $alertas = [];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $username;
    public $password;
    public $fecha_registro;
    public $token;
    public $confirmado;

    public function __construct($datos = []) {
        $this->id = $datos['id'] ?? null;
        $this->nombre = $datos['nombre'] ?? '';
        $this->apellido = $datos['apellido'] ?? '';
        $this->email = $datos['email'] ?? '';
        $this->telefono = $datos['telefono'] ?? '';
        $this->username = $datos['username'] ?? '';
        $this->password = $datos['password'] ?? '';
        $this->fecha_registro = $datos['fecha_registro'] ?? date('Y-m-d H:s:m');
        $this->token = $datos['token'] ?? uniqid();
        $this->confirmado = $datos['confirmado'] ?? 0;
    }

    public function validarDatosLogup() {
        if (!$this->nombre || !$this->apellido || !$this->email || !$this->telefono || !$this->username || !$this->password) {
            self::$alertas['error']['campos'] = 'Verifica que el formulario este completo';
        }
        if ($this->email) {
            $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            if (!preg_match($regex, $this->email)) {
                self::$alertas['error']['email'] = 'El email no es valido';
            }
        }
        if ($this->telefono) {
            $regex = '/^\d{10}$/';
            if (!preg_match($regex, $this->telefono)) {
                self::$alertas['error']['telefono'] = 'El teléfono no es valido';
            }
        }
        if ($this->username) {
            $regex = '/^[a-zA-Z0-9_-]{3,16}$/';
            if (!preg_match($regex, $this->username)) {
                self::$alertas['error']['username'] = 'El username no es valido';
            }
        }
        if ($this->password) {
            $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?.&])[A-Za-z\d@$!%*?.&]{8,}$/';
            if (!preg_match($regex, $this->password)) {
                self::$alertas['error']['password'] = 'La contraseña no es valida';
            }
        }
        if ($this->password && $_POST['password-confirm'] && $this->password !== $_POST['password-confirm']) {
            self::$alertas['error']['password'] = 'Las contraseñas no coinciden';
        }
        return self::$alertas;
    }
    public function verificarDatos() {
        $q = "SELECT email, telefono, username FROM " . self::$tabla . " WHERE email = '" . self::$db->escape_string($this->email) . "' OR telefono = '" . self::$db->escape_string($this->telefono) ."' OR username = '" . self::$db->escape_string($this->username) . "'";
        $user = self::query($q);
        if($user) {
            if($user->email === $this->email) {
                self::$alertas['error']['email'] = 'El email ya esta registrado';
            }
            if($user->telefono === $this->telefono) {
                self::$alertas['error']['telefono'] = 'El teléfono ya esta registrado';
            }
            if($user->username === $this->username) {
                self::$alertas['error']['username'] = 'El username ya esta registrado';
            }
        }
        return self::$alertas;
    }
    public function validarDatosLogin() {
        if(!$this->username) {
            self::$alertas['error']['username'] = 'El campo no debe ir vacio';
        }
        if(!$this->password) {
            self::$alertas['error']['password'] = 'El campo no debe ir vacio';
        }
        return self::$alertas;
    }
    public function verificarDatosLogin() {
        $user = self::where([
            'columnas' => '*',
            'limite' => 1,
            'where' => [
                'username' => $this->username
            ] 
        ]);
        if(!$user || !password_verify($this->password, $user->password)) {
            self::$alertas['error']['username'] = 'El usuario o la contraseña son incorrectos';
        }
        if($user->confirmado === '0') {
            self::$alertas['error']['username'] = 'La cuenta no ha sido confirmada';
        }
        if(empty(self::$alertas)) {
            $user->crearSesion();
        }
        return self::$alertas;
    }
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
    public function crearSesion($new = false) {
        session_regenerate_id(true);
        $_SESSION['auth'] = true;
        $_SESSION['login_time'] = time();
        $_SESSION['id'] = $this->id;
        if ($new) {
            $_SESSION['new-account'] = true;
        }
    }
}