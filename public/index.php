<?php

require_once __DIR__ . '/../vendor/autoload.php'; 

use Src\Router\Router;

// Captura método e path
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Router lida com as rotas da API
Router::handleRequest($method, $uri);
