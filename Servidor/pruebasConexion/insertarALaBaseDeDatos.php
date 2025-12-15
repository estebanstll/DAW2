<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $rol = $_POST['rol'] ?? 'comprador';

    // Validar campos mínimos
    if (empty($nombre_usuario) || empty($contrasena)) {
        echo json_encode([
            "status" => "error",
            "mensaje" => "Todos los campos son obligatorios"
        ]);
        exit;
    }

    try {
        $sql = "INSERT INTO usuarios (nombre_usuario, contrasena, rol)
                VALUES (:nombre_usuario, :contrasena, :rol)";

        $stmt = $conn->prepare($sql);

        // Encriptar la contraseña antes de guardar
        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt->execute([
            ':nombre_usuario' => $nombre_usuario,
            ':contrasena' => $hashedPassword,
            ':rol' => $rol
        ]);

        echo json_encode([
            "status" => "success",
            "mensaje" => "Usuario registrado correctamente"
        ]);
    } catch(PDOException $e) {
        echo json_encode([
            "status" => "error",
            "mensaje" => "Error al registrar usuario: " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "mensaje" => "Método no permitido"
    ]);
}
?>
