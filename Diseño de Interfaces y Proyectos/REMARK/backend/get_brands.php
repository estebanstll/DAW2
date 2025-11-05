<?php
include "db.php";

$result = $conn->query("SELECT DISTINCT marca FROM productos");
$marcas = [];

while ($row = $result->fetch_assoc()) {
    $marcas[] = $row["marca"];
}

echo json_encode($marcas);
?>
