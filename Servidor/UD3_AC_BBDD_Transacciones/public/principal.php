<?php
require_once "../src/GestorLectura.php";
require_once "../public/transacciones.php"; 

$gestor = new GestorLectura();

if (isset($_GET['borrar_id'])) {
    $id = (int)$_GET['borrar_id'];
    try {
        $gestor->eliminar($id);
    } catch (Exception $e) {
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['transaccion_a'])) {
        ob_start();
        pruebaRegistrosValidos($gestor);
    } elseif (isset($_POST['transaccion_b'])) {
        pruebaRegistrosDuplicados($gestor);
    }
}

// Listar registros
$registros = $gestor->listar();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gestor de Lectura</title>
</head>
<body>
<h1>Gestor de Lectura</h1>


<form method="post" style="margin-bottom:20px;">
    <button type="submit" name="transaccion_a">Transacción A: registros válidos</button>
    <button type="submit" name="transaccion_b">Transacción B: registros duplicados</button>
</form>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Páginas</th>
        <th>Terminado</th>
        <th>Fecha Lectura</th>
        <th>Comentario</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($registros as $r): ?>
        <tr>
            <td><?= $r->id ?></td>
            <td><?= htmlspecialchars($r->titulo_libro) ?></td>
            <td><?= htmlspecialchars($r->autor) ?></td>
            <td><?= $r->paginas ?></td>
            <td><?= $r->terminado ? 'Sí' : 'No' ?></td>
            <td><?= $r->fecha_lectura ?></td>
            <td><?= htmlspecialchars($r->comentario) ?></td>
            <td>
                <a href="?borrar_id=<?= $r->id ?>" onclick="return confirm('¿Seguro que quieres borrar este hobby?');">Borrar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
