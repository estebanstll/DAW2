<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal - FoodHub</title>
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
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, rgba(255,107,53,0.1) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(18, 24, 48, 0.95);
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 0 50px rgba(255,107,53,0.3);
            border: 2px solid rgba(255,107,53,0.2);
            position: relative;
        }

        h1 {
            color: #ff6b35;
            margin-bottom: 20px;
            text-align: center;
            font-size: 3em;
            text-transform: uppercase;
            letter-spacing: 5px;
            text-shadow: 0 0 30px rgba(255,107,53,0.5);
        }

        .subtitle {
            text-align: center;
            color: #f7931e;
            margin-bottom: 50px;
            font-size: 1em;
            letter-spacing: 3px;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            list-style: none;
        }

        .category-item {
            position: relative;
            overflow: hidden;
        }

        .category-link {
            display: block;
            background: rgba(10,14,39,0.7);
            color: white;
            text-decoration: none;
            padding: 50px 30px;
            border-radius: 15px;
            text-align: center;
            font-size: 1.2em;
            font-weight: 700;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            border: 2px solid rgba(255,107,53,0.3);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .category-link::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,107,53,0.1);
            transition: width 0.6s, height 0.6s, top 0.6s, left 0.6s;
        }

        .category-link:hover::before {
            width: 500px;
            height: 500px;
            top: -250px;
            left: -250px;
        }

        .category-link:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(255,107,53,0.5);
            border-color: #ff6b35;
        }

        .category-icon {
            font-size: 3em;
            display: block;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .category-name {
            position: relative;
            z-index: 1;
        }

        .no-categories {
            text-align: center;
            padding: 60px 20px;
            color: #f7931e;
            font-size: 1.3em;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }

            h1 {
                font-size: 2em;
            }

            .categories-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (!empty($datos)): ?>
        <h1>🍽️ MENÚ PRINCIPAL</h1>
        <div class="subtitle">[ EXPLORA NUESTRAS CATEGORÍAS ]</div>

        <ul class="categories-grid">
            <?php 
            $icons = ['🍕', '🍔', '🍝', '🍰', '☕', '🍜', '🌮', '🍱', '🥗', '🍣'];
            $iconIndex = 0;
            foreach ($datos as $categoria): 
            ?>
                <li class="category-item">
                    <a href="<?= BASE_URL ?>productos/index/<?= $categoria->getCodCat() ?>" class="category-link">
                        <span class="category-icon"><?= $icons[$iconIndex % count($icons)] ?></span>
                        <span class="category-name"><?= htmlspecialchars($categoria->getNombre()) ?></span>
                    </a>
                </li>
            <?php 
            $iconIndex++;
            endforeach; 
            ?>
        </ul>

    <?php else: ?>
        <h1>MENÚ PRINCIPAL</h1>
        <div class="no-categories">
            <p>⚠️ NO HAY CATEGORÍAS DISPONIBLES</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>
