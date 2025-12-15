<?php
/**
 * Vamos a usar un patrón Singleton para que solo haya una instancia del objeto "Config"
 * Y se use en toda la aplicación.
 * 
 * El patrón Singleton se usa para que una clase solo pueda tener una única instancia.
 * Esa instancia se crea la primera vez que se pide.
 * Las siguientes veces se devuelve la misma.
 * El constructor es privado para evitar nuevas instancias.
 * Se accede mediante un método estático llamado getInstance().
 */

class Config
{
    private static $instancia = null;  // Aquí guardamos el único objeto

    private $data = []; // Guardará la configuración

    private function __construct()
    {
        // Cargamos el archivo .ini solo una vez y con secciones 'true'
        $this->data = parse_ini_file(__DIR__ . '/../config/config.ini', true);
    }

    public static function getInstance()
    {
        // Si no existe la instancia, la creamos
        if (self::$instancia === null) {
            self::$instancia = new Config();
        }

        // Devolvemos siempre la misma instancia
        return self::$instancia;
    }

    public function get($section, $key)
    {
        return $this->data[$section][$key];
    }
}
