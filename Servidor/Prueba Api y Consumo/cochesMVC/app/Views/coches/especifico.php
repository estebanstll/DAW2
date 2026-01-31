<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Coche</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .detalle {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #007bff;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .valor {
            color: #333;
            margin-left: 10px;
        }
        .boton {
            text-align: center;
            margin-top: 30px;
        }
        a {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detalle del Coche</h1>
        
        <?php if($idCoche): ?>
            <div class="detalle">
                <span class="label">ID:</span>
                <span class="valor"><?= htmlspecialchars($idCoche->getId()) ?></span>
            </div>
            
            <div class="detalle">
                <span class="label">Marca:</span>
                <span class="valor"><?= htmlspecialchars($idCoche->getMarca()) ?></span>
            </div>
            
            <div class="detalle">
                <span class="label">Modelo:</span>
                <span class="valor"><?= htmlspecialchars($idCoche->getModelo()) ?></span>
            </div>
            
            <div class="detalle">
                <span class="label">Año:</span>
                <span class="valor"><?= htmlspecialchars($idCoche->getAño()) ?></span>
            </div>
            
            <div class="detalle">
                <span class="label">Precio:</span>
                <span class="valor">$<?= htmlspecialchars(number_format($idCoche->getPrecio(), 2)) ?></span>
            </div>
            
            <div class="boton">
                <a href="<?= BASE_URL ?>">Volver a Coches</a>
            </div>
        <?php else: ?>
            <p>No se encontró el coche.</p>
            <div class="boton">
                <a href="<?= BASE_URL ?>">Volver a Coches</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
