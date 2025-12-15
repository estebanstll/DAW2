<?php
session_start();

if (!isset($_SESSION['usuario_autenticado'])) {
    header('Location: index.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <body>

    <div class="calcu">
        <h2>Calculadora</h2>

        <form action="resolucion.php" method="GET">

            <label for="numero1">Primer número:</label>
            <input type="number" id="numero1" name="numero1" step="any" required>

            <label for="select">Operador lógico</label>
            <select name="select">
			    <option value="+">Suma (+)</option>
                <option value="-">Resta (-)</option>
                <option value="*">Multiplicación (*)</option>
                <option value="/">División (/)</option>

			</select>

            <label for="numero2">Segundo número:</label>
            <input type="number" id="numero2" name="numero2" step="any" required>

            <input type="submit" value="Entrar">
        </form>

        <?php
            if (isset($_SESSION['resultado'])) {
                echo "<h2>Resultado: " . $_SESSION['resultado'] . "</h2>";
                echo "<h2>Contador de sesiones: " . $_SESSION['contador'] . "</h2>";
            }
        ?>
    </div>