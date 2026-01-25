<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contraseña Restablecida - FoodHub</title>
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

        .success-container {
            background: rgba(18, 24, 48, 0.95);
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 40px rgba(46, 204, 113, 0.3), inset 0 20px rgba(46, 204, 113, 0.1);
            width: 100%;
            max-width: 500px;
            border: 2px solid rgba(46, 204, 113, 0.3);
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .success-icon {
            font-size: 4em;
            margin-bottom: 20px;
            animation: bounce 0.6s;
        }

        @keyframes bounce {
            0% { transform: translateY(-10px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .success-container h1 {
            color: #2ecc71;
            font-size: 2.2em;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 10px rgba(46, 204, 113, 0.4);
            margin-bottom: 20px;
        }

        .success-container .subtitle {
            color: #aaa;
            margin-bottom: 30px;
            font-size: 0.95em;
            line-height: 1.6;
        }

        .action-button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 20px rgba(46, 204, 113, 0.4);
        }

        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(46, 204, 113, 0.6);
        }

        .info-box {
            background: rgba(46, 204, 113, 0.1);
            border: 1px solid rgba(46, 204, 113, 0.3);
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            color: #aaa;
            font-size: 0.9em;
            line-height: 1.6;
        }

        .info-box strong {
            color: #2ecc71;
        }
    </style>
</head>
<body>
<div class="success-container">
    <div class="success-icon">✓</div>
    <h1>¡Éxito!</h1>
    <div class="subtitle">
        Tu contraseña ha sido restablecida correctamente.<br>
        Ahora puedes iniciar sesión con tu nueva contraseña.
    </div>

    <a href="<?= BASE_URL ?>usuarios/index" class="action-button">Ir a Iniciar Sesión</a>

    <div class="info-box">
        <strong>Nota importante:</strong><br>
        Por tu seguridad, hemos enviado un correo de confirmación a tu dirección de email. Si no realizaste este cambio, contacta con soporte inmediatamente.
    </div>
</div>
</body>
</html>
