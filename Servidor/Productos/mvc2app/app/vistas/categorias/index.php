<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perrera</title>
</head>
<body>
    
    <h1>Categorías</h1>
    <?php if(!empty($datos['categorias'])) { ?>
        <ul>
            <?php foreach($datos['categorias'] as $cat) { ?>
                <li>
                    <a href="<?php echo BASE_URL?>ProductosController/index/<?php echo $cat['id']; ?>">
                        <?php echo htmlspecialchars($cat['nombre']); ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No hay categorías disponibles</p>
    <?php } ?>