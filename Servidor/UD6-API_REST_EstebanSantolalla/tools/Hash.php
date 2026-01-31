<?php

namespace Tools;

/**
 * Clase para gestionar operaciones de hash SHA1
 * Utilizada para codificar y decodificar IDs en URLs
 */
class Hash
{
    /**
     * Tabla de mapeo para convertir hash a ID
     */
    private static array $hashMap = [];

    /**
     * Genera un hash SHA1 para un ID
     * 
     * @param int $id El ID a codificar
     * @return string El hash SHA1
     */
    public static function encode(int $id): string
    {
        return sha1($id . 'foodhub_secret_key_2026');
    }

    /**
     * Verifica que un hash sea válido para un ID específico
     * 
     * @param int $id El ID original
     * @param string $hash El hash a verificar
     * @return bool True si el hash es válido para ese ID
     */
    public static function verify(int $id, string $hash): bool
    {
        return self::encode($id) === $hash;
    }

    /**
     * Obtiene el ID a partir de un hash (usando búsqueda en BD)
     * Solo úsalo cuando absolutamente sea necesario
     * 
     * @param string $hash El hash a buscar
     * @param string $tabla La tabla donde buscar
     * @param string $columna La columna con el ID
     * @return int|null El ID encontrado o null
     */
    public static function decodeFromDatabase(string $hash, string $tabla, string $columna): ?int
    {
        try {
            $bd = Conexion::getConexion();
            $consulta = "SELECT {$columna} FROM {$tabla}";
            $stmt = $bd->prepare($consulta);
            $stmt->execute();

            foreach ($stmt->fetchAll() as $row) {
                $id = $row[$columna];
                if (self::verify($id, $hash)) {
                    return $id;
                }
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
