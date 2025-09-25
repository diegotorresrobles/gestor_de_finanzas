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
    $auth = $_SESSION['auth'] ?? false;
    $url = $_SERVER['PATH_INFO'] ?? '/';
?>
<body <?php if ($auth) echo 'class="app"' ?>>
    <header class="header">
        <input type="checkbox" name="theme" id="theme" class="header__theme-btn">
        <?php if ($auth): ?>
            <a href="/logout" class="header__link">Cerrar Sesión <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg></a>
        <?php endif; ?>
    </header>
    <?php echo $contenido; ?>
    <!-- Scripts -->
    <script type="module" src="/build/js/bundle.js"></script>
</body>
</html>