<?php
// tools/Validador.php

trait Validador
{
    public function validarTexto($txt): bool {
        return is_string($txt) && trim($txt) !== "";
    }

    public function validarEntero($num): bool {
        return filter_var($num, FILTER_VALIDATE_INT) !== false;
    }

    public function validarEmail($email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function validarBoolean($valor): bool {
        return is_bool($valor);
    }
    
    public function campoObligatorio(string $valor): bool
    {
        return trim($valor) !== '';
    }

    public function longitudEntre(string $valor, int $min, int $max): bool
    {
        $len = mb_strlen(trim($valor));
        return $len >= $min && $len <= $max;
    }
}
