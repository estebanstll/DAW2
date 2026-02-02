<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Perrera</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 10px;">
            <?= $_SESSION['error'] ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>usuario/crearUsuario" method="POST">
        <div style="margin-bottom: 15px;">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="correo">Correo electrónico:</label><br>
            <input type="email" id="correo" name="correo" required style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="contraseña">Contraseña:</label><br>
            <input type="password" id="contraseña" name="contraseña" required style="width: 300px; padding: 5px;">
        </div>

        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Registrar usuario</button>
    </form>
</body>
</html>