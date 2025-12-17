<?php
session_start();
require_once "../tools/conexion.php";

$mensaje = "";
$categorias = [];

try {
    $pdo = Conexion::getConexion();

    $stmt = $pdo->prepare("SELECT idCategoria, Nombre, Descripcion FROM Categoria ORDER BY Nombre");
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensaje = $e->getMessage();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categorias</title>
</head>
<body>
<p>
    <a href="logout.php">Logout</a>
 </p>
<?php if ($mensaje): ?>
    <p style="color:red;">Error: <?= htmlspecialchars($mensaje) ?></p>
<?php endif; ?>

<h1>Categorías</h1>

<?php if (!empty($categorias)): ?>
    <ul>
        <?php foreach ($categorias as $cat): ?>
            <li>
                <a href="productos.php?categoria=<?= urlencode($cat['idCategoria']) ?>">
                    <?= htmlspecialchars($cat['Nombre']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay categorías disponibles.</p>
<?php endif; ?>
</body>
</html>
