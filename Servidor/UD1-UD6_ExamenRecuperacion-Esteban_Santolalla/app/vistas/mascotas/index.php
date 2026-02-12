<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de mascotas</title>
</head>
<body>

<?php require_once RUTA_APP.'/vistas/inc/header.php'; ?>

<h1>Listado de mascotas</h1>

<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Tipo</th>
        <th>Fecha de nacimiento</th>
        <th>Foto</th>
    </tr>

    <?php if (isset($mascotas) && !empty($mascotas)) : ?>

        <?php foreach ($mascotas as $mascota) : ?>
            <tr>
                <td><?= htmlspecialchars($mascota->nombre) ?></td>
                <td><?= htmlspecialchars($mascota->tipo) ?></td>
                <td><?= htmlspecialchars($mascota->fecha_nacimiento) ?></td>
                <td>
                    <img src="<?= htmlspecialchars(RUTA_URL . $mascota->foto_url) ?>" 
                         alt="Foto de <?= htmlspecialchars($mascota->nombre) ?>" 
                         width="100">
                </td>
            </tr>
        <?php endforeach; ?>

    <?php else : ?>

        <tr>
            <td colspan="4" style="text-align:center;">
                No hay mascotas para esta persona
            </td>
        </tr>

    <?php endif; ?>

</table>

<?php require_once RUTA_APP.'/vistas/inc/footer.php'; ?>

</body>
</html>
