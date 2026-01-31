<?php
namespace App\Apirest\Models;

use Tools\Conexion;

class ApiUsuario
{
    public static function validarCredenciales(string $email, string $contrasena)
    {
        $bd = Conexion::getConexion();
        $consulta = "SELECT * FROM restaurantes WHERE Correo = :email";
        $stmt = $bd->prepare($consulta);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();

        if (!$row) {
            return false;
        }

        // Comprobar con salt conocido (mantener compat con UD4)
        $salted = sha1($contrasena . 'foodhub_password_salt_2026');
        if ($row['Clave'] === $salted) {
            return $row;
        }

        if ($row['Clave'] === $contrasena) {
            return $row;
        }

        if ($row['Clave'] === sha1($contrasena)) {
            return $row;
        }

        return false;
    }
}
