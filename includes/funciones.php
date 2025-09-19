<?php

function prec($c) {
    echo '<pre>';
    var_dump($c);
    echo '</pre>';
    exit;
}

function s($html) {
    $html = htmlspecialchars($html);
    return $html;
}

function jsonRes($conf) {
    $deft = [
        'status' => '',
        'message' => '',
        'data' => null
    ];
    $conf = array_merge($deft, $conf);
    header('Content-Type: application/json');
    $respuesta = [
        'status' => $conf['status'],
        'message' => $conf['message'],
        'data' => $conf['data']
    ];
    $json = json_encode($respuesta);
    echo $json;
}