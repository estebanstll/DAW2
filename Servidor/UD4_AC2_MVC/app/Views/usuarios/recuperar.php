<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar Contraseña - FoodHub</title>
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
            padding: 20px;
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

        .recover-container {
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

        .recover-container h1 {
            text-align: center;
            margin-bottom: 15px;
            color: #ff6b35;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 0 20px rgba(255, 107, 53, 0.5);
        }

        .recover-container .subtitle {
            text-align: center;
            color: #f7931e;
            margin-bottom: 30px;
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

        .form-group input[type="email"] {
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

        .form-group input[type="email"]:focus {
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

        .exito {
            background-color: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            border: 1px solid rgba(46, 204, 113, 0.5);
            text-align: center;
        }

        .back-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 2px solid rgba(255, 107, 53, 0.3);
        }

        .back-link a {
            color: #ff6b35;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .back-link a:hover {
            color: #f7931e;
        }

        .info-text {
            background: rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.3);
            padding: 15px;
            border-radius: 10px;
            font-size: 0.85em;
            color: #aaa;
            margin-bottom: 20px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
<div class="recover-container">
    <h1>FoodHub</h1>
    <div class="subtitle">Recuperar Contraseña</div>

    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (isset($exito)): ?>
        <div class="exito"><?php echo htmlspecialchars($exito); ?></div>
    <?php endif; ?>

    <?php if (!isset($exito)): ?>
        <div class="info-text">
            <strong>¿Olvidaste tu contraseña?</strong><br>
            Introduce tu email de registro y te enviaremos un enlace para restablecer tu contraseña.
        </div>

        <form action="<?= BASE_URL ?>usuarios/procesarRecuperacion" method="post">
            <div class="form-group">
                <label for="email">Email del Restaurante</label>
                <input type="email" name="email" id="email" required placeholder="tu.restaurante@example.com">
            </div>

            <div class="form-group">
                <input type="submit" value="Enviar Enlace de Recuperación">
            </div>
        </form>
    <?php endif; ?>

    <div class="back-link">
        <p><a href="<?= BASE_URL ?>usuarios/index">Volver al inicio de sesión</a></p>
    </div>
</div>
</body>
</html>
