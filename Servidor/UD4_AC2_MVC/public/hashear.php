<?php
// Script de diagnóstico y actualización de contraseñas

require_once "../vendor/autoload.php";

use Tools\Conexion;

$contrasena = "1234";

// Mostrar diferentes hashes para comparar
echo "<h3>Diagnóstico de Hashes</h3>";
echo "<p><strong>Contraseña:</strong> $contrasena</p>";

$hash1 = sha1($contrasena . "foodhub_password_salt_2026");
echo "<p><strong>Hash con salt 'foodhub_password_salt_2026':</strong> $hash1</p>";

$hash2 = sha1($contrasena);
echo "<p><strong>Hash simple (sin salt):</strong> $hash2</p>";

// Obtener el hash actual de la BD
$bd = Conexion::getConexion();
$consulta = "SELECT Correo, Clave FROM restaurantes LIMIT 1";
$stmt = $bd->prepare($consulta);
$stmt->execute();
$row = $stmt->fetch();

if ($row) {
    echo "<p><strong>Hash actual en BD:</strong> " . $row["Clave"] . "</p>";
    echo "<p><strong>Email:</strong> " . $row["Correo"] . "</p>";
    
    // Comparar
    if ($row["Clave"] === $hash1) {
        echo "<p style='color:green'>✓ El hash coincide con salt</p>";
    } elseif ($row["Clave"] === $hash2) {
        echo "<p style='color:green'>✓ El hash coincide sin salt</p>";
    } elseif ($row["Clave"] === $contrasena) {
        echo "<p style='color:orange'>⚠ La contraseña está en texto plano</p>";
    } else {
        echo "<p style='color:red'>✗ El hash NO coincide - probablemente usa otro salt</p>";
    }
}

echo "<hr><h3>¿Quieres actualizar las contraseñas?</h3>";
echo "<p>Añade ?actualizar=1 a la URL para actualizar todas las contraseñas a hash con salt</p>";

if (isset($_GET['actualizar']) && $_GET['actualizar'] == '1') {
    $consulta = "UPDATE restaurantes SET Clave = :hash WHERE Clave = '1234' OR LENGTH(Clave) < 20";
    $stmt = $bd->prepare($consulta);
    $stmt->bindParam(":hash", $hash1);
    $stmt->execute();
    echo "<p style='color:green'>✓ Contraseñas actualizadas con hash: $hash1</p>";
}
?>
