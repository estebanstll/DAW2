<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="/Restaurante/login" method="POST">
        <label>Usuario</label>
        <input type="text" name="user" value="" required>
        <br>
        <label>Clave</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Entrar</button>
    </form>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</body>
</html>
