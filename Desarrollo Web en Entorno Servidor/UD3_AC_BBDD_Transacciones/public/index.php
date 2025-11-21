<?php
session_start();
require_once '../tools/Conexion.php';

$mensaje = "";

// Procesar login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        try {
            $conexion = new Conexion();
            $pdo = $conexion->obtenerConexion();

            // Busca usuario por nombre
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username AND password_hash = :pass");
            $stmt->execute([
                ':username' => $username,
                ':pass' => $password
            ]);

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                // Login correcto
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                header('Location: principal.php');
                exit;
            } else {
                $mensaje = "Usuario o contraseña incorrectos.";
            }

        } catch (Exception $e) {
            $mensaje = "Error: " . $e->getMessage();
        }

    } else {
        $mensaje = "Debes completar ambos campos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<?php if ($mensaje): ?>
    <p style="color:red;"><?= htmlspecialchars($mensaje) ?></p>
<?php endif; ?>

<form method="post">
    <label>Usuario: <input type="text" name="username" required></label><br><br>
    <label>Contraseña: <input type="password" name="password" required></label><br><br>
    <button type="submit">Entrar</button>
</form>

</body>
</html>
