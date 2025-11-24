<?php

// 1. Validación de email
$email = $_POST['email'] ?? '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("El email no es válido");
}

// 2. Validación de edad (número entero)
$edad = $_POST['edad'] ?? '';
if (!filter_var($edad, FILTER_VALIDATE_INT)) {
    die("La edad debe ser un número entero");
}

// 3. Comprobación del archivo
if (!isset($_FILES['archivo'])) {
    die("No se envió ningún archivo");
}

// Información del archivo
$archivo = $_FILES['archivo'];

if ($archivo['error'] !== UPLOAD_ERR_OK) {
    die("Error al subir el archivo");
}

// 4. Validación del tipo de archivo (por ejemplo PDF)
$tipo = mime_content_type($archivo['tmp_name']);
$tiposPermitidos = ['application/pdf'];

if (!in_array($tipo, $tiposPermitidos)) {
    die("Solo se permiten archivos PDF");
}

// 5. Mover archivo a carpeta definitiva
$destino = "uploads/" . basename($archivo['name']);

if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
    die("No se pudo guardar el archivo");
}

echo "Archivo subido correctamente<br>";
echo "Email: $email<br>";
echo "Edad: $edad<br>";
echo "Guardado en: $destino";
