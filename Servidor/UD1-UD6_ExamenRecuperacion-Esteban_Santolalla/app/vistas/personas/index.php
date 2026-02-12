<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de personas</title>
</head>
<body>
<?php require_once RUTA_APP.'/vistas/inc/header.php'; ?>
<h1>Listado de Personas</h1>

<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Telefono</th>
        <th>Email</th>
        <th>Acciones</th>
    </tr>

    <?php
        foreach ($personas as $persona) {
            echo "<tr>";
            echo "<td>". $persona["nombre"] ."</td>";
            echo "<td>".$persona["apellidos"]."</td>";
            echo "<td>".$persona["telefono"]."</td>";
            echo "<td>".$persona["email"]."</td>";
            echo "<td><a href='" . RUTA_URL . "/PersonasControlador/ficha/" . $persona["id"] ."'>Datos</a>
                      <a href='" . RUTA_URL . "/MascotasControlador/index/" . $persona["id"] ."'>Mascotas</a>
                      <a href='" . RUTA_URL . "/PersonasControlador/eliminar/" . $persona["id"] ."'>Eliminar</a>
            </td>";
            echo "</tr>";
        }
    ?>

</table>
<a href="<?php echo RUTA_URL ?>/PersonasControlador/registrar">Nueva persona</a>
<?php require_once RUTA_APP.'/vistas/inc/footer.php'; ?>
</body>
</html>
<?php
