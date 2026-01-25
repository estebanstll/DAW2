<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - FoodHub</title>
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

        .register-container {
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

        .register-container h1 {
            text-align: center;
            margin-bottom: 15px;
            color: #ff6b35;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 0 20px rgba(255, 107, 53, 0.5);
        }

        .register-container .subtitle {
            text-align: center;
            color: #f7931e;
            margin-bottom: 30px;
            font-size: 0.9em;
            letter-spacing: 2px;
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

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: rgba(10, 14, 39, 0.5);
            color: #fff;
            font-family: 'Courier New', monospace;
            resize: none;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 20px rgba(255, 107, 53, 0.4);
        }

        .form-group textarea {
            min-height: 80px;
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
    </style>
</head>
<body>
<div class="register-container">
    <h1>FoodHub</h1>
    <div class="subtitle">Crear Nueva Cuenta</div>

    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>usuarios/procesarRegistro" method="post">
        <div class="form-group">
            <label for="email">Email del Restaurante</label>
            <input type="email" name="email" id="email" required placeholder="tu.restaurante@example.com">
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required placeholder="••••••••">
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirmar Contraseña</label>
            <input type="password" name="password_confirm" id="password_confirm" required placeholder="••••••••">
        </div>

        <div class="form-group">
            <label for="domicilio">Dirección del Restaurante</label>
            <textarea name="domicilio" id="domicilio" required placeholder="Calle, número, código postal..."></textarea>
        </div>

        <div class="form-group">
            <input type="submit" value="Registrarse">
        </div>
    </form>

    <div class="password-requirements">
        <strong>Requisitos de contraseña:</strong><br>
        • Mínimo 6 caracteres<br>
        • Las contraseñas deben coincidir
    </div>

    <div class="back-link">
        <p>¿Ya tienes cuenta? <a href="<?= BASE_URL ?>usuarios/index">Inicia sesión aquí</a></p>
    </div>
</div>
</body>
</html>
