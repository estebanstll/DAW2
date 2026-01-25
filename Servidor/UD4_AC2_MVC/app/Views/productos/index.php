<?php use Tools\Hash; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($infoCategoria->obtenerTitulo()) ?> - FoodHub</title>
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
            padding: 40px 20px;
        }

        body::before {
            content: '';
            position: fixed;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, rgba(255, 107, 53, 0.1) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            background: rgba(18, 24, 48, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(255, 107, 53, 0.3);
            border: 2px solid rgba(255, 107, 53, 0.2);
            position: relative;
        }

        h1 {
            color: #ff6b35;
            margin-bottom: 50px;
            text-align: center;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 4px;
            text-shadow: 0 4px 20px rgba(255, 107, 53, 0.5);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .product-card {
            background: rgba(10, 14, 39, 0.7);
            border-radius: 15px;
            padding: 30px;
            border: 2px solid rgba(255, 107, 53, 0.3);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.1), transparent);
            transition: left 0.7s;
        }

        .product-card:hover::before {
            left: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(255, 107, 53, 0.4);
            border-color: #ff6b35;
        }

        .product-name {
            font-size: 1.5em;
            font-weight: 700;
            color: #ff6b35;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .product-description {
            color: #aaa;
            font-size: 0.9em;
            line-height: 1.6;
            margin-bottom: 25px;
            flex-grow: 1;
        }

        .product-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-item {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid rgba(255, 107, 53, 0.2);
        }

        .info-label {
            font-size: 0.75em;
            color: #f7931e;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 1.3em;
            font-weight: 700;
            color: #fff;
        }

        .product-form {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .product-form input[type="number"] {
            width: 90px;
            padding: 12px;
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 10px;
            font-size: 16px;
            text-align: center;
            background: rgba(10, 14, 39, 0.5);
            color: #fff;
            font-family: 'Courier New', monospace;
            transition: all 0.3s;
        }

        .product-form input[type="number"]:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 15px rgba(255, 107, 53, 0.4);
        }

        .product-form button {
            flex: 1;
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            color: white;
            border: none;
            padding: 14px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            font-size: 1em;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 20px rgba(255, 107, 53, 0.4);
            font-family: 'Courier New', monospace;
        }

        .product-form button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255, 107, 53, 0.6);
            background: linear-gradient(135deg, #f7931e 0%, #ff6b35 100%);
        }

        .product-form button:active {
            transform: translateY(0);
        }

        .no-products {
            text-align: center;
            padding: 80px 20px;
            color: #f7931e;
            font-size: 1.3em;
            letter-spacing: 2px;
        }

        .stock-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .stock-high {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
            border: 1px solid #2ecc71;
        }

        .stock-medium {
            background: rgba(247, 147, 30, 0.2);
            color: #f7931e;
            border: 1px solid #f7931e;
        }

        .stock-low {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            border: 1px solid #e74c3c;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 1.8em;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .product-form {
                flex-direction: column;
            }

            .product-form input[type="number"] {
                width: 100%;
            }

            .product-form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1><?= htmlspecialchars($infoCategoria->obtenerTitulo()) ?></h1>

    <?php if (!empty($listadoProductos)): ?>
        <div class="products-grid">
            <?php foreach ($listadoProductos as $producto): ?>
                <div class="product-card">
                    <div class="product-name">
                        <?= htmlspecialchars($producto->obtenerTitulo()) ?>
                    </div>
                    <div class="product-description">
                        <?= htmlspecialchars($producto->obtenerDetalles()) ?>
                    </div>
                    <div class="product-info">
                        <div class="info-item">
                            <div class="info-label">Peso</div>
                            <div class="info-value"><?= $producto->obtenerMasa() ?> kg</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Disponible</div>
                            <div class="info-value">
                                <?php
                                $stock = $producto->obtenerExistencias();
                                $stockClass = $stock > 10 ? 'stock-high' : ($stock > 5 ? 'stock-medium' : 'stock-low');
                                ?>
                                <span class="stock-badge <?= $stockClass ?>"><?= $stock ?> uds</span>
                            </div>
                        </div>
                    </div>
                    <form class="product-form" action="" method="post"
                          onsubmit="this.action='<?= BASE_URL ?>productos/addToCart/<?= Hash::encode($producto->obtenerId()) ?>/'+this.unidades.value+'/<?= $categoriaIdHash ?>'; return true;">
                        <input type="number"
                               name="unidades"
                               min="1"
                               max="<?= $producto->obtenerExistencias() ?>"
                               value="1"
                               title="Cantidad">
                        <button type="submit">🛒 Añadir</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-products">
            <p>No hay productos en esta categoría</p>
        </div>
    <?php endif; ?>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>
</div>

</body>
</html>





