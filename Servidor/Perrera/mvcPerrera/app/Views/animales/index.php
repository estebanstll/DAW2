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

    <?php if(empty($animales['data']) || $animales['status'] !== 200):?>
    <h1>No hay datos que mostrar</h1>

    <?php else: ?>
        <h1>Animales Disponibles</h1>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Animal</th>
                    <th>Raza</th>
                    <th>Nombre</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($animales['data'] as $animal): ?>
                    <tr>
                        <td><?= htmlspecialchars($animal['animal']) ?></td>
                        <td><?= htmlspecialchars($animal['raza']) ?></td>
                        <td><?= htmlspecialchars($animal['nombre']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/animales/verDetalles/<?= $animal['id'] ?>">
                                <button type="button">Ver Detalles</button>
                            </a>
                            <a href="<?= BASE_URL ?>/animales/eliminar/<?= $animal['id'] ?>">
                                <button type="button">Eliminar Animal</button>
                            </a>
                            <a href="<?= BASE_URL ?>/animales/update/<?= $animal['id'] ?>">
                                <button type="button">Modificar Datos</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php endif; ?>