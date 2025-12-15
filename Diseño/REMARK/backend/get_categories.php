<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

$sql = "SELECT DISTINCT categoria FROM productos WHERE categoria IS NOT NULL AND categoria <> '' ORDER BY categoria ASC";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode([]);
    exit;
}

$categorias = [];
while ($row = $result->fetch_assoc()) {
    $categorias[] = $row["categoria"];
}

echo json_encode($categorias, JSON_UNESCAPED_UNICODE);
?>
