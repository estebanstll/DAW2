<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <body>

    <div class="login-box">
        <h2>Iniciar Sesión</h2>

        <form action="validacion.php" method="POST">

            <label for="numero1">Primer número:</label>
            <input type="number" id="numero1" name="numero1" step="any" required>

            <label for="select">Operador lógico</label>
            <select name="select">
			  <option value="+">+</option>
			  <option value="-" selected>-</option>
			  <option value="*">*</option>
			  <option value="/">/</option>

			</select>

            <label for="numero2">Segundo número:</label>
            <input type="number" id="numero2" name="numero2" step="any" required>

            <input type="submit" value="Entrar">
        </form>
    </div>