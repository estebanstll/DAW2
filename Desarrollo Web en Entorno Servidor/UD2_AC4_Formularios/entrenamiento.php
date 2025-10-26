<?php
// entrenamiento.php

class SesionEntrenamiento {
    private string $nombre;
    private int $duracionMinutos;
    private float $caloriasQuemadas;
    private DateTime $fechaEntrenamiento;
    private bool $usaMaterialPropio;
    private string $rutaArchivo;

    public function __construct( string $nombre, int $duracionMinutos, float $caloriasQuemadas, string $fechaEntrenamiento, bool $usaMaterialPropio, string $rutaArchivo) {
        $this->nombre = $nombre;
        $this->duracionMinutos = $duracionMinutos;
        $this->caloriasQuemadas = $caloriasQuemadas;
        $this->fechaEntrenamiento = new DateTime($fechaEntrenamiento);
        $this->usaMaterialPropio = $usaMaterialPropio;
        $this->rutaArchivo = $rutaArchivo;
    }

    public function __toString(): string {
        $material = $this->usaMaterialPropio ? "Sí" : "No";
        return "Entrenamiento: {$this->nombre} | Duración: {$this->duracionMinutos} min | "
             . "Calorías: {$this->caloriasQuemadas} kcal | Fecha: " . $this->fechaEntrenamiento->format('Y-m-d')
             . " | Material propio: {$material} y se ha creado en la ruta: {$this->rutaArchivo}";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $duracionMinutos = isset($_POST['duracion']) ? (int)$_POST['duracion'] : 0;
    $caloriasQuemadas = isset($_POST['calorias']) ? (float)$_POST['calorias'] : 0.0;
    $fechaEntrenamiento = $_POST['fecha'] ?? '';
    $usaMaterialPropio = isset($_POST['material']);

    // Validación del archivo subido
    if (isset($_FILES['mi_archivo'])) {
        $rutaTemporal = $_FILES['mi_archivo']['tmp_name'];
        $nombreArchivo = $_FILES['mi_archivo']['name'];
        $tamañoArchivo = $_FILES['mi_archivo']['size'];
        $tipoMime = mime_content_type($rutaTemporal);
        $extensionArchivo = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

        // Comprobaciones del archivo
        if ($extensionArchivo === 'pdf' && $tipoMime === 'application/pdf' && $tamañoArchivo <= 2 * 1024 * 1024) {

            // Carpeta de destino
            $carpetaSubidas = 'uploads/';
            if (!is_dir($carpetaSubidas)) {
                mkdir($carpetaSubidas, 0777, true);
            }

            $rutaDestino = $carpetaSubidas . basename($nombreArchivo);
            move_uploaded_file($rutaTemporal, $rutaDestino);

            // Crear el objeto de sesión de entrenamiento
            $entrenamiento = new SesionEntrenamiento(
                $nombre,
                $duracionMinutos,
                $caloriasQuemadas,
                $fechaEntrenamiento,
                $usaMaterialPropio,
                $rutaDestino
            );

            // Mostrar el resultado en HTML
            echo "<!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Resultado del Entrenamiento</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                    }
                    .contenedor-resultado {
                        background: white;
                        padding: 30px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.2);
                        width: 400px;
                        text-align: center;
                    }
                    .boton-volver {
                        display: block;
                        width: 100%;
                        background: #0072ff;
                        color: white;
                        text-align: center;
                        padding: 10px;
                        border: none;
                        border-radius: 6px;
                        font-size: 16px;
                        font-weight: bold;
                        cursor: pointer;
                        transition: 0.3s;
                        margin-top: 20px;
                    }
                    .boton-volver:hover {
                        background: #00c6ff;
                    }
                </style>
            </head>
            <body>
                <div class='contenedor-resultado'>
                    <h2>Entrenamiento Registrado</h2>
                    <p class='mensaje'>{$entrenamiento}</p>
                    <p><strong>Archivo guardado:</strong> {$nombreArchivo}</p>

                    <form action='index.html' method='get'>
                        <button type='submit' class='boton-volver'>Volver al registro</button>
                    </form>
                </div>
            </body>
            </html>";

        } else {
            echo " El archivo debe ser un PDF y pesar menos de 2 MB.";
        }
    } else {
        echo " No se ha subido ningún archivo válido.";
    }
}
?>
