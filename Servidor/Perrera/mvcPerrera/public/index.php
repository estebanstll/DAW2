<?php

require_once "../vendor/autoload.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define("BASE_URL", "/Perrera/mvcPerrera/public");
define("CSS_URL", "/Perrera/mvcPerrera/public/css/");

use Core\Router;

$router = new Router();