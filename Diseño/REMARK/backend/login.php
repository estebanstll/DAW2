<?php
header('Content-Type: application/json');
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["status" => "error", "mensaje" => "Datos no válidos"]);
    exit;
}

$nombre = trim($data["nombre"] ?? "");
$contrasena = trim($data["contrasena"] ?? "");

if (!$nombre || !$contrasena) {
    echo json_encode(["status" => "error", "mensaje" => "Faltan datos"]);
    exit;
}

$stmt = $conn->prepare("SELECT id, nombre_usuario, email, contrasena FROM usuarios WHERE nombre_usuario = ?");
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "mensaje" => "Usuario no encontrado"]);
    exit;
}

$user = $result->fetch_assoc();
if (password_verify($contrasena, $user["contrasena"])) {
    echo json_encode([
        "status" => "ok",
        "mensaje" => "Inicio de sesión correcto",
        "usuario" => [
            "id" => $user["id"],
            "nombre" => $user["nombre_usuario"],
            "email" => $user["email"]
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "mensaje" => "Contraseña incorrecta"]);
}
$stmt->close();
$conn->close();
?>
