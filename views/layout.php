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
<body class="ligth <?php if($auth && $url !== '/') echo 'app'; ?>">
    <?php if($auth && $url !== '/'): ?>
        <aside class="aside">
            <div class="aside__header">
                <a href="/app" class="aside__logo--link">
                    <h1 class="aside__logo">Gestor de Finanzas</h1>
                </a>
                <div class="aside__menu-btn">
                    <div class="aside__menu-btn--line-1"></div>
                    <div class="aside__menu-btn--line-2"></div>
                </div>
            </div>
            <div class="aside__contenido">
                <ul class="aside__dropdown-contenedor">
                    <li class="aside__dropdown">
                        <button type="button" class="aside__btn">Tus cuentas</button>
                        <ul class="aside__dropdown-contenedor">
                            <li class="aside__dropdown">
                                <a href="/cuentas" class="aside__btn aside__btn--link">Ver</a>
                            </li>
                        </ul>
                    </li>
                    <li class="aside__dropdown">
                        <button type="button" class="aside__btn">Movimientos</button>
                        <ul class="aside__dropdown-contenedor">
                            <li class="aside__dropdown">
                                <a href="/movimientos" class="aside__btn aside__btn--link">Ver</a>
                            </li>
                        </ul>
                    </li>
                    <div class="aside__line"></div>
                    <li class="aside__dropdown">
                        <button type="button" class="aside__btn">Cuenta</button>
                        <ul class="aside__dropdown-contenedor">
                            <li class="aside__dropdown">
                                <a href="/profile" class="aside__btn aside__btn--link">Perfil</a>
                                <a href="/logout" class="aside__btn aside__btn--link">Cerrar sesión</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>
    <?php endif; ?>
    <?php echo $contenido; ?>
    <!-- Scripts -->
    <script type="module" src="/build/js/bundle.js"></script>
</body>
</html>