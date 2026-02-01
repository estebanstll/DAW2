<?php 

    namespace App\Models;

    use Tools\Conexion;


    class Animales{

    private ?int $id;
        private ?string $animal;
        private ?string $raza;
        private ?string $nombre;
        private ?string $personaAcargo;

        /**
         * @param string|null $animal
         * @param string|null $raza
         * @param string|null $nombre
         * @param string|null $personaAcargo
         */
        public function __construct(?string $animal, ?string $raza, ?string $nombre, ?string $personaAcargo)
        {
            $this->id = null;
            $this->animal = $animal;
            $this->raza = $raza;
            $this->nombre = $nombre;
            $this->personaAcargo = $personaAcargo;
        }


        public function getId(): ?int
        {
            return $this->id;
        }

        public function setId(?int $id): void
        {
            $this->id = $id;
        }

        public function getPersonaAcargo(): ?string
        {
            return $this->personaAcargo;
        }

        public function setPersonaAcargo(?string $personaAcargo): void
        {
            $this->personaAcargo = $personaAcargo;
        }

        public function getNombre(): ?string
        {
            return $this->nombre;
        }

        public function setNombre(?string $nombre): void
        {
            $this->nombre = $nombre;
        }

        public function getRaza(): ?string
        {
            return $this->raza;
        }

        public function setRaza(?string $raza): void
        {
            $this->raza = $raza;
        }

        public function getAnimal(): ?string
        {
            return $this->animal;
        }

        public function setAnimal(?string $animal): void
        {
            $this->animal = $animal;
        }



        public static function getAll(){

            $url = 'http://localhost/Perrera/ApiPerrera/public/apirest/api/animal';
            
            // Iniciar sesión si no está iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Obtener token de la sesión
            $token = $_SESSION['token'] ?? null;
            
            // Inicializar cURL
            $ch = curl_init($url);
            
            // Configurar opciones de cURL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $headers = ['Content-Type: application/json'];
            if ($token) {
                $headers[] = 'Authorization: Bearer ' . $token;
            }
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            // Ejecutar petición
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            // Cerrar cURL
            curl_close($ch);

            // Decodificar respuesta
            $responseData = json_decode($response, true);

            // Retornar respuesta con código HTTP
            return [
                'status' => $httpCode,
                'data' => $responseData
            ];
        }

        public static function getPorId($id):?array{

            $url = 'http://localhost/Perrera/ApiPerrera/public/apirest/api/animal/' . $id;
            
            // Obtener token de la sesión
            $token = $_SESSION['token'] ?? null;
            
            // Inicializar cURL
            $ch = curl_init($url);
            
            // Configurar opciones de cURL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $headers = ['Content-Type: application/json'];
            if ($token) {
                $headers[] = 'Authorization: Bearer ' . $token;
            }
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            // Ejecutar petición
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            // Cerrar cURL
            curl_close($ch);

            // Decodificar respuesta
            $responseData = json_decode($response, true);

            // Retornar respuesta con código HTTP
            return [
                'status' => $httpCode,
                'data' => $responseData
            ];
        }

        public static function updatePorId($id, string $animal, string $raza, string $nombre, string $personaACargo):?array{

            $url = 'http://localhost/Perrera/ApiPerrera/public/apirest/api/updateAnimal/' . $id;
            
            // Obtener token de la sesión
            $token = $_SESSION['token'] ?? null;
            
            // Preparar datos
            $data = [
                'animal' => $animal,
                'raza' => $raza,
                'nombre' => $nombre,
                'personaACargo' => $personaACargo
            ];

            // Inicializar cURL
            $ch = curl_init($url);
            
            // Configurar opciones de cURL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            
            $headers = [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data))
            ];
            if ($token) {
                $headers[] = 'Authorization: Bearer ' . $token;
            }
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            // Ejecutar petición
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            // Cerrar cURL
            curl_close($ch);

            // Decodificar respuesta
            $responseData = json_decode($response, true);

            // Retornar respuesta con código HTTP
            return [
                'status' => $httpCode,
                'data' => $responseData
            ];
        }

        public static function deletePorId($id):?array{

            $url = 'http://localhost/Perrera/ApiPerrera/public/apirest/api/deleteAnimal/' . $id;
            
            // Obtener token de la sesión
            $token = $_SESSION['token'] ?? null;
            
            // Inicializar cURL
            $ch = curl_init($url);
            
            // Configurar opciones de cURL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            
            $headers = ['Content-Type: application/json'];
            if ($token) {
                $headers[] = 'Authorization: Bearer ' . $token;
            }
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            // Ejecutar petición
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            // Cerrar cURL
            curl_close($ch);

            // Decodificar respuesta
            $responseData = json_decode($response, true);

            // Retornar respuesta con código HTTP
            return [
                'status' => $httpCode,
                'data' => $responseData
            ];
        }


    }