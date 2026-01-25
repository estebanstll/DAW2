<?php

namespace App\Models;

use Tools\Conexion;

class Usuario
{
    private ?int $idRestaurante = null;
    private ?string $email = null;
    private ?string $contrasena = null;
    private ?string $nacion = null;
    private ?string $codigoPostal = null;
    private ?string $municipio = null;
    private ?string $domicilio = null;

    public function __construct(
        ?string $email = null,
        ?string $contrasena = null,
        ?string $nacion = null,
        ?string $codigoPostal = null,
        ?string $municipio = null,
        ?string $domicilio = null
    ) {
        $this->email = $email;
        $this->contrasena = $contrasena;
        $this->nacion = $nacion;
        $this->codigoPostal = $codigoPostal;
        $this->municipio = $municipio;
        $this->domicilio = $domicilio;
    }

    public function obtenerId(): ?int
    {
        return $this->idRestaurante;
    }

    public function asignarId(?int $id): void
    {
        $this->idRestaurante = $id;
    }

    public function obtenerEmail(): ?string
    {
        return $this->email;
    }

    public function asignarEmail($email): void
    {
        $this->email = $email;
    }

    public function obtenerContrasena(): ?string
    {
        return $this->contrasena;
    }

    public function asignarContrasena($contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    public function obtenerNacion(): ?string
    {
        return $this->nacion;
    }

    public function asignarNacion($nacion): void
    {
        $this->nacion = $nacion;
    }

    public function obtenerCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function asignarCodigoPostal($cp): void
    {
        $this->codigoPostal = $cp;
    }

    public function obtenerMunicipio(): ?string
    {
        return $this->municipio;
    }

    public function asignarMunicipio($municipio): void
    {
        $this->municipio = $municipio;
    }

    public function obtenerDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function asignarDomicilio($domicilio): void
    {
        $this->domicilio = $domicilio;
    }

    public static function validarCredenciales(string $email, string $contrasena)
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM restaurantes WHERE Correo = :email";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        
        $row = $stmt->fetch();
        
        if (!$row) {
            return false;
        }

        // Verificar contraseña hasheada con salt
        $contrasenaHasheada = sha1($contrasena . 'foodhub_password_salt_2026');
        if ($row["Clave"] === $contrasenaHasheada) {
            return $row;
        }

        // Verificar si la contraseña está en texto plano
        if ($row["Clave"] === $contrasena) {
            return $row;
        }

        // Verificar hash simple (sin salt)
        if ($row["Clave"] === sha1($contrasena)) {
            return $row;
        }

        return false;
    }

    public static function obtenerIdUsuario(string $email)
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT CodRes FROM restaurantes WHERE Correo = :email";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * Verifica si un email ya existe en la base de datos
     * 
     * @param string $email El email a verificar
     * @return bool True si existe, false si no
     */
    public static function existeEmail(string $email): bool
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT COUNT(*) FROM restaurantes WHERE Correo = :email";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Crea un nuevo usuario (restaurante) en la base de datos
     * 
     * @param string $email El email del usuario
     * @param string $contrasena La contraseña sin encriptar
     * @param string $domicilio La dirección del restaurante
     * @return bool True si se creó exitosamente
     */
    public function registrar(string $email, string $contrasena, string $domicilio): bool
    {
        if (self::existeEmail($email)) {
            return false;
        }

        try {
            $bd = Conexion::getConexion();
            
            // Se hashea la contraseña antes de guardar
            $contrasenaHasheada = sha1($contrasena . 'foodhub_password_salt_2026');
            
            $consulta = "INSERT INTO restaurantes (Correo, Clave, Direccion) VALUES (:email, :contrasena, :domicilio)";
            $stmt = $bd->prepare($consulta);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":contrasena", $contrasenaHasheada);
            $stmt->bindParam(":domicilio", $domicilio);

            return $stmt->execute();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Obtiene un usuario por su email
     * 
     * @param string $email El email del usuario
     * @return Usuario|null El usuario encontrado o null
     */
    public static function obtenerPorEmail(string $email): ?Usuario
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM restaurantes WHERE Correo = :email";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $row = $stmt->fetch();
        
        if (!$row) {
            return null;
        }

        $usuario = new self(
            $row["Correo"],
            $row["Clave"],
            $row["Pais"] ?? null,
            $row["CP"] ?? null,
            $row["Ciudad"] ?? null,
            $row["Direccion"] ?? null
        );
        $usuario->asignarId($row["CodRes"]);

        return $usuario;
    }

    /**
     * Obtiene un usuario por su ID
     * 
     * @param int $id El ID del usuario
     * @return Usuario|null El usuario encontrado o null
     */
    public static function obtenerPorId(int $id): ?Usuario
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM restaurantes WHERE CodRes = :id";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch();
        
        if (!$row) {
            return null;
        }

        $usuario = new self(
            $row["Correo"],
            $row["Clave"],
            $row["Pais"] ?? null,
            $row["CP"] ?? null,
            $row["Ciudad"] ?? null,
            $row["Direccion"] ?? null
        );
        $usuario->asignarId($row["CodRes"]);

        return $usuario;
    }

    /**
     * Actualiza la contraseña de un usuario
     * 
     * @param int $id El ID del usuario
     * @param string $nuevaContrasena La nueva contraseña sin encriptar
     * @return bool True si se actualizó correctamente
     */
    public static function actualizarContrasena(int $id, string $nuevaContrasena): bool
    {
        try {
            $bd = Conexion::getConexion();
            
            // Se hashea la nueva contraseña
            $contrasenaHasheada = sha1($nuevaContrasena . 'foodhub_password_salt_2026');
            
            $consulta = "UPDATE restaurantes SET Clave = :contrasena WHERE CodRes = :id";
            $stmt = $bd->prepare($consulta);
            $stmt->bindParam(":contrasena", $contrasenaHasheada);
            $stmt->bindParam(":id", $id);

            return $stmt->execute();
        } catch (\Exception $e) {
            return false;
        }
    }
}
