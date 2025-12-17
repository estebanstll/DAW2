<?php
session_start();
require_once __DIR__ . '/../tools/conexion.php';
require_once __DIR__ . '/eliminar_carrito.php';

$mensaje = '';
$error = '';
$items = $_SESSION['ventas'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    // Tomar las cantidades directamente del carrito de la sesión
    $compra = [];
    foreach (($_SESSION['ventas'] ?? []) as $cod => $cant) {
        $codInt = (int)$cod;
        $cantInt = (int)$cant;
        if ($codInt > 0 && $cantInt >= 0) {
            $compra[$codInt] = $cantInt;
        }
    }

    // Considerar solo los productos con cantidad positiva para comprar
    $codigosCompraPositiva = array_keys(array_filter($compra, function($q){ return (int)$q > 0; }));

    try {
        $pdo = Conexion::getConexion();

        // Vender sin comprobar stock: simplemente descontar las cantidades solicitadas
        $pdo->beginTransaction();

        $stmtUpd = $pdo->prepare('UPDATE Producto SET Stock = Stock - :cantidad WHERE CodProd = :cod');
        foreach ($codigosCompraPositiva as $codProd) {
            $cantidad = (int)$compra[$codProd];
            if ($cantidad <= 0) { continue; }
            $stmtUpd->execute([
                ':cantidad' => $cantidad,
                ':cod' => $codProd,
            ]);
        }

        $pdo->commit();

        vaciarCarrito();
        $items = [];
        $mensaje = 'Compra realizada correctamente. El stock ha sido actualizado.';
    } catch (Throwable $e) {
        if (isset($pdo) && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $error = 'Error al realizar la compra: ' . $e->getMessage();
    }
}

$productos = [];
if (!empty($items)) {
    try {
        $pdo = Conexion::getConexion();
        $codigos = array_keys($items);

        $placeholders = implode(',', array_fill(0, count($codigos), '?'));
        $sql = "SELECT CodProd, Nombre, Stock FROM Producto WHERE CodProd IN ($placeholders) ORDER BY Nombre";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($codigos));
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        $error = 'Error al cargar productos del carrito: ' . $e->getMessage();
    }
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmar pedido</title>
    <style>
        table { border-collapse: collapse; }
        th, td { padding: 6px 10px; }
    </style>
    </head>
<body>

<h1>Confirmar pedido</h1>

<p>
    <a href="index.php">Ir al índice</a>
    |
    <a href="carrito.php">Ir al carrito</a>
    |
    <a href="categorias.php">Ir a categorías</a>
    |
    <a href="logout.php">Logout</a>
  </p>

<?php if ($mensaje): ?>
    <p style="color: green;"><?= htmlspecialchars($mensaje) ?></p>
<?php endif; ?>
<?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if (!empty($productos)): ?>
        <table border="1" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Stock actual</th>
                <th>Cantidad en carrito</th>
                <th>Quitar cantidad</th>
                <th>Eliminar</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($productos as $p):
                $cod = (int)$p['CodProd'];
                $cantCarrito = (int)($items[$cod] ?? 0);
                ?>
                <tr>
                    <td><?= $cod ?></td>
                    <td><?= htmlspecialchars($p['Nombre']) ?></td>
                    <td><?= htmlspecialchars((string)$p['Stock']) ?></td>
                    <td><?= $cantCarrito ?></td>

                    <td>
                        <form action="eliminar_carrito.php" method="get" style="display:inline; margin-right:6px;">
                            <input type="hidden" name="accion" value="restar">
                            <input type="hidden" name="codprod" value="<?= $cod ?>">
                            <input type="hidden" name="return" value="confirmar_pedido.php">
                            <input type="number" name="cantidad" value="1" min="1" max="<?= max(1, $cantCarrito) ?>" style="width:60px;">
                            <button type="submit">Quitar</button>
                        </form>
                    </td>
                    <td>
                        <a href="eliminar_carrito.php?accion=eliminar&codprod=<?= $cod ?>&return=confirmar_pedido.php">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <form id="comprarForm" method="post" action="confirmar_pedido.php" style="margin-top:10px;">
            <button type="submit" name="comprar" value="1">Comprar</button>
            <a href="eliminar_carrito.php?accion=vaciar&return=confirmar_pedido.php" style="margin-left:10px;">Vaciar carrito</a>
        </form>
<?php else: ?>
    <p>No hay productos en el carrito.</p>
<?php endif; ?>

</body>
</html>
