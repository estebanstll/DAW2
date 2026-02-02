<?php 

    namespace App\Models;

    class Notas{
    private ?int $id;
    private ?int $alumno_id;

    private ?string $asignatura;
    private ?float $nota;

        /**
         * @param int|null $alumno_id
         * @param string|null $asignatura
         * @param float|null $nota
         */
        public function __construct(?int $alumno_id, ?string $asignatura, ?float $nota)
        {
            $this->alumno_id = $alumno_id;
            $this->asignatura = $asignatura;
            $this->nota = $nota;
        }

        public function getAsignatura(): ?string
        {
            return $this->asignatura;
        }

        public function setAsignatura(?string $asignatura): void
        {
            $this->asignatura = $asignatura;
        }

        public function getNota(): ?float
        {
            return $this->nota;
        }

        public function setNota(?float $nota): void
        {
            $this->nota = $nota;
        }

        public function getAlumnoId(): ?int
        {
            return $this->alumno_id;
        }

        public function setAlumnoId(?int $alumno_id): void
        {
            $this->alumno_id = $alumno_id;
        }

        public function getId(): ?int
        {
            return $this->id;
        }

        public function setId(?int $id): void
        {
            $this->id = $id;
        }

        public static function getAllNotas($id){

        $url = 'http://localhost/Colegio/Api/public/apirest/api/notaGet/'.$id;
            
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
         * Update nota via API.
         * @param int $id
         * @param int|float $nota
         * @return array
         */
        public static function update($id, $nota)
        {
            $url = 'http://localhost/Colegio/Api/public/apirest/api/notasUpdate/' . $id;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            if (session_status() !== PHP_SESSION_ACTIVE) {
                @session_start();
            }

            $payload = ['nota' => $nota];
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

        /**
         * Create nota via API.
         * @param array $payload Keys: id (optional), alumno_id, asignatura, nota
         * @return array
         */
        public static function create(array $payload)
        {
            $url = 'http://localhost/Colegio/Api/public/apirest/api/notasCreate';

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
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if (($httpCode === 200 || $httpCode === 201) && $response) {
                return json_decode($response, true) ?? [];
            }

            return ['success' => false, 'httpCode' => $httpCode, 'body' => $response];
        }

        /**
         * Delete nota via API.
         * @param int $id
         * @return array
         */
        public static function delete($id)
        {
            $url = 'http://localhost/Colegio/Api/public/apirest/api/notasDelete/' . $id;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            if (session_status() !== PHP_SESSION_ACTIVE) {
                @session_start();
            }

            $headers = [
                'Accept: application/json'
            ];

            if (!empty($_SESSION['token'])) {
                $headers[] = 'Authorization: Bearer ' . $_SESSION['token'];
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                return json_decode($response, true) ?? [];
            }

            return ['success' => false, 'httpCode' => $httpCode, 'body' => $response];
        }


        

    }