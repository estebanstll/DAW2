<?php 

    namespace App\Models;

    use Tools\Conexion;
    use Tools\Hash;


    class Usuarios{

    private ?int $id;
    private ?string $nombre;
    private ?string $correo;
    private ?int $contraseña;

    // Constructor
    public function __construct(?string $nombre = null, ?string $correo = null, ?int $contraseña = null)
    {
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->contraseña = $contraseña;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function getContraseña(): ?int
    {
        return $this->contraseña;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setCorreo(?string $correo): void
    {
        $this->correo = $correo;
    }

    public function setContraseña(?int $contraseña): void
    {
        $this->contraseña = $contraseña;
    }

    // Método para hacer login en la API
    public static function login(string $correo, $contraseña): ?array
    {
        $url = 'http://localhost/Perrera/ApiPerrera/public/apirest/api/login';
        
        // Hashear la contraseña con el mismo método que usa la API
        $contraseñaHasheada = Hash::make($contraseña);
        
        // Preparar datos para enviar (la API espera la contraseña sin hashear)
        $data = [
            'email' => $correo,
            'password' => $contraseña  // Enviar la contraseña original, la API la hasheará
        ];

        // Inicializar cURL
        $ch = curl_init($url);
        
        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data))
        ]);

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

    // Método para registrarse en la API
    public static function register(string $nombre, string $correo, string $contraseña): ?array
    {
        $url = 'http://localhost/Perrera/ApiPerrera/public/apirest/api/register';
        
        // Preparar datos para enviar (la API espera la contraseña sin hashear)
        $data = [
            'nombre' => $nombre,
            'email' => $correo,
            'password' => $contraseña  // Enviar la contraseña original, la API la hasheará
        ];

        // Inicializar cURL
        $ch = curl_init($url);
        
        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data))
        ]);

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