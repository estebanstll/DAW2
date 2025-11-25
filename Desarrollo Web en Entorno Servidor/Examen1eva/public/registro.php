<?php
require_once "../tools/conexion.php";

$mensaje = "";

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $sql = "INSERT INTO usuarios (username,  password)
                VALUES (?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $password]);

        $mensaje = "Usuario registrado correctamente.";
    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}
?>

<h1>Registro</h1>

<form method="POST">
    Usuario: <input name="username" required><br><br>
    Contraseña: <input type="password" name="password" required><br><br>
    <button>Registrarse</button>
</form>

<p><?= $mensaje ?></p>

<a href="login.php">Iniciar sesión</a>
