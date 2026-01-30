<html>
<head>
    <meta charset="utf-8">
    <title>API Rest - Pruebas</title>
    <style>body{font-family:Arial;margin:20px} a{display:block;margin:8px 0}</style>
</head>
<body>
    <h1>Pruebas API Rest</h1>
    <a href="<?php echo BASE_URL; ?>Apirestweb/login">Login (obtener token)</a>
    <a href="<?php echo BASE_URL; ?>Apirestweb/categorias">Listado de categorías</a>
    <a href="<?php echo BASE_URL; ?>Apirestweb/productos">Productos por categoría</a>
    <a href="<?php echo BASE_URL; ?>Apirestweb/pedidos">Pedidos por restaurante</a>

    <p>Nota: tras obtener un token en Login, el navegador lo guarda en <strong>localStorage</strong> y se usa en las demás peticiones.</p>
</body>
</html>
