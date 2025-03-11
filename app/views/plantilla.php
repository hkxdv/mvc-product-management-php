<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= aliasPath('@img/favicon.180x180.png'); ?>" type="image/png">
    <link rel="icon" href="<?= aliasPath('@img/favicon.180x180.png'); ?>" type="image/png">
    <title>Gestión de Inventario y Demanda</title>
    <?php include aliasPath('@Componentes'); ?>

</head>

<body class="d-flex flex-column min-vh-100">

    <header>
        <!-- menu -->
        <?php include aliasPath('@Menu'); ?>
    </header>

    <main class="container flex-grow-1 mb-5 mt-5">
        <!-- Contenido dinámico -->
        <?php Controlador::enlaces_paginas_controlador(); ?>
    </main>

    <footer>
        <!-- pie de pagína -->
        <?php include aliasPath('@Pie_pagina'); ?>
    </footer>


</body>

</html>