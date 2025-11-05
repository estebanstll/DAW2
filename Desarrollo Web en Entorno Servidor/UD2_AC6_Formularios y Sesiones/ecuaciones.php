<?php
session_start();

// 6.1) Eliminar o resetear la sesión que gestiona el contador de cálculos
if (isset($_SESSION['contador'])) {
    unset($_SESSION['contador']);
}

// Variables iniciales
$a = isset($_GET['a']) ? (float) $_GET['a'] : "";
$b = isset($_GET['b']) ? (float) $_GET['b'] : "";
$c = isset($_GET['c']) ? (float) $_GET['c'] : "";
$resultado = "";

// 6.2) Resolver la ecuación de segundo grado (solo mostrar resultado)
if (isset($_GET['a']) && isset($_GET['b']) && isset($_GET['c'])) {
    if ($a == 0) {
        $resultado = "No es una ecuación cuadrática.";
    } else {
        $discriminante = $b * $b - 4 * $a * $c;

        if ($discriminante > 0) {
            $x1 = (-$b + sqrt($discriminante)) / (2 * $a);
            $x2 = (-$b - sqrt($discriminante)) / (2 * $a);
            $resultado = "Soluciones reales:<br>x₁ = $x1<br>x₂ = $x2";
        } elseif ($discriminante == 0) {
            $x = -$b / (2 * $a);
            $resultado = "Solución única:<br>x = $x";
        } else {
            $real = -$b / (2 * $a);
            $imag = sqrt(-$discriminante) / (2 * $a);
            $resultado = "Soluciones complejas:<br>x₁ = $real + {$imag}i<br>x₂ = $real - {$imag}i";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ecuación de segundo grado</title>
</head>
<body>
    <h1>Resolver ecuación de segundo grado</h1>

    <form method="get" action="">
        <label for="a">a:</label>
        <input type="number" step="any" name="a" id="a" value="<?= htmlspecialchars($a) ?>" required><br>

        <label for="b">b:</label>
        <input type="number" step="any" name="b" id="b" value="<?= htmlspecialchars($b) ?>" required><br>

        <label for="c">c:</label>
        <input type="number" step="any" name="c" id="c" value="<?= htmlspecialchars($c) ?>" required><br><br>

        <input type="submit" value="Resolver">
    </form>

    <?php if ($resultado): ?>
        <hr>
        <h3>Resultado:</h3>
        <p><?= $resultado ?></p>
    <?php endif; ?>

    <hr>
    <a href="logout.php">Cerrar sesión</a> |
    <a href="calculos.php">Ir a cálculos</a>
</body>
</html>
