<?php
require_once '../src/GestorLectura.php';

try {
    $gestor = new GestorLectura();
    $lecturas = $gestor->listar();
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Lecturas</title>

</head>
<body>
    <h1>Lista de Lecturas</h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php elseif (empty($lecturas)): ?>
        <p style="text-align:center;">No hay registros para mostrar.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Páginas</th>
                    <th>Terminado</th>
                    <th>Fecha Lectura</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lecturas as $lectura): ?>
                    <tr>
                        <td><?= htmlspecialchars($lectura->id) ?></td>
                        <td><?= htmlspecialchars($lectura->titulo_libro) ?></td>
                        <td><?= htmlspecialchars($lectura->autor) ?></td>
                        <td><?= htmlspecialchars($lectura->paginas) ?></td>
                        <td><?= $lectura->terminado ? 'Sí' : 'No' ?></td>
                        <td><?= htmlspecialchars($lectura->fecha_lectura ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
