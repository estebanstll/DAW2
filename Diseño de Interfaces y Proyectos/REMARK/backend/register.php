<?php
// Endpoint: registro de usuario (POST JSON)
include "db.php";

// leer payload
$data = json_decode(file_get_contents("php://input"), true);

$nombre = $conn->real_escape_string($data["nombre"]);
$email = $conn->real_escape_string($data["email"]);
$contrasena = password_hash($data["contrasena"], PASSWORD_BCRYPT);

// Comprobar si ya existe el usuario o el email
$check = $conn->query("SELECT * FROM usuarios WHERE nombre_usuario='$nombre' OR email='$email'");
if ($check->num_rows > 0) {
    echo json_encode(["status" => "error", "mensaje" => "El usuario o correo ya existen"]);
    exit;
}

// Insertar nuevo usuario
$sql = "INSERT INTO usuarios (nombre_usuario, email, contrasena) VALUES ('$nombre', '$email', '$contrasena')";
if ($conn->query($sql)) {
    echo json_encode(["status" => "ok", "mensaje" => "Usuario registrado correctamente"]);
} else {
    echo json_encode(["status" => "error", "mensaje" => "Error al registrar usuario"]);
}
?>
