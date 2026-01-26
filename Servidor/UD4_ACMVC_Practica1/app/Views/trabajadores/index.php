<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de usuarios</title>
</head>
<body>

<h1>Usuarios</h1>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Gmail</th>
            <th>Contraseña</th>
            <th>Especialidad</th>
            <th>Acciones</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario->getId()); ?></td>
                <td><?php echo htmlspecialchars($usuario->getNombre()); ?></td>
                <td><?php echo htmlspecialchars($usuario->getGmail()); ?></td>
                <td><?php echo htmlspecialchars($usuario->getContraseña()); ?></td>
                <td><?php echo htmlspecialchars($usuario->getEspecialidad() ?? 'N/A'); ?></td>
                <td>
                    <a href= "<?php echo BASE_URL ?>trabajadores/editar/<?php echo $usuario->getId(); ?>">Editar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<footer> <a href="<?php echo BASE_URL?>productos/index" >Productos</a></footer>
</body>
</html>
