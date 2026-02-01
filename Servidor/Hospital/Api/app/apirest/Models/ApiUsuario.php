<?php
namespace App\Apirest\Models;

use Tools\Conexion;

class ApiUsuario
{
    public static function validarCredenciales(string $email, string $contrasena)
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM usuarios WHERE correo = :email";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();

        if (!$row) {
            return false;
        }

        // Comprobar con salt conocido (mantener compat con UD4)
        $salted = sha1($contrasena . 'foodhub_password_salt_2026');
        if ($row['contrasena'] === $salted) {
            return $row;
        }

        if ($row['contrasena'] === $contrasena) {
            return $row;
        }

        if ($row['contrasena'] === sha1($contrasena)) {
            return $row;
        }

        return false;
    }

    public static function crearUsuario(string $email, string $contrasena, string $nombre = '')
    {
        $bd = Conexion::getConexion();
        
        // Verificar si el usuario ya existe
        $consulta = "SELECT * FROM usuarios WHERE correo = :email";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'El usuario ya existe'];
        }
        
        // Hashear la contraseña con el mismo método que se usa en validación
        $contrasenaHasheada = sha1($contrasena . 'foodhub_password_salt_2026');
        
        // Insertar el nuevo usuario
        $consulta = "INSERT INTO usuarios (nombre, correo, contrasena) 
                     VALUES (:nombre, :email, :contrasena)";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contrasena', $contrasenaHasheada);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Usuario creado correctamente', 'id' => $bd->lastInsertId()];
        } else {
            return ['success' => false, 'message' => 'Error al crear el usuario'];
        }
    }
}
