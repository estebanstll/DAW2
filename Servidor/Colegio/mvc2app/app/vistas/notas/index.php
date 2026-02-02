<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>notas</title>
</head>
<body>

    <?php if(empty($datos['notas'])):?>
    <h1>No hay datos que mostrar</h1>

    <?php else: ?>
        <h1>notas del alumno</h1>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Asignatura</th>
                    <th>Nota</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos['notas'] as $nota): ?>
                    <tr>
                        <td><?= htmlspecialchars($nota['asignatura']) ?></td>
                        <td><?= htmlspecialchars($nota['nota']) ?></td>
                        <td>
                            
                            <a href="<?= BASE_URL ?>NotasController/update/<?= $nota['id'] ?>">
                                <button type="button">Modificar</button>
                            </a>
                            <a href="<?= BASE_URL ?>/NotasController/delete/<?= $nota['id'] ?>">
                                <button type="button">Eliminar</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php endif; ?>