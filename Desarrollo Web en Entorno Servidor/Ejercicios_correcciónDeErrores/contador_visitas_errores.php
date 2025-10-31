<?php


// --- 1. Borrar cookies si se pide por parámetro ---
if (isset($_GET['borrar'])) {
    // Se "borran" las cookies estableciendo una expiración en el pasado
    setcookie("visitas", "", time() - 3600);
    setcookie("lang", "", time() - 3600);
    
    echo "Cookies 'visitas' y 'lang' borradas.<br>";
    echo "<a href='contador_visitas_errores.php'>Volver al inicio</a>";
    exit; // Detiene la ejecución
}

// --- 2. Procesar formulario de cambio de idioma ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['lang'])) {
    $lang = $_POST['lang'];

    // Validar que el idioma seleccionado exista
    $idiomas_validos = ['es', 'en', 'fr', 'de'];
    if (!in_array($lang, $idiomas_validos)) {
        $lang = 'es'; // valor por defecto
    }

    // Crear/actualizar cookie de idioma (1 día de duración)
    setcookie('lang', $lang, time() + 3600 * 24);

    // Recargar la página para aplicar el cambio
    header("Location: contador_visitas_errores.php");
    exit;
}

// --- 3. Comprobar o crear cookie de idioma ---
if (!isset($_COOKIE['lang'])) {
    // Si no existe cookie de idioma, crearla con valor por defecto
    setcookie('lang', 'es', time() + 3600 * 24);
    $lang = 'es';
} else {
    $lang = $_COOKIE['lang'];
}

// --- 4. Comprobar o crear cookie de visitas ---
if (!isset($_COOKIE['visitas'])) {
    // Primera visita
    setcookie('visitas', '1', time() + 3600 * 24);
    $visitas = 1;
    $mensaje_visitas = "Bienvenido por primera vez";
} else {
    // Incrementar el contador de visitas
    $visitas = (int)$_COOKIE['visitas'] + 1;
    setcookie('visitas', $visitas, time() + 3600 * 24);
    $mensaje_visitas = "Bienvenido por $visitas vez";
}

// --- 5. Enlace para borrar cookies ---
$enlace_borrar = "<br><a href='contador_visitas_errores.php?borrar=1'>Borrar cookies</a>";

?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="utf-8">
    <title>Contador de Visitas con Idioma</title>
   
</head>
<body>

<?php
// --- 6. Mensajes traducidos ---
$mensajes = [
    'es' => 'Hola, bienvenido a mi página',
    'en' => 'Hello, welcome to my page',
    'fr' => 'Bonjour, bienvenue sur ma page',
    'de' => 'Hallo, willkommen auf meiner Seite'
];

// Mostrar saludo y contador
echo "<p><strong>$mensaje_visitas</strong></p>";
echo "<h1>" . $mensajes[$lang] . "</h1>";

// Mostrar enlace para borrar cookies
echo $enlace_borrar;
?>

<form method="post">
    <label for="lang">Selecciona tu idioma:</label><br>
    <select name="lang" id="lang">
        <option value="es" <?= ($lang=="es") ? "selected" : "" ?>>Español (ES)</option>
        <option value="en" <?= ($lang=="en") ? "selected" : "" ?>>English (EN)</option>
        <option value="fr" <?= ($lang=="fr") ? "selected" : "" ?>>Français (FR)</option>
        <option value="de" <?= ($lang=="de") ? "selected" : "" ?>>Deutsch (DE)</option>
    </select>
    <br>
    <input type="submit" value="Cambiar idioma">
</form>

</body>
</html>
