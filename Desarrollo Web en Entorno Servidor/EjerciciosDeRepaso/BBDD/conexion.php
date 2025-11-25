<?php
$host = "localhost";
$db   = "hobby_fotografía";
$user = "root";
$pass = "mysql";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Conexión correcta";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
