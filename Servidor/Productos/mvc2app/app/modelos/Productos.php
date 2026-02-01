<?php 

    namespace App\Models;

    class productos{

    private ?int $id;
    private ?int $categoria_id;
    private ?string $nombre;
    private ?string $stock;

        /**
         * @param string|null $nombre
         * @param string|null $stock
         * @param int|null $categoria_id
         */
        public function __construct(?string $nombre, ?string $stock, ?int $categoria_id)
        {
            $this->nombre = $nombre;
            $this->stock = $stock;
            $this->categoria_id = $categoria_id;
        }

        public function getId(): ?int
        {
            return $this->id;
        }

        public function setId(?int $id): void
        {
            $this->id = $id;
        }

        public function getStock(): ?string
        {
            return $this->stock;
        }

        public function setStock(?string $stock): void
        {
            $this->stock = $stock;
        }

        public function getCategoriaId(): ?int
        {
            return $this->categoria_id;
        }

        public function setCategoriaId(?int $categoria_id): void
        {
            $this->categoria_id = $categoria_id;
        }

        public function getNombre(): ?string
        {
            return $this->nombre;
        }

        public function setNombre(?string $nombre): void
        {
            $this->nombre = $nombre;
        }


        public static function getProductoCategoria($id):array{

            $url = 'http://localhost/Productos/ApiTienda/public/apirest/api/productos/';
            
            $ch = curl_init($url.$id);
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
                error_log("=== PRODUCTOS SENDING TOKEN ===");
                error_log("Token: " . substr($_SESSION['token'], 0, 20) . "...");
            } else {
                error_log("=== PRODUCTOS NO TOKEN IN SESSION ===");
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