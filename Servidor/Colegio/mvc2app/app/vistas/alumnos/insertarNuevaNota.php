<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva nota</title>
</head>
<body>
    <h1>Crear nueva nota</h1>

    <form action="<?= BASE_URL ?>NotasController/create" method="POST">
        <input type="hidden" name="alumno_id" value="<?= htmlspecialchars($datos['alumno_id'] ?? '') ?>">

        <div style="margin-bottom: 15px;">
            <label for="asignatura">Asignatura:</label><br>
            <input type="text" id="asignatura" name="asignatura" required style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="nota">Nota:</label><br>
            <input type="number" step="0.01" id="nota" name="nota" required style="width: 300px; padding: 5px;">
        </div>

        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Guardar nota</button>
    </form>
</body>
</html>
