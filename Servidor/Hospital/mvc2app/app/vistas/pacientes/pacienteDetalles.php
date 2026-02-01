<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes</title>
</head>
<body>
    
    <h1>Pacientes</h1>
    <?php if(!empty($datos['Pacientes'])) { ?>
       <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>nombre</th>
                    <th>motivo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos['Pacientes'] as $Paciente): ?>
                    <tr>
                        <td><?= htmlspecialchars($Paciente["nombre"]) ?></td>
                        <td><?= htmlspecialchars($Paciente["motivo"]) ?></td>

                        <td>
                            <a href="<?= BASE_URL ?>PacientesController/eliminar/<?= $Paciente["id"] ?>">
                                <button type="button">Eliminar</button>
                            </a>
                            <a href="<?= BASE_URL ?>PacientesController/form/<?= $Paciente["id"] ?>">
                                <button type="button">Modificar</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No hay Pacientes disponibles</p>
    <?php } ?>