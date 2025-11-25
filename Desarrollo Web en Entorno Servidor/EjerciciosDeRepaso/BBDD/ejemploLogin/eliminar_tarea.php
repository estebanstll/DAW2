<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$idUsuario = $_SESSION['usuario']['id'];

$stmt = $pdo->prepare("DELETE FROM tareas WHERE id = ? AND id_usuario = ?");
$stmt->execute([$id, $idUsuario]);

header("Location: tareas.php");
