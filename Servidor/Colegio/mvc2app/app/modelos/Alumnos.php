<?php 

    namespace App\Models;
    class Alumnos{

    private ?int $id;
    private ?int $profesor_id;

    private ?string $nombre;
    private ?string $apellidos;

        /**
         * @param int|null $profesor_id
         * @param string|null $nombre
         * @param string|null $apellidos
         */
        public function __construct(?int $profesor_id, ?string $nombre, ?string $apellidos)
        {
            $this->profesor_id = $profesor_id;
            $this->nombre = $nombre;
            $this->apellidos = $apellidos;
        }

        public function getId(): ?int
        {
            return $this->id;
        }

        public function setId(?int $id): void
        {
            $this->id = $id;
        }

        public function getProfesorId(): ?int
        {
            return $this->profesor_id;
        }

        public function setProfesorId(?int $profesor_id): void
        {
            $this->profesor_id = $profesor_id;
        }

        public function getNombre(): ?string
        {
            return $this->nombre;
        }

        public function setNombre(?string $nombre): void
        {
            $this->nombre = $nombre;
        }

        public function getApellidos(): ?string
        {
            return $this->apellidos;
        }

        public function setApellidos(?string $apellidos): void
        {
            $this->apellidos = $apellidos;
        }


        public static function getAllProfe($id){

        $url = 'http://localhost/Colegio/Api/public/apirest/api/alumnoGet/'.$id;
            
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

        public static function getById($id){

        $url = 'http://localhost/Colegio/Api/public/apirest/api/alumnoById/'.$id;
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            if (session_status() !== PHP_SESSION_ACTIVE) {
                @session_start();
            }

            $headers = [
                'Accept: application/json'
            ];

            if (!empty($_SESSION['token'])){
                $headers[] = 'Authorization: Bearer ' . $_SESSION['token'];
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true) ?? [];
                return $data[0] ?? null;
            }

            return null;
        }

        /**
         * Update alumno via API.
         * @param int $id
         * @param array $payload Keys: profesor_id, nombre, apellido
         * @return array
         */
        public static function update($id, array $payload)
        {
            $url = 'http://localhost/Colegio/Api/public/apirest/api/alumnoUpdate/' . $id;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            if (session_status() !== PHP_SESSION_ACTIVE) {
                @session_start();
            }

            $json = json_encode($payload);

            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json)
            ];

            if (!empty($_SESSION['token'])) {
                $headers[] = 'Authorization: Bearer ' . $_SESSION['token'];
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                return json_decode($response, true) ?? [];
            }

            return ['success' => false, 'httpCode' => $httpCode, 'body' => $response];
        }

    }