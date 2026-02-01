<?php 

    namespace App\Models;

    use helpers\Hash;

    class Categorias{

    private ?int $id;
    private ?string $nombre;
    private ?string $descripcion;

        /**
         * @param string|null $nombre
         * @param string|null $descripcion
         */
        public function __construct(?string $nombre, ?string $descripcion)
        {
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
        }

        public function getId(): ?int
        {
            return $this->id;
        }

        public function setId(?int $id): void
        {
            $this->id = $id;
        }

        public function getDescripcion(): ?string
        {
            return $this->descripcion;
        }

        public function setDescripcion(?string $descripcion): void
        {
            $this->descripcion = $descripcion;
        }

        public function getNombre(): ?string
        {
            return $this->nombre;
        }

        public function setNombre(?string $nombre): void
        {
            $this->nombre = $nombre;
        }

        public static function getAll():array{

            $url = 'http://localhost/Productos/ApiTienda/public/apirest/api/categorias';
            
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