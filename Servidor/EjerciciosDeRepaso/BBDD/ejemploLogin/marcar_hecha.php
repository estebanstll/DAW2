<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$idUsuario = $_SESSION['usuario']['id'];

$stmt = $pdo->prepare("UPDATE tareas SET hecha = 1 WHERE id = ? AND id_usuario = ?");
$stmt->execute([$id, $idUsuario]);

header("Location: tareas.php");
