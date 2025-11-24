<?php
session_start();

// Guardar tema si se envía formulario
if (isset($_POST['tema'])) {
    $_SESSION['tema'] = $_POST['tema'];
    header("Location: preferencias.php");
    exit;
}

// Tema por defecto
$tema = $_SESSION['tema'] ?? "white";
?>

<form method="POST" action="preferencias.php">
    Color de fondo: <input type="text" name="tema" placeholder="red, blue, green...">
    <button type="submit">Guardar</button>
</form>

<body style="background-color: <?php echo htmlspecialchars($tema); ?>;">
<h3>Color actual: <?php echo htmlspecialchars($tema); ?></h3>
</body>
