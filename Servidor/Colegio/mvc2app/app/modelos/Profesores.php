<?php 

    namespace App\Models;

    class Profesores{

    private ?int $id;
    private ?string $nombre;
    private ?string $clase;

        /**
         * @param string|null $nombre
         * @param string|null $clase
         */
        public function __construct(?string $nombre, ?string $clase)
        {
            $this->nombre = $nombre;
            $this->clase = $clase;
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

        public function getClase(): ?string
        {
            return $this->clase;
        }

        public function setClase(?string $clase): void
        {
            $this->clase = $clase;
        }

        public static function getAll(){

        $url = 'http://localhost/Colegio/Api/public/apirest/api/profesores';
            
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
            }
            // headers prepared
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