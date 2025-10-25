<?php
// Interfaz
interface Acciones {
    public function iniciar(): void;
    public function detener(): void;
    public function actualizar(array $a): void;
}

// Superclase abstracta
abstract class Hobby implements Acciones {
    protected string $nombre;
    public static int $totalHobbys = 0;

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
        self::$totalHobbys++;
    }

    public function __destruct() {
        self::$totalHobbys--;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public static function mostrarTotal(): void {
        echo "Total hobbys activos: " . self::$totalHobbys . "<br>";
    }

    abstract public function __toString(): string;
}

// Hobby principal
class Lectura extends Hobby {
    private string $editorial;
    private int $paginas;

    public function __construct(string $nombre, string $editorial, int $paginas) {
        parent::__construct($nombre);
        $this->editorial = $editorial;
        $this->paginas = $paginas;
    }

    public function iniciar(): void {
        echo "Iniciando lectura de " . $this->nombre . "<br>";
    }

    public function detener(): void {
        echo "Deteniendo lectura de " . $this->nombre . "<br>";
    }

    public function actualizar(array $a): void {
        $this->nombre = $a['nombre'] ?? $this->nombre;
        $this->editorial = $a['editorial'] ?? $this->editorial;
        $this->paginas = $a['paginas'] ?? $this->paginas;
    }

    public function __toString(): string {
        return $this->nombre . " | Editorial: " . $this->editorial . " | Páginas: " . $this->paginas;
    }
}

// Segundo hobby
class Entrenamiento extends Hobby {
    private int $duracion;
    private int $calorias;

    public function __construct(string $nombre, int $duracion, int $calorias) {
        parent::__construct($nombre);
        $this->duracion = $duracion;
        $this->calorias = $calorias;
    }

    public function iniciar(): void {
        echo "Iniciando entrenamiento " . $this->nombre . "<br>";
    }

    public function detener(): void {
        echo "Deteniendo entrenamiento " . $this->nombre . "<br>";
    }

    public function actualizar(array $a): void {
        $this->nombre = $a['nombre'] ?? $this->nombre;
        $this->duracion = $a['duracion'] ?? $this->duracion;
        $this->calorias = $a['calorias'] ?? $this->calorias;
    }

    public function __toString(): string {
        return $this->nombre . " | Duración: " . $this->duracion . " min | Calorías: " . $this->calorias;
    }
}
