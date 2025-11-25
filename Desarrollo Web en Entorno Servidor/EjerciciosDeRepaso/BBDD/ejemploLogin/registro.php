<?php
require_once "../conexion.php";

$mensaje = "";

if ($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO usuarios (username, email, password, fecha_registro)
                VALUES (?, ?, ?, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $password]);

        $mensaje = "✔ Usuario registrado correctamente.";
    } catch (PDOException $e) {
        $mensaje = "❌ Error: " . $e->getMessage();
    }
}
?>

<h1>Registro</h1>

<form method="POST">
    Usuario: <input name="username" required><br><br>
    Email: <input name="email" required><br><br>
    Contraseña: <input type="password" name="password" required><br><br>
    <button>Registrarse</button>
</form>

<p><?= $mensaje ?></p>

<a href="login.php">Iniciar sesión</a>
