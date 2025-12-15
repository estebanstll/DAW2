<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION['usuario'];
?>

<h1>Bienvenido, <?= $usuario['username'] ?></h1>

<a href="tareas.php">📋 Ver mis tareas</a><br><br>

<a href="logout.php">Cerrar sesión</a>
