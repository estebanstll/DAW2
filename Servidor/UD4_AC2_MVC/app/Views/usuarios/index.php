<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Acceso - FoodHub Digital</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Courier New', monospace;
    background: #0a0e27;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
}

body::before {
    content: '';
    position: absolute;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 107, 53, 0.1) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: gridMove 20s linear infinite;
}

@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

.login-container {
    background: rgba(18, 24, 48, 0.95);
    padding: 50px 40px;
    border-radius: 20px;
    box-shadow: 0 40px rgba(255, 107, 53, 0.3), inset 0 20px rgba(255, 107, 53, 0.1);
    width: 100%;
    max-width: 450px;
    border: 2px solid rgba(255, 107, 53, 0.3);
    position: relative;
    z-index: 1;
}

.login-container h1 {
    text-align: center;
    margin-bottom: 15px;
    color: #ff6b35;
    font-size: 2.5em;
    text-transform: uppercase;
    letter-spacing: 3px;
    text-shadow: 0 20px rgba(255, 107, 53, 0.5);
}

.login-container .subtitle {
    text-align: center;
    color: #f7931e;
    margin-bottom: 40px;
    font-size: 0.9em;
    letter-spacing: 2px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    color: #f7931e;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 0.85em;
    letter-spacing: 1px;
}

.form-group input[type="text"],
.form-group input[type="password"] {
    width: 100%;
    padding: 15px;
    border: 2px solid rgba(255, 107, 53, 0.3);
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s;
    background: rgba(10, 14, 39, 0.5);
    color: #fff;
    font-family: 'Courier New', monospace;
}

.form-group input[type="text"]:focus,
.form-group input[type="password"]:focus {
    outline: none;
    border-color: #ff6b35;
    box-shadow: 0 20px rgba(255, 107, 53, 0.4);
}

.form-group input[type="submit"] {
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
    text-transform: uppercase;
    letter-spacing: 2px;
    box-shadow: 0 5px 20px rgba(255, 107, 53, 0.4);
}

.form-group input[type="submit"]:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(255, 107, 53, 0.6);
}

.error {
    background-color: rgba(231, 76, 60, 0.2);
    color: #ff6b6b;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 25px;
    border: 1px solid rgba(231, 76, 60, 0.5);
    text-align: center;
}
</style>
</head>
<body>
<div class="login-container">
    <h1>FoodHub</h1>
    <div class="subtitle">Acceso de restaurante</div>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>usuarios/autenticar" method="post">
        <div class="form-group">
            <label for="usuario">Email</label>
            <input type="text" name="usuario" id="usuario" required placeholder="usuario@foodhub.com">
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required placeholder="••••••••">
        </div>
        <div class="form-group">
            <input type="submit" value="Entrar">
        </div>
    </form>
</div>
</body>
</html>
