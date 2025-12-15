<?php

class GeneradorAleatorio {
    public function generarPaginas(): int {
        return random_int(50, 500);
    }

    public function generarDuracion(): int {
        return random_int(20, 120);
    }

    public function generarCalorias(): int {
        return random_int(100, 800);
    }

    public function generarEditorial(): string {
        $editoriales = ['Planeta', 'Alfaguara', 'Anaya', 'Santillana'];
        return $editoriales[array_rand($editoriales)];
    }
}
