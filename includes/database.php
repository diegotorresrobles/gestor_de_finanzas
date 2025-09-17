<?php

function DB() {
    $db = new mysqli('localhost', 'root', 'root', 'gestor_de_finanzas');
    if(!$db) {
        echo 'Error en la db';
        exit;
    }
    return $db;
}