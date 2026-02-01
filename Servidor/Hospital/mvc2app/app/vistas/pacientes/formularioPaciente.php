<?php
// Vista: formularioPaciente.php
// Muestra un formulario para enviar medico_id, nombre y motivo
// Si hay sesión y token, lo expone a JS en data-token
// Extraer datos pasados desde el controlador
$paciente = [];
if (!empty($datos['Pacientes'])) {
    // Puede venir como array indexado o asociativo
    $paciente = is_array($datos['Pacientes']) ? ($datos['Pacientes'][0] ?? $datos['Pacientes']) : [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulario Paciente</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { max-width: 480px; margin: 0 auto; }
        label { display:block; margin-top:12px; }
        input, textarea { width:100%; padding:8px; box-sizing:border-box; }
        button { margin-top:12px; padding:8px 16px; }
    </style>
</head>
<body>
    <h1>Formulario Paciente</h1>
    <p>Rellena los datos y pulsa <strong>Actualizar</strong>.</p>

    <form id="pacienteForm" method="post" action="">
        <input type="hidden" id="id" name="id" value="<?= htmlspecialchars($paciente['id'] ?? '') ?>">

        <label for="medico_id">Medico ID</label>
        <input type="number" id="medico_id" name="medico_id" required value="<?= htmlspecialchars($paciente['medico_id'] ?? '') ?>">

        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($paciente['nombre'] ?? '') ?>">

        <label for="motivo">Motivo</label>
        <textarea id="motivo" name="motivo" rows="3" required><?= htmlspecialchars($paciente['motivo'] ?? '') ?></textarea>

        <button type="submit">Actualizar</button>
    </form>

</body>
</html>
