    <?php
    // entrenamiento.php

    class Entrenamiento {
        private string $nombre;
        private int $duracion;
        private float $calorias;
        private DateTime $fecha;
        private bool $materialPropio;
        private string $fotografia;

        public function __construct(string $nombre, int $duracion, float $calorias, string $fecha, bool $materialPropio, string $fotografia) {
            $this->nombre = $nombre;
            $this->duracion = $duracion;
            $this->calorias = $calorias;
            $this->fecha = new DateTime($fecha);
            $this->materialPropio = $materialPropio;
            $this->fotografia=$fotografia;
        }

        public function __toString(): string {
            $material = $this->materialPropio ? "Sí" : "No";
            return "Entrenamiento: {$this->nombre} | Duración: {$this->duracion} min | "
                 . "Calorías: {$this->calorias} kcal | Fecha: " . $this->fecha->format('Y-m-d')
                 . " | Material propio: {$material} "." y se ha creado en la ruta: {$this->fotografia}";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'] ?? '';
        $duracion = isset($_POST['duracion']) ? (int)$_POST['duracion'] : 0;
        $calorias = isset($_POST['calorias']) ? (float)$_POST['calorias'] : 0.0;
        $fecha = $_POST['fecha'] ?? '';
        $material = isset($_POST['material']);

        

        // Validación del archivo
        if (isset($_FILES['mi_archivo'])) {
            $fileTmp = $_FILES['mi_archivo']['tmp_name'];
            $fileName = $_FILES['mi_archivo']['name'];
            $fileSize = $_FILES['mi_archivo']['size'];
            $fileType = mime_content_type($fileTmp);
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validaciones
            if ($fileExt === 'pdf' && $fileType === 'application/pdf' && $fileSize <= 2 * 1024 * 1024) {

                // Directorio donde se guardará el archivo
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $destino = $uploadDir . basename($fileName);
                move_uploaded_file($fileTmp, $destino);

                // Crear el objeto
                $entrenamiento = new Entrenamiento($nombre, $duracion, $calorias, $fecha, $material,$destino);


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
                        .login-box {
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
                    <div class='login-box'>
                        <h2>Entrenamiento Registrado</h2>
                        <p class='mensaje'>{$entrenamiento}</p>
                        <p><strong>Archivo guardado:</strong> {$fileName}</p>

                        <form action='index.html' method='get'>
                            <button type='submit' class='boton-volver'>Volver al registro</button>
                        </form>
                    </div>
                </body>
                </html>";

            } else {
                echo "⚠️ El archivo debe ser un PDF y pesar menos de 2 MB.";
            }
        } else {
            echo "⚠️ No se ha subido ningún archivo válido.";
        }
    }
    ?>
