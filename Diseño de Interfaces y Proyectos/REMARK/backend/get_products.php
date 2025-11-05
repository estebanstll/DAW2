<?php
header("Content-Type: application/json; charset=utf-8");
include "db.php";

$sql = "SELECT nombre, categoria, marca, precio, imagen FROM productos";
$result = $conn->query($sql);

$productos = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

echo json_encode($productos, JSON_UNESCAPED_UNICODE);
$conn->close();
?>
