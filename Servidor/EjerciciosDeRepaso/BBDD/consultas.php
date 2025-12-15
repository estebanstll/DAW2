<?php
// NECESITA: require "conexion.php";
require "conexion.php";

echo "<h2>1. CONSULTA SIMPLE</h2>";
$stmt = $pdo->query("SELECT * FROM productos");
foreach ($stmt as $fila) {
    echo $fila['id'] . " - " . $fila['nombre'] . " - " . $fila['precio'] . "<br>";
}

echo "<hr>";

echo "<h2>2. CONSULTA PREPARADA (posición)</h2>";
$stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([1]);
print_r($stmt->fetch());

echo "<hr>";

echo "<h2>3. CONSULTA PREPARADA (nombre)</h2>";
$stmt = $pdo->prepare("SELECT * FROM productos WHERE nombre = :n");
$stmt->execute(['n' => 'Mesa']);
print_r($stmt->fetch());

echo "<hr>";

echo "<h2>4. INSERTAR</h2>";
$stmt = $pdo->prepare("INSERT INTO productos (nombre, precio) VALUES (:n, :p)");
$stmt->execute(['n' => 'Teclado', 'p' => 25.90]);
echo "Producto insertado<br>";

echo "<hr>";

echo "<h2>5. ACTUALIZAR</h2>";
$stmt = $pdo->prepare("UPDATE productos SET precio = :p WHERE nombre = :n");
$stmt->execute(['n' => 'Teclado', 'p' => 29.99]);
echo "Producto actualizado<br>";

echo "<hr>";

echo "<h2>6. BORRAR</h2>";
$stmt = $pdo->prepare("DELETE FROM productos WHERE nombre = :n");
$stmt->execute(['n' => 'Teclado']);
echo "Producto borrado<br>";

echo "<hr>";

echo "<h2>7. TRANSACCIÓN</h2>";

try {
    $pdo->beginTransaction();

    $pdo->prepare("INSERT INTO productos (nombre, precio) VALUES (?, ?)")
        ->execute(['Silla', 49.90]);

    $pdo->prepare("INSERT INTO productos (nombre, precio) VALUES (?, ?)")
        ->execute(['Armario', 79.90]);

    $pdo->commit();
    echo "Transacción realizada correctamente<br>";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error en transacción: " . $e->getMessage();
}

echo "<hr>";

echo "<h2>8. MANEJO DE ERRORES</h2>";
try {
    $pdo->query("SELECT * FROM tabla_inexistente");
} catch (PDOException $e) {
    echo "Error detectado correctamente: " . $e->getMessage();
}

echo "<hr>";

echo "<h2>9. LOGIN CON BBDD</h2>";

session_start();

if (isset($_POST['usuario'], $_POST['clave'])) {

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :u");
    $stmt->execute(['u' => $_POST['usuario']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['clave'], $user['clave'])) {
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['rol'] = $user['rol'];
        echo "Login correcto. Bienvenido " . $user['usuario'] . "<br>";
    } else {
        echo "Credenciales incorrectas<br>";
    }
}

?>

<form method="POST">
    Usuario: <input type="text" name="usuario">
    <br>
    Contraseña: <input type="password" name="clave">
    <br>
    <button type="submit">Iniciar sesión</button>
</form>

<?php
echo "<hr>";

echo "<h2>10. CONTROL DE ROLES</h2>";

if (isset($_SESSION['usuario'])) {

    echo "Usuario actual: " . $_SESSION['usuario'] . " (" . $_SESSION['rol'] . ")<br>";

    if ($_SESSION['rol'] === 'admin') {
        echo "Eres administrador: puedes gestionar usuarios, ver informes, etc.<br>";
    } else {
        echo "Eres usuario estándar: acceso limitado.<br>";
    }

} else {
    echo "No has iniciado sesión.<br>";
}
?>
