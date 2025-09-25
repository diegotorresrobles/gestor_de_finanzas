<?php

function DB() {
    $db = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PSWD'], $_ENV['DB_DB']);
    if(!$db) {
        echo 'Error en la db';
        exit;
    }
    return $db;
}