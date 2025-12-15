<?php
header('Content-Type: application/json');
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["status" => "error", "mensaje" => "Datos no válidos"]);
    exit;
}

$nombre = trim($data["nombre"] ?? "");
$email = trim($data["email"] ?? "");
$contrasena = trim($data["contrasena"] ?? "");

if (!$nombre || !$email || !$contrasena) {
    echo json_encode(["status" => "error", "mensaje" => "Faltan datos"]);
    exit;
}

// Hashear contraseña
$hash = password_hash($contrasena, PASSWORD_BCRYPT);

// Comprobar duplicados
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ? OR email = ?");
$stmt->bind_param("ss", $nombre, $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["status" => "error", "mensaje" => "El usuario o correo ya existen"]);
    exit;
}
$stmt->close();

// Insertar usuario
$stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, email, contrasena) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $email, $hash);

if ($stmt->execute()) {
    echo json_encode(["status" => "ok", "mensaje" => "Usuario registrado correctamente"]);
} else {
    echo json_encode(["status" => "error", "mensaje" => "Error al registrar usuario"]);
}
$stmt->close();
$conn->close();
?>
