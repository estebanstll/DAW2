<?php
// Devuelve categorías distintas
include "db.php";
error_log("get_categories.php: iniciando consulta de categorías");

$result = $conn->query("SELECT DISTINCT categoria FROM productos");
if ($result === false) {
    error_log("get_categories.php: error en consulta SQL: " . $conn->error);
    echo json_encode([]);
    $conn->close();
    exit;
}

$categorias = [];

while ($row = $result->fetch_assoc()) {
    $categorias[] = $row["categoria"];
}

error_log("get_categories.php: categorías obtenidas = " . count($categorias));
echo json_encode($categorias);
?>
