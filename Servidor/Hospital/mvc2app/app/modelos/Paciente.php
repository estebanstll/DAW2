<?php 

    namespace App\Models;

    class Paciente{

    private ?int $id;
    private ?int $medico_id;
    private ?string $nombre;
    private ?string $motivo;

        /**
         * @param int|null $medico_id
         * @param string|null $nombre
         * @param string|null $motivo
         */
        public function __construct(?int $medico_id, ?string $nombre, ?string $motivo)
        {
            $this->medico_id = $medico_id;
            $this->nombre = $nombre;
            $this->motivo = $motivo;
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

        public function getMedicoId(): ?int
        {
            return $this->medico_id;
        }

        public function setMedicoId(?int $medico_id): void
        {
            $this->medico_id = $medico_id;
        }

        public function getMotivo(): ?string
        {
            return $this->motivo;
        }

        public function setMotivo(?string $motivo): void
        {
            $this->motivo = $motivo;
        }



        public static function getAll(){

        $url = 'http://localhost/Hospital/Api/public/apirest/api/paciente';
            
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

        public static function getporID($id){

        $url = 'http://localhost/Hospital/Api/public/apirest/api/paciente/'.$id;
            
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


        public static function deleteId($id){

        $url = 'http://localhost/Hospital/Api/public/apirest/api/pacienteDelete/'.$id;
            
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


        /**
         * Update paciente via API.
         * @param int $id
         * @param array $payload Associative array with keys: medico_id, nombre, motivo
         * @return array
         */
        public static function update($id, array $payload)
        {
            $url = 'http://localhost/Hospital/Api/public/apirest/api/pacienteUpdate/' . $id;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            // Ensure session started to read token
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
            // Use PUT to match controller expectation (PUT/PATCH)
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlErr = curl_error($ch);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                return json_decode($response, true) ?? [];
            }

            return ['success' => false, 'httpCode' => $httpCode, 'body' => $response];
        }
    }