<?php

use Tools\Mailer;

echo "<h3>Pedido realizado con éxito. Se enviará un correo de confirmación a: " . $_SESSION["usuarioAutenticado"] . "</h3>";

Mailer::enviar($_SESSION["usuarioAutenticado"], "Pedido realizado correctamente.");

$_SESSION['carrito'] = [];
unset($_SESSION["usuarioAutenticado"]);

echo "<p>La sesión se cerró correctamente, hasta la próxima.</p>";
echo '<a href="' . BASE_URL . 'usuarios/index">Ir a la página de login</a>';
