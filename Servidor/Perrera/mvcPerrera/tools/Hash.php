<?php

namespace Tools;

class Hash
{
    // Salt utilizado en la API
    private const SALT = 'foodhub_password_salt_2026';

    /**
     * Hashea una contraseña usando SHA1 con el salt de la API
     * 
     * @param string|int $password La contraseña a hashear
     * @return string La contraseña hasheada
     */
    public static function make($password): string
    {
        return sha1($password . self::SALT);
    }

    /**
     * Verifica si una contraseña coincide con un hash
     * 
     * @param string|int $password La contraseña en texto plano
     * @param string $hash El hash a comparar
     * @return bool True si coinciden, false si no
     */
    public static function verify($password, string $hash): bool
    {
        return self::make($password) === $hash;
    }
}
