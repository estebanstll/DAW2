

<?php
session_start();
require_once "../tools/conexion.php";

$num= $_GET['categoria'];
$mensaje = "";
$productos = [];

$ventaOk = false;
$codProdPost = null;
$cantidadPost = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codprod'], $_POST['cantidad'])) {
    $codProd = (int)$_POST['codprod'];
    $cantidad = (int)$_POST['cantidad'];
    if ($codProd > 0 && $cantidad > 0) {
        if (!isset($_SESSION['ventas'])) {
            $_SESSION['ventas'] = [];
        }
        if (!isset($_SESSION['ventas'][$codProd])) {
            $_SESSION['ventas'][$codProd] = 0;
        }
        $_SESSION['ventas'][$codProd] += $cantidad;
        $ventaOk = true;
        $codProdPost = $codProd;
        $cantidadPost = $cantidad;
    } else {
        $mensaje = "Cantidad o producto no válidos.";
    }
}

try {
    $pdo = Conexion::getConexion();

    if ($num === null) {
        throw new PDOException("Falta el parámetro 'categoria'.");
    }

    $stmt = $pdo->prepare("SELECT CodProd, Nombre, Descripcion, Peso, Stock FROM Producto WHERE idCategoria = ? ORDER BY Nombre");
    $stmt->execute([$num]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($ventaOk) {
        $nombre = null;
        foreach ($productos as $p) {
            if ((int)$p['CodProd'] === (int)$codProdPost) {
                $nombre = $p['Nombre'];
                break;
            }
        }
        if ($nombre === null) {
            $stmtNombre = $pdo->prepare("SELECT Nombre FROM Producto WHERE CodProd = ? LIMIT 1");
            $stmtNombre->execute([$codProdPost]);
            $fila = $stmtNombre->fetch(PDO::FETCH_ASSOC);
            if ($fila && isset($fila['Nombre'])) {
                $nombre = $fila['Nombre'];
            }
        }
        $nombreMostrar = $nombre !== null ? $nombre : (string)$codProdPost;
        $mensaje = "Producto $nombreMostrar añadido con cantidad $cantidadPost al carrito.";
    }
} catch (PDOException $e) {
    $mensaje = $e->getMessage();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos</title>
</head>
<body>



<?php if ($mensaje): ?>
    <p style="color: <?= (strpos($mensaje, 'añadido') !== false) ? 'green' : 'red' ?>;">
        <?= htmlspecialchars($mensaje) ?>
    </p>
<?php endif; ?>

<h1>Productos</h1>

<?php if (!empty($productos)): ?>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Peso</th>
            <th>Stock</th>
            <th>Cantidad</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($productos as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['Nombre']) ?></td>
                <td><?= htmlspecialchars($p['Descripcion']) ?></td>
                <td><?= htmlspecialchars($p['Peso']) ?></td>
                <td><?= htmlspecialchars($p['Stock']) ?></td>
                <td>
                    <form action="productos.php?categoria=<?= urlencode((string)$num) ?>" method="post" style="margin:0;">
                        <input type="hidden" name="codprod" value="<?= (int)$p['CodProd'] ?>">
                        <input type="number" name="cantidad" value="1" min="1"  required>
                </td>
                <td>
                        <button type="submit">Vender</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay productos disponibles para esta categoría.</p>
<?php endif; ?>







</body>
</html>