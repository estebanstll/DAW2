<?php
use Acme\IntranetRestaurante\Core\Router;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$router = new Router();
$router->dispatch();
