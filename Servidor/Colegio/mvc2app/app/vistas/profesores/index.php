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

    <?php if(empty($datos['profesores'])):?>
    <h1>No hay datos que mostrar</h1>

    <?php else: ?>
        <h1>profesores</h1>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Clase</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos['profesores'] as $profesor): ?>
                    <tr>
                        <td><?= htmlspecialchars($profesor['nombre']) ?></td>
                        <td><?= htmlspecialchars($profesor['clase']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>AlumnosController/index/<?= $profesor['id'] ?>">
                                <button type="button">Ver Alumnos</button>
                            </a>
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php endif; ?>