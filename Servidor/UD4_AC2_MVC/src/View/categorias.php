<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías</title>
</head>
<body>
    <?php include __DIR__ . '/partials/cabecera.php'; ?>
    <h1>Lista de categorías</h1>
    <ul>
        <?php foreach ($categorias as $cat): ?>
            <li>
                <a href="/Categoria/listar/<?= htmlspecialchars($cat->getCodCat()) ?>">
                    <?= htmlspecialchars($cat->getNombre()) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
