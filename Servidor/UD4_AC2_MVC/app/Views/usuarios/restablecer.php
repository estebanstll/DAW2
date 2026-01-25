<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablecer Contraseña - FoodHub</title>
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

        .reset-container {
            background: rgba(18, 24, 48, 0.95);
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 40px rgba(255, 107, 53, 0.3), inset 0 20px rgba(255, 107, 53, 0.1);
            width: 100%;
            max-width: 500px;
            border: 2px solid rgba(255, 107, 53, 0.3);
            position: relative;
            z-index: 1;
        }

        .reset-container h1 {
            text-align: center;
            margin-bottom: 15px;
            color: #ff6b35;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 0 20px rgba(255, 107, 53, 0.5);
        }

        .reset-container .subtitle {
            text-align: center;
            color: #f7931e;
            margin-bottom: 30px;
            font-size: 0.9em;
            letter-spacing: 2px;
        }

        .user-email {
            background: rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.3);
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            color: #aaa;
            margin-bottom: 25px;
            font-size: 0.9em;
        }

        .user-email strong {
            color: #ff6b35;
        }

        .form-group {
            margin-bottom: 20px;
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

        .form-group input[type="password"],
        .form-group input[type="hidden"] {
            width: 100%;
            padding: 12px;
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: rgba(10, 14, 39, 0.5);
            color: #fff;
            font-family: 'Courier New', monospace;
        }

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

        .password-requirements {
            background: rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.3);
            padding: 15px;
            border-radius: 10px;
            font-size: 0.85em;
            color: #aaa;
            margin-top: 20px;
        }

        .password-requirements strong {
            color: #ff6b35;
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
    </style>
</head>
<body>
<div class="reset-container">
    <h1>FoodHub</h1>
    <div class="subtitle">Restablecer Contraseña</div>

    <div class="user-email">
        Email: <strong><?php echo htmlspecialchars($email); ?></strong>
    </div>

    <form action="<?= BASE_URL ?>usuarios/procesarRestablecer" method="post">
        <input type="hidden" name="usuario_hash" value="<?php echo htmlspecialchars($usuarioHash); ?>">

        <div class="form-group">
            <label for="password">Nueva Contraseña</label>
            <input type="password" name="password" id="password" required placeholder="••••••••">
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirmar Nueva Contraseña</label>
            <input type="password" name="password_confirm" id="password_confirm" required placeholder="••••••••">
        </div>

        <div class="form-group">
            <input type="submit" value="Restablecer Contraseña">
        </div>
    </form>

    <div class="password-requirements">
        <strong>Requisitos de contraseña:</strong><br>
        • Mínimo 6 caracteres<br>
        • Las contraseñas deben coincidir
    </div>

    <div class="back-link">
        <p><a href="<?= BASE_URL ?>usuarios/index">Volver al inicio de sesión</a></p>
    </div>
</div>
</body>
</html>
