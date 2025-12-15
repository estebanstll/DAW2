<?php
// public/index.php

session_start();

require_once __DIR__ . '/../tools/Config.php';
require_once __DIR__ . '/../tools/Conexion.php';
require_once __DIR__ . '/../src/Usuario.php';

$config = Config::getInstance();
$lang = $config->get('app', 'lang');

$errores = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Forma clásica: usar isset() y if / else
    if (isset($_POST['usuario'])) {
        $user = trim($_POST['usuario']);
    } else {
        $user = '';
    }

    if (isset($_POST['password'])) {
        $pass = trim($_POST['password']);
    } else {
        $pass = '';
    }

    // Forma abreviada (equivalente a lo anterior) usando el operador ??
    // $user = $_POST['usuario']  ?? '';
    // $pass = $_POST['password'] ?? '';

    try {
        $pdo = Conexion::getConexion();
        $usuario = new Usuario();

        $usuario->setUser($user);
        $usuario->setPass($pass);

        if ($usuario->login($pdo)) {
            // Login correcto
            $_SESSION['usuario'] = $user;
            header('Location: principal.php');
            exit;
        } else {
            $errores = "Usuario o contraseña incorrectos";
        }

    } catch (Exception $e) {
        $errores = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Archivo de entrada a la aplicación: formulario de login</title>
</head>

<body>
    <h1>Incluye aquí tu formulario de Login</h1>
    <p>Si el login es correcto redirecciona al usuario a "principal.php", si no, no le dejes pasar.</p>

    <?php if ($errores): ?>
        <p style="color:red;"><?= htmlspecialchars($errores) ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <label>
            Usuario:
            <input type="text" name="usuario" value="">
        </label>
        <br>
        <label>
            Password:
            <input type="password" name="password" value="">
        </label>
        <br>
        <button type="submit">Enviar</button>
    </form>
</body>
ñ

</html>