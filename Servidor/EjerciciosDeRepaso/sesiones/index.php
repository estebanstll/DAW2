<?php
session_start();

// ---- Cerrar sesión ----
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

// ---- Procesar login ----
if (isset($_POST['usuario']) && isset($_POST['clave'])) {

    $usuarioCorrecto = "admin";
    $claveCorrecta = "1234";

    if ($_POST['usuario'] === $usuarioCorrecto && $_POST['clave'] === $claveCorrecta) {

        // Crear sesión
        $_SESSION['usuario'] = $_POST['usuario'];

    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

// ---- Si hay sesión, mostrar área privada ----
if (isset($_SESSION['usuario'])) {
    ?>

    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>
    <a href="index.php?logout=1">Cerrar sesión</a>

    <?php
    exit; // Evita mostrar el formulario debajo
}
?>

<!-- FORMULARIO DE LOGIN (si no hay sesión) -->
<h2>Iniciar sesión</h2>

<?php
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>

<form method="POST" action="index.php">
    Usuario: <input type="text" name="usuario"><br><br>
    Contraseña: <input type="password" name="clave"><br><br>
    <button type="submit">Entrar</button>
</form>
