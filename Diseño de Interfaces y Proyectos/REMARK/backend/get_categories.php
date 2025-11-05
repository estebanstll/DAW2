<?php
include "db.php";

$result = $conn->query("SELECT DISTINCT categoria FROM productos");
$categorias = [];

while ($row = $result->fetch_assoc()) {
    $categorias[] = $row["categoria"];
}

echo json_encode($categorias);
?>
