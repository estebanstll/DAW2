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
     <form action="<?= BASE_URL ?>/animales/actualizar" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($animal['data'][0]['id'] ?? '') ?>">
        
        <div style="margin-bottom: 15px;">
            <label for="animal">Animal:</label><br>
            <input type="text" id="animal" name="animal" value="<?= htmlspecialchars($animal['data'][0]['animal'] ?? '') ?>" required style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="raza">Raza:</label><br>
            <input type="text" id="raza" name="raza" value="<?= htmlspecialchars($animal['data'][0]['raza'] ?? '') ?>" required style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($animal['data'][0]['nombre'] ?? '') ?>" required style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="personaACargo">Persona a cargo:</label><br>
            <input type="text" id="personaACargo" name="personaACargo" value="<?= htmlspecialchars($animal['data'][0]['personaACargo'] ?? '') ?>" required style="width: 300px; padding: 5px;">
        </div>

        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Modificar animal</button>
    </form>
        <a href="<?= BASE_URL ?>/animales/index">Listado de animales</a>
    <?php endif; ?>