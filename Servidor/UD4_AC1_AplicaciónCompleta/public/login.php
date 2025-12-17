<?php
session_start();
require_once "../tools/conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        $pdo = Conexion::getConexion();

        $stmt = $pdo->prepare(
            "SELECT * FROM restaurante WHERE correo = ? AND Clave = ?"
        );
        $stmt->execute([$correo, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['restaurante_id'] = $user['id'];
            $_SESSION['correo'] = $user['correo'];

            header("Location: categorias.php");
            exit;
        } else {
            $mensaje = "Usuario o contraseña incorrectos.";
        }

    } catch (PDOException $e) {
        $mensaje = $e->getMessage();
    }
}
?>

<h1>Login</h1>

<form method="POST">
    Correo:
    <input type="email" name="username" required><br><br>

    Contraseña:
    <input type="password" name="password" required><br><br>

    <button type="submit">Entrar</button>
</form>

<p><?= htmlspecialchars($mensaje) ?></p>
