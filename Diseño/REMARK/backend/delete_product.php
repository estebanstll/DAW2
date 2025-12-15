<?php
header('Content-Type: application/json');
require_once "db.php"; // tu conexión a la BD

$data = json_decode(file_get_contents("php://input"), true);
$nombre = $data["nombre"] ?? "";

if (!$nombre) {
  echo json_encode(["status" => "error", "mensaje" => "Falta el nombre del producto"]);
  exit;
}

$stmt = $conn->prepare("DELETE FROM productos WHERE nombre = ?");
$stmt->bind_param("s", $nombre);

if ($stmt->execute()) {
  echo json_encode(["status" => "ok"]);
} else {
  echo json_encode(["status" => "error", "mensaje" => "No se pudo eliminar"]);
}

$stmt->close();
$conn->close();
?>
