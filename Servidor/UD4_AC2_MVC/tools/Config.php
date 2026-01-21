<?php
namespace Ol\Tools;

class Config {
    public static function leer() {
        return parse_ini_file(__DIR__ . '/../config/config.ini');
    }
}
?>