<style>
    .footer {
        margin-top: 50px;
        padding-top: 30px;
        border-top: 2px solid rgba(255,107,53,0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .footer-user {
        color: #aaa;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9em;
    }

    .footer-user span {
        color: #ff6b35;
        font-weight: 700;
    }

    .footer-nav {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .footer-nav a {
        text-decoration: none;
        padding: 12px 25px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85em;
        border: 2px solid;
    }

    .footer-nav a.home-link {
        background: rgba(255,107,53,0.1);
        color: #ff6b35;
        border-color: rgba(255,107,53,0.3);
    }

    .footer-nav a.cart-link {
        background: rgba(46,204,113,0.1);
        color: #2ecc71;
        border-color: rgba(46,204,113,0.3);
    }

    .footer-nav a.logout-link {
        background: rgba(231,76,60,0.1);
        color: #e74c3c;
        border-color: rgba(231,76,60,0.3);
    }

    .footer-nav a:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    }

    .footer-nav a.home-link:hover {
        background: #ff6b35;
        color: white;
        box-shadow: 0 5px 20px rgba(255,107,53,0.5);
    }

    .footer-nav a.cart-link:hover {
        background: #2ecc71;
        color: white;
        box-shadow: 0 5px 20px rgba(46,204,113,0.5);
    }

    .footer-nav a.logout-link:hover {
        background: #e74c3c;
        color: white;
        box-shadow: 0 5px 20px rgba(231,76,60,0.5);
    }

    @media (max-width: 768px) {
        .footer {
            flex-direction: column;
            text-align: center;
        }

        .footer-nav {
            justify-content: center;
            width: 100%;
        }

        .footer-nav a {
            flex: 1;
            min-width: 120px;
        }
    }
</style>

<div class="footer">
    <div class="footer-user">
        » SESIÓN ACTIVA: <span><?php echo htmlspecialchars($_SESSION["usuarioAutenticado"]); ?></span>
    </div>
    <nav class="footer-nav">
        <a href="<?php echo BASE_URL; ?>categorias/index" class="home-link">🏠 MENÚ</a>
        <a href="<?php echo BASE_URL; ?>productos/mostrarCarrito" class="cart-link">🛒 CARRITO</a>
        <a href="<?php echo BASE_URL; ?>usuarios/logout" class="logout-link">🚪 SALIR</a>
    </nav>
</div>