<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de producto</title>
</head>
<body>

<h1>producto</h1>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            
            <th>Nombre</th>
            
            <th>cantidad</th>

            <th>Acciones</th>


        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $producto): ?>
            <tr>
                <td><?php echo htmlspecialchars($producto->getNombre()); ?></td>
                <td><?php echo htmlspecialchars($producto->getCantidad()); ?></td>
                <td><a href="<?php echo BASE_URL?>productos/eliminar/<?php echo $producto->getId()?>">eliminar</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
