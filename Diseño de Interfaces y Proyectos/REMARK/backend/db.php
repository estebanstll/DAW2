<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root"; 
$pass = ""; 
$dbname = "remark_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
