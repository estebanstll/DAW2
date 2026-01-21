<header style="border-bottom:1px solid #ccc; padding:10px 0; margin-bottom:20px;">
    <?php if (isset($_SESSION['usuario'])): ?>
        <span>Usuario: <strong><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></strong></span>
        &nbsp; | &nbsp;
        <a href="/Categoria/categorias">Categorías</a>
        &nbsp; | &nbsp;
        <a href="/Carrito/listar">Ver carrito</a>
        &nbsp; | &nbsp;
        <a href="/Restaurante/logout">Cerrar sesión</a>
    <?php else: ?>
        <a href="/login">Iniciar sesión</a>
    <?php endif; ?>
</header>
