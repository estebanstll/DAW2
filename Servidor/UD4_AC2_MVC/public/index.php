<?php

require_once "../vendor/autoload.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define("BASE_URL", "/Servidor/UD4_AC2_MVC/public/");
define("CSS_URL", "/Servidor/UD4_AC2_MVC/public/css/");

use Core\Router;

$router = new Router();