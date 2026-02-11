<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - veterinario</title>
</head>
<body>
    <h1>Login de veterinario</h1>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 10px;">
            <?= $_SESSION['error'] ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="<?= RUTA_URL ?>/UsuariosControlador/validarDatos" method="POST">
        <div style="margin-bottom: 15px;">
            <label for="correo">Correo electrónico:</label><br>
            <input type="email" id="correo" name="correo" required style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="contraseña">Contraseña:</label><br>
            <input type="password" id="contraseña" name="contraseña" required style="width: 300px; padding: 5px;">
        </div>

        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Iniciar Sesión</button>
    </form>
</body>
</html>