<?php

use Dotenv\Dotenv;
use Models\ActiveRecord;

require __DIR__ . '/../vendor/autoload.php';
require 'funciones.php';
require 'database.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = DB();
ActiveRecord::setDB($db);

date_default_timezone_set('America/Mexico_City');