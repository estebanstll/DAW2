<?php 

    namespace App\Models;

    use Tools\Conexion;

    class Medicos{


    private ?int $id;
    private ?string $nombre;
    private ?string $correo;
    private ?string $especialidad;

        /**
         * @param string|null $nombre
         * @param string|null $correo
         * @param string|null $especialidad
         */
        public function __construct(?string $nombre, ?string $correo, ?string $especialidad)
        {
            $this->nombre = $nombre;
            $this->correo = $correo;
            $this->especialidad = $especialidad;
        }

        public function getId(): ?int
        {
            return $this->id;
        }

        public function setId(?int $id): void
        {
            $this->id = $id;
        }

        public function getNombre(): ?string
        {
            return $this->nombre;
        }

        public function setNombre(?string $nombre): void
        {
            $this->nombre = $nombre;
        }

        public function getCorreo(): ?string
        {
            return $this->correo;
        }

        public function setCorreo(?string $correo): void
        {
            $this->correo = $correo;
        }

        public function getEspecialidad(): ?string
        {
            return $this->especialidad;
        }

        public function setEspecialidad(?string $especialidad): void
        {
            $this->especialidad = $especialidad;
        }


        public static function getAll():array{

            $url = 'http://localhost/Hospital/Api/public/apirest/api/trabajadores';
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // Ensure session started to read token
            if (session_status() !== PHP_SESSION_ACTIVE) {
                @session_start();
            }

            $headers = [
                'Accept: application/json'
            ];

            if (!empty($_SESSION['token'])){
                $headers[] = 'Authorization: Bearer ' . $_SESSION['token'];
                error_log("=== CATEGORIAS SENDING TOKEN ===");
                error_log("Token: " . substr($_SESSION['token'], 0, 20) . "...");
            } else {
                error_log("=== CATEGORIAS NO TOKEN IN SESSION ===");
            }

            error_log("Headers being sent: " . print_r($headers, true));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                return json_decode($response, true) ?? [];
            }

            return [];
        }

        public static function getById($id):array{

            $url = 'http://localhost/Hospital/Api/public/apirest/api/trabajadores/'.$id;
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // Ensure session started to read token
            if (session_status() !== PHP_SESSION_ACTIVE) {
                @session_start();
            }

            $headers = [
                'Accept: application/json'
            ];

            if (!empty($_SESSION['token'])){
                $headers[] = 'Authorization: Bearer ' . $_SESSION['token'];
                error_log("=== CATEGORIAS SENDING TOKEN ===");
                error_log("Token: " . substr($_SESSION['token'], 0, 20) . "...");
            } else {
                error_log("=== CATEGORIAS NO TOKEN IN SESSION ===");
            }

            error_log("Headers being sent: " . print_r($headers, true));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                return json_decode($response, true) ?? [];
            }

            return [];
        }

    }