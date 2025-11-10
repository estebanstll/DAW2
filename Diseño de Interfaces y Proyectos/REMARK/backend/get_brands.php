<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

$sql = "SELECT nombre FROM etiquetas ORDER BY nombre ASC";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode([]);
    exit;
}

$marcas = [];
while ($row = $result->fetch_assoc()) {
    $marcas[] = $row["nombre"];
}

echo json_encode($marcas, JSON_UNESCAPED_UNICODE);
?>
