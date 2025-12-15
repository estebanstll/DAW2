<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$idUsuario = $_SESSION['usuario']['id'];

$stmt = $pdo->prepare("SELECT * FROM tareas WHERE id_usuario = ?");
$stmt->execute([$idUsuario]);
$tareas = $stmt->fetchAll();
?>

<h1>Mis tareas</h1>

<a href="nueva_tarea.php">➕ Añadir tarea</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>Título</th>
        <th>Descripción</th>
        <th>Fecha</th>
        <th>Hecha</th>
        <th>Acciones</th>
    </tr>

<?php foreach ($tareas as $t): ?>
    <tr>
        <td><?= htmlspecialchars($t['titulo']) ?></td>
        <td><?= htmlspecialchars($t['descripcion']) ?></td>
        <td><?= $t['fecha_creacion'] ?></td>
        <td><?= $t['hecha'] ? "✔" : "❌" ?></td>
        <td>
            <a href="marcar_hecha.php?id=<?= $t['id'] ?>">Marcar hecha</a> |
            <a href="eliminar_tarea.php?id=<?= $t['id'] ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
        </td>
    </tr>
<?php endforeach; ?>

</table>

<a href="panel.php">Volver</a>
