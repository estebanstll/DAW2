<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$usuario=$_POST['usuario'];
$contraseña=$_POST['password'];


    if ($usuario === 'admin' && $contraseña === '1234') {
        echo "<h2>Bienvenido, $usuario ✅</h2>";
        echo "<p>Inicio de sesión correcto.</p>";
    } else {
        echo "<p style='color:red;'>Usuario o contraseña incorrectos.</p>";
        echo "<a href='index.php'>Volver a intentar</a>";
    }
}
?>