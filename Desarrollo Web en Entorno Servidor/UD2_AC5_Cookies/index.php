<?php
$idiomas = [
    "es" => "Selección de idioma",
    "en" => "Language Selection",
    "fr" => "Sélection de la langue",
    "de" => "Sprachauswahl",
    "it" => "Selezione della lingua"
];


if (isset($_POST['idioma'])) {
    $idioma = $_POST['idioma'];
    setcookie('idioma', $idioma, time() + 30*24*60*60);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
} else {
    $idioma = isset($_COOKIE['idioma']) ? $_COOKIE['idioma'] : 'es';
}

$visitas = isset($_COOKIE['visita_app']) ? intval($_COOKIE['visita_app']) : 0;
$mensaje = "";

if ($visitas == 0) {
    $mensaje = "BIENVENIDO";
    setcookie('visita_app', 1, time() + 7*24*60*60);
} else {
    $visitas++;
    if ($visitas >= 10) {
        setcookie('visita_app', '', time() - 3600);
        $mensaje = "Cookie eliminada. Reseteado el contador de visitas.";
    } else {
        $mensaje = "VISITA $visitas";
        setcookie('visita_app', $visitas, time() + 7*24*60*60);
    }
}

$titulo = $idiomas[$idioma];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contador de Visitas e Idioma</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <h1><?php echo $titulo; ?></h1>

    <form method="post">
        <select name="idioma" onchange="this.form.submit()">
            <?php
            foreach ($idiomas as $key => $valor) {
                $selected = ($key == $idioma) ? "selected" : "";
                echo "<option value='$key' $selected>$key</option>";
            }
            ?>
        </select>
    </form>

    <p><?php echo $mensaje; ?></p>

</body>
</html>
