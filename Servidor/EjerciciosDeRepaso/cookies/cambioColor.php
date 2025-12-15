<?php
// ---- Recibir el color del formulario ----
if (isset($_POST['color'])) {
    $color = $_POST['color'];

    // Guardar cookie por 1 hora
    setcookie("color", $color, time() + 3600);

    // Recargar para que la cookie se aplique
    header("Location: cambioColor.php");
    exit;
}

// ---- Leer cookie si existe ----
$colorFondo = isset($_COOKIE['color']) ? $_COOKIE['color'] : "white";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar color de fondo</title>
</head>
<body style="background-color: <?php echo $colorFondo; ?>;">

<h2>Selecciona un color</h2>

<form method="POST" action="cambioColor.php">
    Color: <input type="text" name="color" placeholder="red, blue, green..."><br><br>
    <button type="submit">Guardar color</button>
</form>

<p>Color actual: <?php echo htmlspecialchars($colorFondo); ?></p>

</body>
</html>
