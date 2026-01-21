<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>
    <?php include __DIR__ . '/partials/cabecera.php'; ?>
    <h1>Productos <?= isset($categoria) ? 'de ' . htmlspecialchars($categoria->getNombre()) : '' ?></h1>
    <table border="1" cellspacing="0" cellpadding="6">
        <tr><th>Nombre</th><th>Descripción</th><th>Peso</th><th>Stock</th><th>Comprar</th></tr>
        <?php foreach ($productos as $prod): ?>
            <tr>
                <td><?= htmlspecialchars($prod->getNombre()) ?></td>
                <td><?= htmlspecialchars($prod->getDescripcion()) ?></td>
                <td><?= htmlspecialchars($prod->getPeso()) ?></td>
                <td><?= htmlspecialchars($prod->getStock()) ?></td>
                <td>
                    <form action="/Carrito/agregar" method="POST">
                        <input type="hidden" name="pk" value="<?= htmlspecialchars($prod->getCodProd()) ?>">
                        <input type="number" name="unidades" value="1" min="1">
                        <button type="submit">Comprar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
