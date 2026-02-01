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

    

    <?php if(empty($animal['data']) || $animal['status'] !== 200):?>
    <h1>animal no encontrado</h1>

    <?php else: ?>
        <h1>Animales </h1>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Animal</th>
                    <th>Raza</th>
                    <th>Nombre</th>
                    <th>Persona a cargo</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($animal['data'] as $animalDet): ?>
                    <tr>
                        <td><?= htmlspecialchars($animalDet['animal']) ?></td>
                        <td><?= htmlspecialchars($animalDet['raza']) ?></td>
                        <td><?= htmlspecialchars($animalDet['nombre']) ?></td>
                        <td><?= htmlspecialchars($animalDet['personaACargo']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?= BASE_URL ?>/animales/index">Listado de animales</a>
    <?php endif; ?>