<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
    
    <h1>Productos</h1>
    <?php if(!empty($datos['productos'])) { ?>
         <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>nombre</th>
                    <th>stock</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos['productos'] as $produc): ?>
                    <tr>
                        <td><?= htmlspecialchars($produc["nombre"]) ?></td>
                        <td><?= htmlspecialchars($produc["stock"]) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>coches/VerCoche/<?= $produc["id"] ?>">
                                <button type="button">Ver Detalles</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No hay productos disponibles</p>
    <?php } ?>