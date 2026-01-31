<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>concesionario</title>
</head>
<body>

    <?php if(empty($coches)):?>
    <h1>no hay datos que mostrar</h1>

    <?php else: ?>
        <h1>Coches Disponibles</h1>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($coches as $coche): ?>
                    <tr>
                        <td><?= htmlspecialchars($coche->getMarca()) ?></td>
                        <td><?= htmlspecialchars($coche->getModelo()) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>coches/VerCoche/<?= $coche->getId() ?>">
                                <button type="button">Ver Detalles</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php endif; ?>