<?php
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);
$nombre = $conn->real_escape_string($data["nombre"]);
$contrasena = $data["contrasena"];

$result = $conn->query("SELECT * FROM usuarios WHERE nombre_usuario='$nombre'");

if ($result->num_rows > 0) {
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
} else {
    echo json_encode(["status" => "error", "mensaje" => "Usuario no encontrado"]);
}
?>
