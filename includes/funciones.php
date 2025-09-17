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