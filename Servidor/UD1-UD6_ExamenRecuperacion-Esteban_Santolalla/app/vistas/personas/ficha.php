<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles</title>
</head>
<body>
<?php require_once RUTA_APP.'/vistas/inc/header.php'; ?>
<h1>Detalles</h1>

<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Telefono</th>
        <th>Email</th>
    </tr>

    <?php $persona = $personas; ?>

    <tr>
        <td><?= $persona->nombre ?></td>
        <td><?= $persona->apellidos ?></td>
        <td><?= $persona->telefono ?></td>
        <td><?= $persona->email ?></td>
    </tr>


</table>
<?php require_once RUTA_APP.'/vistas/inc/footer.php'; ?>
</body>
</html>
<?php
