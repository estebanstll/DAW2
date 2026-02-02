<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar nota</title>
</head>
<body>
    <h1>Modificar nota</h1>

    <form action="<?= BASE_URL ?>NotasController/update" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($datos['nota']['id'] ?? '') ?>">
        <input type="hidden" name="alumno_id" value="<?= htmlspecialchars($datos['nota']['alumno_id'] ?? '') ?>">

        <div style="margin-bottom: 15px;">
            <label>Asignatura:</label><br>
            <input type="text" value="<?= htmlspecialchars($datos['nota']['asignatura'] ?? '') ?>" readonly style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="nota">Nota:</label><br>
            <input type="number" step="0.01" id="nota" name="nota" required value="<?= htmlspecialchars($datos['nota']['nota'] ?? '') ?>" style="width: 300px; padding: 5px;">
        </div>

        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Guardar cambios</button>
    </form>
</body>
</html>
