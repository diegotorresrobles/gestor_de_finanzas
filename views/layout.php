<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Finanzas</title>
    <!-- CSS -->
    <link rel="preload" href="/build/css/style.css" as="style">
    <link rel="stylesheet" href="/build/css/style.css">
    <!-- Iconos -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=add" />
</head>
<?php
    $auth = $_SESSION['login'] ?? false;
    $url = $_SERVER['PATH_INFO'] ?? '/';
?>
<body class="light">
    <?php echo $contenido; ?>
    <!-- Scripts -->
    <script type="module" src="/build/js/bundle.js"></script>
</body>
</html>