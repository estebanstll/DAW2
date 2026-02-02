<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perrera</title>
</head>
<body>

    <?php if(empty($datos['alumnos'])):?>
    <h1>No hay datos que mostrar</h1>

    <?php else: ?>
        <h1>alumnos</h1>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>apellidos</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos['alumnos'] as $alumno): ?>
                    <tr>
                        <td><?= htmlspecialchars($alumno['nombre']) ?></td>
                        <td><?= htmlspecialchars($alumno['apellidos']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>NotasController/index/<?= $alumno['id'] ?>">
                                <button type="button">Ver notas</button>
                            </a>
                            <a href="<?= BASE_URL ?>NotasController/create/<?= $alumno['id'] ?>">
                                <button type="button">Nueva nota</button>
                            </a>
                            <a href="<?= BASE_URL ?>/AlumnosController/update/<?= $alumno['id'] ?>">
                                <button type="button">Modificar Datos</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php endif; ?>