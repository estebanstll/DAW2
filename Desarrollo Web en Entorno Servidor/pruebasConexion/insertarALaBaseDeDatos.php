<?php
include 'db.php';

$sql = "
    INSERT INTO usuarios (nombre_usuario, contrasena, rol)
    VALUES ('juanperez', '12345segura', 'vendedor');
";

if ($conn->query($sql) === TRUE) {
    echo json_encode([
        "status" => "success",
        "mensaje" => "Usuario insertado correctamente"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "mensaje" => "Error al insertar usuario: " . $conn->error
    ]);
}

$conn->close();
?>
