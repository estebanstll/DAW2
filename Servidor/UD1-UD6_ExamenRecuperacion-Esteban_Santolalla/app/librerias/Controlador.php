<?php
namespace Dwes\Clinica;

class Controlador
{
    // Cargar modelo
    private $modelo;
    private $vista;

    public function modelo(string $modelo)
    {
        // Normaliza: "articulo" -> "Articulo"
        $modeloClase = ucfirst(strtolower(trim($modelo)));

        // FQCN: \Dwes\Clinica\Articulo
        $fqcn = __NAMESPACE__ . '\\' . $modeloClase;

        // Composer autoload
        if (!class_exists($fqcn)) {
            throw new \RuntimeException("Modelo no encontrado: $fqcn");
        }

        return new $fqcn();
    }

    // Cargar vista (esta parte no la gestiona Composer normalmente)
    public function vista(string $vista, array $datos = [])
    {
        // Haces disponibles las variables para la vista:
        // $datos['titulo'] -> $titulo, etc.
        extract($datos);

        $ruta = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vistas' . DIRECTORY_SEPARATOR
            . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $vista) . '.php';

        if (is_file($ruta)) {
            require $ruta;
            return;
        }

        throw new \RuntimeException("La vista no existe: $ruta");
    }
}
