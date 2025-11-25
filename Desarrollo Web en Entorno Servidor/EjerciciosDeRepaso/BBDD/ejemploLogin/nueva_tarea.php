<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$idUsuario = $_SESSION['usuario']['id'];
$mensaje = "";

if ($_POST) {
    try {
        $sql = "INSERT INTO tareas (id_usuario, titulo, descripcion, fecha_creacion)
                VALUES (?, ?, ?, CURDATE())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idUsuario, $_POST['titulo'], $_POST['descripcion']]);

        header("Location: tareas.php");
        exit;

    } catch (PDOException $e) {
        $mensaje = "❌ Error: " . $e->getMessage();
    }
}
?>

<h1>Nueva tarea</h1>

<form method="POST">
    Título: <input name="titulo" required><br><br>
    Descripción:<br>
    <textarea name="descripcion"></textarea><br><br>
    <button>Guardar</button>
</form>

<p><?= $mensaje ?></p>

<a href="tareas.php">Volver</a>
