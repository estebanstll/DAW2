<?php
session_start();
require_once "../tools/conexion.php";

$mensaje = "";

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user ) {
            $_SESSION['usuario'] = $user;
            header("Location: ListadoMascotas.php");
            exit;
        } else {
            $mensaje = "Usuario o contraseña incorrectos.";
        }

    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}
?>

<h1>Login</h1>

<form method="POST">
    Usuario: <input name="username" required><br><br>
    Contraseña: <input type="password" name="password" required><br><br>
    <button>Entrar</button>
</form>

<p><?= $mensaje ?></p>

<a href="registro.php">Crear cuenta</a>
