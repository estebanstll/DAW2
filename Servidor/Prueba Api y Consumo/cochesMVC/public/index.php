<?php

require_once "../vendor/autoload.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define("BASE_URL", "/cars/cochesMVC/public/");
define("CSS_URL", "/cars/cochesMVC/public/css/");

use Core\Router;

$router = new Router();