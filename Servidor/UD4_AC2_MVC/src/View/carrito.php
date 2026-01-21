<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
</head>
<body>
    <?php include __DIR__ . '/partials/cabecera.php'; ?>
    <h1>Carrito de la compra</h1>
    <?php if (empty($items)): ?>
        <p>El carrito está vacío.</p>
    <?php else: ?>
        <table border="1" cellspacing="0" cellpadding="6">
            <tr><th>Nombre</th><th>Unidades</th><th>Actualizar</th></tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item->getProducto()->getNombre()) ?></td>
                    <td><?= htmlspecialchars($item->getUnidades()) ?></td>
                    <td>
                        <form action="/Carrito/actualizar" method="POST">
                            <input type="hidden" name="pk" value="<?= htmlspecialchars($item->getProducto()->getCodProd()) ?>">
                            <input type="number" name="unidades" value="<?= htmlspecialchars($item->getUnidades()) ?>" min="0">
                            <button type="submit">Actualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <a href="/Pedido/crear">Realizar pedido</a>
    <?php endif; ?>
</body>
</html>
