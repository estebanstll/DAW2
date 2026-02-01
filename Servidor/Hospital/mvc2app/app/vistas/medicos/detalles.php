<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicos</title>
</head>
<body>
    
    <h1>Categorías</h1>
    <?php if(!empty($datos['Medicos'])) { ?>
       <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>nombre</th>
                    <th>correo</th>
                    <th>Especialidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos['Medicos'] as $medico): ?>
                    <tr>
                        <td><?= htmlspecialchars($medico["nombre"]) ?></td>
                        <td><?= htmlspecialchars($medico["correo"]) ?></td>
                        <td><?= htmlspecialchars($medico["especialidad"]) ?></td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No hay categorías disponibles</p>
    <?php } ?>