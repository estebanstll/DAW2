<?php
// Configuración de conexión
$host = "localhost";
$user = "root";
$pass = "mysql";
$dbname = "pruebas";

// Crear conexión
$conn = new mysqli($host, $user, $pass, $dbname);

// Comprobar errores de conexión
if ($conn->connect_errno) {
    http_response_code(500);
    die(json_encode([
        "status" => "error",
        "mensaje" => "Error de conexión a la base de datos: " . $conn->connect_error
    ]));
}

// Forzar UTF-8 para evitar problemas con acentos y emojis
if (!$conn->set_charset("utf8mb4")) {
    http_response_code(500);
    die(json_encode([
        "status" => "error",
        "mensaje" => "Error al configurar el conjunto de caracteres UTF-8"
    ]));
}
?>
