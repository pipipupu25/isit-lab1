<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/autoload.php';
require_once BASE_PATH . '/app/helpers.php';

use App\Core\Router;

$router = new Router();

require_once BASE_PATH . '/routes/web.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->dispatch($method, $uri);
