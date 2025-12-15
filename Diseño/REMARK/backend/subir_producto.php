<?php
// ===================================================
// PHP A PRUEBA DE BALAS - NO SALE NI UNA PUTA ETIQUETA HTML
// ===================================================

header("Content-Type: application/json; charset=utf-8");

// Log de errores
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/errores_php.log");
error_reporting(E_ALL);
ini_set("display_errors", 0); // JAMÁS mostrar HTML

require_once __DIR__ . "/db.php";

// Función segura para responder JSON SIEMPRE
function responder($status, $mensaje, $extra = []) {
    echo json_encode(array_merge([
        "status" => $status,
        "mensaje" => $mensaje
    ], $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

// Captura de errores fatales
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error) {
        error_log("ERROR FATAL: " . print_r($error, true));
        echo json_encode([
            "status" => "error",
            "mensaje" => "Error interno del servidor (Fatal)"
        ]);
    }
});

// ===================================================
// VALIDAR CAMPOS
// ===================================================
$req = ["nombre", "categoria", "descripcion", "precio", "usuario"];

foreach ($req as $campo) {
    if (!isset($_POST[$campo])) {
        responder("error", "Falta el campo: $campo");
    }
}

if (!isset($_FILES["imagen"])) {
    responder("error", "Falta la imagen");
}

$nombre      = $_POST["nombre"];
$categoria   = $_POST["categoria"];
$descripcion = $_POST["descripcion"];
$precio      = $_POST["precio"];
$usuario     = $_POST["usuario"];
$imagen      = $_FILES["imagen"];

error_log("DATOS RECIBIDOS: " . print_r($_POST, true));
error_log("IMAGEN: " . print_r($_FILES, true));

// ===================================================
// BUSCAR USUARIO
// ===================================================
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ?");
if (!$stmt) responder("error", "Error SQL 1: " . $conn->error);

$stmt->bind_param("s", $usuario);
$stmt->execute();
$rs = $stmt->get_result();

if ($rs->num_rows === 0) {
    responder("error", "Usuario no encontrado");
}

$id_usuario = $rs->fetch_assoc()["id"];
$stmt->close();

// ===================================================
// SUBIR IMAGEN
// ===================================================

$carpeta = "../resources/img/";

if (!is_dir($carpeta)) {
    mkdir($carpeta, 0777, true);
}

$ext = strtolower(pathinfo($imagen["name"], PATHINFO_EXTENSION));
$fecha = date("Ymd_His");
$nombreImagen = $usuario . "_" . $fecha . "." . $ext;

$rutaServidor = $carpeta . $nombreImagen;
$rutaBD = "resources/img/" . $nombreImagen;

if (!move_uploaded_file($imagen["tmp_name"], $rutaServidor)) {
    responder("error", "No se pudo mover la imagen");
}

error_log("Imagen guardada en: $rutaServidor");

// ===================================================
// INSERTAR PRODUCTO
// ===================================================
$stmt = $conn->prepare("
    INSERT INTO productos (id_usuario, nombre, categoria, descripcion, precio, imagen)
    VALUES (?, ?, ?, ?, ?, ?)
");

if (!$stmt) responder("error", "Error SQL 2: " . $conn->error);

$stmt->bind_param("isssis", $id_usuario, $nombre, $categoria, $descripcion, $precio, $rutaBD);

if ($stmt->execute()) {
    responder("ok", "Producto guardado correctamente", ["ruta" => $rutaBD]);
}

responder("error", "Error SQL 3: " . $stmt->error);
