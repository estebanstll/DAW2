<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar datos</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    
    <?php $datos['alumno']?>

    <form action="<?= BASE_URL ?>AlumnosController/update" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($datos['alumno']['id'] ?? ($datos['alumno']->id ?? '')) ?>">
        <input type="hidden" name="id_profe" value="<?= htmlspecialchars($datos['alumno']['profesor_id'] ?? $datos['alumno']['id_profesor'] ?? ($datos['alumno']->profesor_id ?? ($datos['alumno']->id_profesor ?? ''))) ?>">
        <div style="margin-bottom: 15px;">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="apellido">Apellido:</label><br>
            <input type="text" id="apellido" name="apellido" required style="width: 300px; padding: 5px;">
        </div>

        

        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Registrar usuario</button>
    </form>
</body>
</html>